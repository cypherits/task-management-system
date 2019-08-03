<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Tasks</h2>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <select id="projects_id" name="projects_id" class="form-control">
                                <option value="0">Select Project</option>
                                <?php
                                foreach ($projects as $project) {
                                    ?>
                                    <option value="<?= $project['id'] ?>"><?= $project['title'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-bordered dt-responsive" id="tasks_table">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Task</th>
                                        <th>Created By</th>
                                        <th>Priority</th>
                                        <th>Duration</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>
<script>
    $(document).ready(function () {
        var csrf = '<?= $this->security->get_csrf_hash() ?>';
        var projects_id = 0;
        var col = [
            {responsivePriority: 1, targets: 1},
            {responsivePriority: 2, targets: 6},
            {responsivePriority: 3, targets: 7},
            {responsivePriority: 4, targets: 0},
            {responsivePriority: 5, targets: 3},
            {responsivePriority: 6, targets: 4},
            {responsivePriority: 7, targets: 2},
            {responsivePriority: 8, targets: 5},
        ]
        init_datatable('tasks_table', '<?= base_url('tasks/getAllTasks/') ?>' + projects_id, col, {});
        $(document).on('change', '#projects_id', function (e) {
            projects_id = $(this).val();
            dataTablesInit['tasks_table'].ajax.url('<?= base_url('tasks/getAllTasks/') ?>' + projects_id).load();
        });
        $(document).on('click', '.attend', async function (e) {
            const {value: duration} = await Swal.fire({
                title: 'Task Duration',
                html:
                        '<input id="swal-input1" type="number" class="swal2-input" placeholder="Task Duration">',
                focusConfirm: false,
                preConfirm: () => {
                    return document.getElementById('swal-input1').value
                }
            });

            if (duration) {
                var tasks_id = $(this).attr('data-id');
                $.ajax({
                    method: 'post',
                    url: '<?= base_url('tasks/attend') ?>',
                    data: {
                        tasks_id: tasks_id,
                        duration: duration,
<?= $this->security->get_csrf_token_name() ?>: csrf
                    },
                    beforeSend: function () {
                        $('button').prop('disabled', true);
                    },
                    success: function (r) {
                        $('button').prop('disabled', false);
                        if (r.msg == 'ok') {
                            dataTablesInit['tasks_table'].ajax.url('<?= base_url('tasks/getAllTasks/') ?>' + $('#projects_id').val()).load()
                        } else {
                            $('.alert').html(r.msg).removeClass('d-none');
                            setTimeout(function () {
                                $('.alert').addClass('d-none');
                            }, 5000);
                        }
                        csrf = r.csrf;
                    }
                });
            }


        });
        $(document).on('click', '.complete', function (e) {
            var tasks_id = $(this).attr('data-id');
            $.ajax({
                method: 'post',
                url: '<?= base_url('tasks/complete') ?>',
                data: {
                    tasks_id: tasks_id,
<?= $this->security->get_csrf_token_name() ?>: csrf
                },
                beforeSend: function () {
                    $('button').prop('disabled', true);
                },
                success: function (r) {
                    $('button').prop('disabled', false);
                    if (r.msg == 'ok') {
                        dataTablesInit['tasks_table'].ajax.url('<?= base_url('tasks/getAllTasks/') ?>' + $('#projects_id').val()).load()
                    } else {
                        $('.alert').html(r.msg).removeClass('d-none');
                        setTimeout(function () {
                            $('.alert').addClass('d-none');
                        }, 5000);
                    }
                    csrf = r.csrf;
                }
            });

        });
    });
</script>