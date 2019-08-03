<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Profile</h2>
                    <hr>
                    <div class="row mb-5">
                        <div class="col-12 text-center">
                            <img class="img-fluid rounded-circle" style="max-width: 300px;" src="<?= view_uploaded_image($profile_pic_id) ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <h3 class="text-primary"><?= $first_name . ' ' . $last_name ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <h4>Role</h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4><?= ucfirst($type) ?></h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4>Username</h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4><?= $username ?></h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4>Email</h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4><?= $email ?></h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4>Status</h4>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <h4><?= ucfirst($status) ?></h4>
                        </div>
                        <div class="col-12">
                            <a class="btn btn-info w-100" href="<?= base_url('users/edit/' . $id) ?>">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>