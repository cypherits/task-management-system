<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Marketing Visit</h2>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-bordered dt-responsive" id="visit_table">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Phone/Mobile</th>
                                        <th>Date</th>
                                        <th>Brief</th>
                                        <th>Followup Date</th>
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
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Telemarketing</h2>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-bordered dt-responsive" id="tele_table">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Phone/Mobile</th>
                                        <th>Date</th>
                                        <th>Brief</th>
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
            {responsivePriority: 2, targets: 6},
            {responsivePriority: 3, targets: 1},
            {responsivePriority: 4, targets: 4},
            {responsivePriority: 5, targets: 5},
            {responsivePriority: 6, targets: 2},
            {responsivePriority: 7, targets: 3}
        ];
        init_datatable('visit_table', '<?= base_url('marketing/getAllVisit') ?>', col, {});
        var col1 = [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 4},
            {responsivePriority: 3, targets: 1},
            {responsivePriority: 4, targets: 2},
            {responsivePriority: 5, targets: 3}
        ];
        init_datatable('tele_table', '<?= base_url('marketing/getAllTele') ?>', col1, {}, false);
    });
</script>