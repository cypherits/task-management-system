</section>
<footer class="main-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p>Intense Ltd &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
                <p>Developed by <a href="https://www.facebook.com/azim.uddin.tipu" class="external">Azim Uddin</a></p>
            </div>
        </div>
    </div>
</footer>
</div>
<?php $this->load->view('upload_controller/common_upload') ?>
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/select2/js/select2.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/moment/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datetimepicker/js/datetimepicker.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url('assets/') ?>js/front.js"></script>
<?php $this->load->view('upload_controller/uoload_script') ?>
</body>
</html>
<script>
    function notification(id, link) {
        $.ajax({
            method: 'post',
            url: '<?= base_url('dashboard/notified') ?>',
            data: {
                id: id
            },
            success: function(){
                window.location.href = link;
            }
        });
    }
</script>