<?php $this->load->view('dashboard/header') ?>
<?php
$id = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['id'])) ? $this->session->userdata('users_form_data')['id'] : 'ins';
$first_name = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['first_name'])) ? $this->session->userdata('users_form_data')['first_name'] : '';
$last_name = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['last_name'])) ? $this->session->userdata('users_form_data')['last_name'] : '';
$username = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['username'])) ? $this->session->userdata('users_form_data')['username'] : '';
$email = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['email'])) ? $this->session->userdata('users_form_data')['email'] : '';
$password = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['password'])) ? $this->session->userdata('users_form_data')['password'] : '';
$type = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['type'])) ? $this->session->userdata('users_form_data')['type'] : '';
$status = ($this->session->userdata('users_form_data') != null && isset($this->session->userdata('users_form_data')['status'])) ? $this->session->userdata('users_form_data')['status'] : '';
?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Create User</h2>
                    <hr>
                    <div class="alert alert-danger d-none"></div>
                    <form method="post" id="user-form" action="<?= base_url('users/save') ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>"> 
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="first_name">First Name</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= $first_name ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="last_name">Last Name</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= $last_name ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="username">Username</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?= $username ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="email">Email</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= $email ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="password">Password</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?= $password ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="type">Role</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <select name="type" id="type" class="form-control">
                                    <option value="admin" <?= ($type == 'admin') ? 'selected' : '' ?>>Admin</option>
                                    <option value="developer" <?= ($type == 'developer') ? 'selected' : '' ?>>Developer</option>
                                    <option value="marketing" <?= ($type == 'marketing') ? 'selected' : '' ?>>Marketing</option>
                                    <option value="client" <?= ($type == 'client') ? 'selected' : '' ?>>Client</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="status">Status</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <select name="status" id="status" class="form-control">
                                    <option value="active" <?= ($status == 'active') ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($status == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="type">Profile Picture</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <?php
                                if ($this->session->userdata('profile_pic_id') != null) {
                                    echo '<img class="img-fluid" style="max-width: 200px" src="' . view_uploaded_image($this->session->userdata('profile_pic_id')) . '">';
                                }
                                ?>
                                <button class="btn btn-secondary" type="button" onClick="return trigger_file();"><i class="fas fa-cloud-upload-alt"></i>&nbsp;Upload</button>   
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
    $(document).on('submit', '#user-form', function (e) {
        e.preventDefault();
        var error = false;
        var msg = '';
        var id = $('#id').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var type = $('#type').val();
        var status = $('#status').val();
        if (first_name == '') {
            error = true;
            msg += '<p>First Name Required</p>'
        }
        if (last_name == '') {
            error = true;
            msg += '<p>Last Name Required</p>'
        }
        if (username == '') {
            error = true;
            msg += '<p>username Required</p>'
        }
        if (email == '') {
            error = true;
            msg += '<p>Email Required</p>'
        }
        if (id == 'ins' && password == '') {
            error = true;
            msg += '<p>Password Required</p>'
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
            url: '<?= base_url('users/save') ?>',
            data: {
                id: id,
                first_name: first_name,
                last_name: last_name,
                username: username,
                email: email,
                password: password,
                status: status,
                type: type,
<?= $this->security->get_csrf_token_name() ?>: csrf
            },
            beforeSend: function () {
                $('button').prop('disabled', true);
            },
            success: function (r) {
                $('button').prop('disabled', false);
                if (r.msg == 'ok') {
                    window.location.href = '<?= base_url('users') ?>'
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
            url: '<?= base_url('users/save_form_data') ?>',
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