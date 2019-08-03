<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Projects</h2>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <select id="clients_id" name="clients_id" class="form-control">
                                <option value="0">Select Client</option>
                                <?php
                                foreach ($clients as $client) {
                                    ?>
                                    <option value="<?= $client['id'] ?>"><?= $client['first_name'] . ' ' . $client['last_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-bordered dt-responsive" id="projects_table">
                                <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Client Name</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Description</th>
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
        var type = 0;
        var col = [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 5},
            {responsivePriority: 3, targets: 1},
            {responsivePriority: 4, targets: 4},
            {responsivePriority: 5, targets: 2},
            {responsivePriority: 6, targets: 3},
        ]
        init_datatable('projects_table', '<?= base_url('projects/getAllProjects/') ?>' + type, col, {});
        $(document).on('change', '#clients_id', function (e) {
            type = $(this).val();
            dataTablesInit['projects_table'].ajax.url('<?= base_url('projects/getAllProjects/') ?>' + type).load()
        });
    });
</script>