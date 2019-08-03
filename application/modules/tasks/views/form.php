<?php $this->load->view('dashboard/header') ?>
<?php
$id = ($this->session->userdata('tasks_form_data') != null && isset($this->session->userdata('tasks_form_data')['id'])) ? $this->session->userdata('tasks_form_data')['id'] : 'ins';
$title = ($this->session->userdata('tasks_form_data') != null && isset($this->session->userdata('tasks_form_data')['title'])) ? $this->session->userdata('tasks_form_data')['title'] : '';
$description = ($this->session->userdata('tasks_form_data') != null && isset($this->session->userdata('tasks_form_data')['description'])) ? $this->session->userdata('tasks_form_data')['description'] : '';
$projects_id = ($this->session->userdata('tasks_form_data') != null && isset($this->session->userdata('tasks_form_data')['projects_id'])) ? $this->session->userdata('tasks_form_data')['projects_id'] : '';
$priority = ($this->session->userdata('tasks_form_data') != null && isset($this->session->userdata('tasks_form_data')['priority'])) ? $this->session->userdata('tasks_form_data')['priority'] : '';
?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Create Task</h2>
                    <hr>
                    <div class="alert alert-danger d-none"></div>
                    <form method="post" id="tasks-form" action="<?= base_url('tasks/save') ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="clients_id">Select Project</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <select name="projects_id" id="projects_id" class="form-control">
                                    <option value="">Select Project</option>
                                    <?php
                                    foreach ($projects as $project) {
                                        ?>
                                        <option value="<?= $project['id'] ?>" <?= ($projects_id == $project['id']) ? 'selected' : '' ?>><?= $project['title'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="title">Title</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?= $title ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="description">Description</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <textarea type="text" name="description" id="description" class="form-control" placeholder="Description"><?= $description ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="priority">Priority</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <select name="priority" id="priority" class="form-control">
                                    <option value="high" <?= ($priority == 'high') ? 'selected' : '' ?>>High</option>
                                    <option value="medium" <?= ($priority == 'medium') ? 'selected' : '' ?>>Medium</option>
                                    <option value="low" <?= ($priority == 'low') ? 'selected' : '' ?>>Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="type">Attachment</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <button class="btn btn-secondary" type="button" onClick="return trigger_file();"><i class="fas fa-cloud-upload-alt"></i>&nbsp;Upload</button>

                                <?php
                                foreach (get_queued_attach('tasks') as $attach) {
                                    echo '<p>' . get_file_name_by_id($attach['file_details_id']) . ' <a class="text-danger" href="' . base_url('tasks/remove_attach/' . $attach['file_details_id']) . '"><i class="fa fa-times"></i></a></p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>
<script>
    var csrf = '<?= $this->security->get_csrf_hash() ?>';
    $(document).on('submit', '#tasks-form', function (e) {
        e.preventDefault();
        var error = false;
        var msg = '';
        var id = $('#id').val();
        var title = $('#title').val();
        var description = $('#description').val();
        var projects_id = $('#projects_id').val();
        var priority = $('#priority').val();
        if (title == '') {
            error = true;
            msg += '<p>Title Required</p>'
        }
        if (description == '') {
            error = true;
            msg += '<p>Description Required</p>'
        }

        if (projects_id == '') {
            error = true;
            msg += '<p>Project Required</p>'
        }
        if (error) {
            $('.alert').html(msg).removeClass('d-none');
            setTimeout(function () {
                $('.alert').addClass('d-none');
            }, 5000);
            return false;
        }
        $.ajax({
            method: 'post',
            url: '<?= base_url('tasks/save') ?>',
            data: {
                id: id,
                title: title,
                description: description,
                projects_id: projects_id,
                priority: priority,
<?= $this->security->get_csrf_token_name() ?>: csrf
            },
            beforeSend: function () {
                $('button').prop('disabled', true);
            },
            success: function (r) {
                $('button').prop('disabled', false);
                if (r.msg == 'ok') {
                    window.location.href = '<?= base_url('tasks') ?>'
                } else {
                    csrf = r.csrf;
                    $('.alert').html(r.msg).removeClass('d-none');
                    setTimeout(function () {
                        $('.alert').addClass('d-none');
                    }, 5000);
                }
            }
        });
    });
    function save_form_data(name, value) {
        $.ajax({
            method: 'post',
            url: '<?= base_url('tasks/save_form_data') ?>',
            data: {
                name: name,
                value: value
            },
            success: function (r) {

            }
        });
    }
    $(document).on('focusout', 'input', function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        save_form_data(name, value);
    });
    $(document).on('focusout', 'textarea', function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        save_form_data(name, value);
    });
    $(document).on('change', 'select', function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        save_form_data(name, value);
    });
</script>