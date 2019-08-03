<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary mb-3">Task Details</h2>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Task Title</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $task_title ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Status</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= ucfirst($status) ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Project Name</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $project_title ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Created By</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $created_by ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Attended By</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $attended_by ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Created At</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $created_at ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Duration</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $duration ?> Hours</strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h4><strong>Description</strong></h4></div>
                        <div class="col-12 col-md-8 col-xl-9"><h4><strong><?= $description ?></strong></h4></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-xl-3"><h3><strong>Attachments</strong></h3></div>
                        <div class="col-12 col-md-8 col-xl-9">
                            <?php
                            foreach ($attachemnts as $attach) {
                                $file_id = $attach['file_details_id'];
                                $file_name = get_file_name_by_id($file_id);
                                ?>
                                <p class="p-0 m-0"><a href="<?= base_url('upload_controller/file_download/' . $file_id) ?>" title="<?= $file_name ?>"><?= $file_name ?> <i class="fa fa-download"></i></a></p>
                                <?php
                            }
                            foreach ($comments as $comment) {
                                foreach ($comment['attachemnts'] as $attach) {
                                    $file_id = $attach['file_details_id'];
                                    $file_name = get_file_name_by_id($file_id);
                                    ?>
                                    <p class="p-0 m-0"><a href="<?= base_url('upload_controller/file_download/' . $file_id) ?>" title="<?= $file_name ?>"><?= $file_name ?> <i class="fa fa-download"></i></a></p>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <h3><strong>Discussions</strong></h3>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div id="comment-wrap">
                                <?php
                                foreach ($comments as $comment) {
                                    ?>
                                    <div class="row comment-head mb-3">
                                        <div class="col-12">
                                            <div class="media">
                                                <img class="mr-3 rounded-circle" src="<?= view_uploaded_image($comment['profile_pic_id']) ?>" style="height: 40px; width: 40px;">
                                                <div class="media-body">
                                                    <h5 class="mt-0 float-right">
                                                        <?php
                                                        foreach ($comment['attachemnts'] as $attach) {
                                                            $file_id = $attach['file_details_id'];
                                                            $file_name = get_file_name_by_id($file_id);
                                                            ?>
                                                            <a class="ml-2" href="<?= base_url('upload_controller/file_download/' . $file_id) ?>" title="<?= $file_name ?>"><i class="fa fa-download"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </h5>
                                                    <h5 class="mt-0"><?= $comment['first_name'] . ' ' . $comment['last_name'] ?><br><small class="text-muted"><?= date('d-M-Y', strtotime($comment['created_at'])) ?></small></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row comment-body">
                                        <div class="col-12">
                                            <p><?= $comment['comment'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <textarea id="comment"></textarea>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <?php
                                    foreach (get_queued_attach('discussion') as $attach) {
                                        echo '<p>' . get_file_name_by_id($attach['file_details_id']) . ' <a class="text-danger" href="' . base_url('tasks/remove_attach/' . $attach['file_details_id']) . '"><i class="fa fa-times"></i></a></p>';
                                    }
                                    ?>
                                    <button class="btn btn-secondary" type="button" onClick="return trigger_file();"><i class="fas fa-paperclip"></i>&nbsp;Attachment</button>
                                    <button class="btn btn-primary" id="add-comment">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>
<script>
    CKEDITOR.replace('comment');
    var csrf = '<?= $this->security->get_csrf_hash() ?>';
    $(document).on('click', '#add-comment', function () {
        var comment = CKEDITOR.instances.comment.getData();
        var tasks_id = <?= $id ?>;
        $.ajax({
            method: 'post',
            url: '<?= base_url('tasks/add_comment') ?>',
            data: {
                tasks_id: tasks_id,
                comment: comment,
<?= $this->security->get_csrf_token_name() ?>: csrf
            },
            beforeSend: function () {
                $('button').prop('disabled', true);
            },
            success: function (r) {
                $('button').prop('disabled', false);
                if (r.msg == 'ok') {
                    window.location.reload();
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
</script>