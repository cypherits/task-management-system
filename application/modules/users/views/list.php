<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Users</h2>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <select id="users-type" name="users_type" class="form-control">
                                <option value="">Filter By Role</option>
                                <option value="admin">Admin</option>
                                <option value="developer">Developer</option>
                                <option value="marketing">Marketing</option>
                                <option value="client">Client</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-bordered dt-responsive" id="users_table">
                                <thead>
                                    <tr>
                                        <th>User's Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
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
        var col = [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 5},
            {responsivePriority: 3, targets: 3},
            {responsivePriority: 4, targets: 4},
            {responsivePriority: 5, targets: 2},
            {responsivePriority: 6, targets: 1},
        ]
        init_datatable('users_table', '<?= base_url('users/getAllUsers') ?>', col, {});
        $(document).on('change', '#users-type', function (e) {
            var type = $(this).val();
            dataTablesInit['users_table'].ajax.url('<?= base_url('users/getAllUsers/') ?>' + type).load()
        });
    });
</script>