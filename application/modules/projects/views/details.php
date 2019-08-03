<?php $this->load->view('dashboard/header') ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 col-xl-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary mb-3">Project Details</h2>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-xl-4" for="title"><h3><strong>Project Name</strong></h3></div>
                        <div class="col-12 col-md-6 col-xl-8"><h3><strong><?= $name ?></strong></h3></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-xl-4" for="title"><h3><strong>Clients Name</strong></h3></div>
                        <div class="col-12 col-md-6 col-xl-8"><h3><strong><?= $clients_name ?></strong></h3></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-xl-4" for="title"><h3><strong>Project Description</strong></h3></div>
                        <div class="col-12 col-md-6 col-xl-8"><h3><strong><?= $description ?></strong></h3></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Tasks On Queue: <?= $queued['count'] ?></h2>
                    <h3>Recently Queued Tasks</h3>
                    <ul class="list-group">
                        <?php
                        foreach ($queued['tasks'] as $task) {
                            echo '<li class="list-group-item">' . $task['title'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Tasks On Progress: <?= $ongoing['count'] ?></h2>
                    <h3>On Progress Tasks</h3>
                    <ul class="list-group">
                        <?php
                        foreach ($ongoing['tasks'] as $task) {
                            echo '<li class="list-group-item">' . $task['title'] . '<br><small>by ' . get_user_name_by_id($task['asign_to']) . '</small></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-primary">Tasks Completed: <?= $completed['count'] ?></h2>
                    <h3>Recently Completed Tasks</h3>
                    <ul class="list-group">
                        <?php
                        foreach ($completed['tasks'] as $task) {
                            echo '<li class="list-group-item">' . $task['title'] . '<br><small>by ' . get_user_name_by_id($task['asign_to']) . '</small></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/footer') ?>