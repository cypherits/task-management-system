<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary mb-3">Task Details</h2>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Company Name</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $company_name ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Contact Person</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $contact_person ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Visited By</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= get_user_name_by_id($users_id) ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Company Address</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $company_address ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Phone/Mobile</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $company_phone ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Email</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $company_email ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Website</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $company_website ?> Hours</strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Brief</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $brief ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Visited At</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= date('d-M-Y', strtotime($created_at)) ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Followup At</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= date('d-M-Y', strtotime($followup_date)) ?></strong></h4></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>