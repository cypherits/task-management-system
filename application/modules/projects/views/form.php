<?php $this->load->view('dashboard/header') ?>
<?php
$id = ($this->session->userdata('projects_form_data') != null && isset($this->session->userdata('projects_form_data')['id'])) ? $this->session->userdata('projects_form_data')['id'] : 'ins';
$title = ($this->session->userdata('projects_form_data') != null && isset($this->session->userdata('projects_form_data')['title'])) ? $this->session->userdata('projects_form_data')['title'] : '';
$description = ($this->session->userdata('projects_form_data') != null && isset($this->session->userdata('projects_form_data')['description'])) ? $this->session->userdata('projects_form_data')['description'] : '';
$clients_id = ($this->session->userdata('projects_form_data') != null && isset($this->session->userdata('projects_form_data')['clients_id'])) ? $this->session->userdata('projects_form_data')['clients_id'] : '';
?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Create Project</h2>
                    <hr>
                    <div class="alert alert-danger d-none"></div>
                    <form method="post" id="project-form" action="<?= base_url('projects/save') ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>"> 
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
                            <label class="col-12 col-md-6 col-xl-4" for="clients_id">Client</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <select name="clients_id" id="clients_id" class="form-control">
                                    <?php
                                    foreach ($clients as $client) {
                                        ?>
                                        <option value="<?= $client['id'] ?>" <?= ($clients_id == $client['id']) ? 'selected' : '' ?>><?= $client['first_name'] . ' ' . $client['last_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
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
    $(document).on('submit', '#project-form', function (e) {
        e.preventDefault();
        var error = false;
        var msg = '';
        var id = $('#id').val();
        var title = $('#title').val();
        var description = $('#description').val();
        var clients_id = $('#clients_id').val();
        if (title == '') {
            error = true;
            msg += '<p>Title Required</p>'
        }
        if (description == '') {
            error = true;
            msg += '<p>Description Required</p>'
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
            url: '<?= base_url('projects/save') ?>',
            data: {
                id: id,
                title: title,
                description: description,
                clients_id: clients_id,
<?= $this->security->get_csrf_token_name() ?>: csrf
            },
            beforeSend: function () {
                $('button').prop('disabled', true);
            },
            success: function (r) {
                $('button').prop('disabled', false);
                if (r.msg == 'ok') {
                    window.location.href = '<?= base_url('projects') ?>'
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
            url: '<?= base_url('projects/save_form_data') ?>',
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
    $(document).on('change', 'select', function () {
        var name = $(this).attr('name');
        var value = $(this).val();
        save_form_data(name, value);
    });
</script>