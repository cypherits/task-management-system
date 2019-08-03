<?php $this->load->view('dashboard/header') ?>
<?php
$id = ($this->session->userdata('marketing_form_data') != null && isset($this->session->userdata('marketing_form_data')['id'])) ? $this->session->userdata('marketing_form_data')['id'] : 'ins';
$company_name = ($this->session->userdata('marketing_form_data') != null && isset($this->session->userdata('marketing_form_data')['company_name'])) ? $this->session->userdata('marketing_form_data')['company_name'] : '';
$contact_person = ($this->session->userdata('marketing_form_data') != null && isset($this->session->userdata('marketing_form_data')['contact_person'])) ? $this->session->userdata('marketing_form_data')['contact_person'] : '';
$company_phone = ($this->session->userdata('marketing_form_data') != null && isset($this->session->userdata('marketing_form_data')['company_phone'])) ? $this->session->userdata('marketing_form_data')['company_phone'] : '';
$brief = ($this->session->userdata('marketing_form_data') != null && isset($this->session->userdata('marketing_form_data')['brief'])) ? $this->session->userdata('marketing_form_data')['brief'] : '';
?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Market Visit</h2>
                    <hr>
                    <div class="alert alert-danger d-none"></div>
                    <form method="post" id="visit-form" action="<?= base_url('marketing/save/tele') ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>"> 
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="title">Company Name</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" value="<?= $company_name ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="title">Contact Person</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Contact Person" value="<?= $contact_person ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="title">Phone/Mobile</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <input type="tel" name="company_phone" id="company_phone" class="form-control" placeholder="Phone/Mobile" value="<?= $company_phone ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-12 col-md-6 col-xl-4" for="title">Brief</label>
                            <div class="col-12 col-md-6 col-xl-8">
                                <textarea name="brief" id="brief" class="form-control" placeholder="Brief"><?= $brief ?></textarea>
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
    $(document).on('submit', '#visit-form', function (e) {
        e.preventDefault();
        var error = false;
        var msg = '';
        var id = $('#id').val();
        var company_name = $('#company_name').val();
        var contact_person = $('#contact_person').val();
        var company_phone = $('#company_phone').val();
        var brief = $('#brief').val();
        if (company_name == '') {
            error = true;
            msg += '<p>Company Name Required</p>'
        }
        if (contact_person == '') {
            error = true;
            msg += '<p>Contact Person Required</p>'
        }
        if (company_phone == '') {
            error = true;
            msg += '<p>Phone/Mobile Required</p>'
        }
        if (brief == '') {
            error = true;
            msg += '<p>Brief Required</p>'
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
            url: '<?= base_url('marketing/save/tele') ?>',
            data: {
                id: id,
                company_name: company_name,
                contact_person: contact_person,
                company_phone: company_phone,
                brief: brief,
<?= $this->security->get_csrf_token_name() ?>: csrf
            },
            beforeSend: function () {
                $('button').prop('disabled', true);
            },
            success: function (r) {
                $('button').prop('disabled', false);
                if (r.msg == 'ok') {
                    window.location.href = '<?= base_url('marketing') ?>'
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
            url: '<?= base_url('marketing/save_form_data') ?>',
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