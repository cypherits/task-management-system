<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $page_title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/font-awesome/css/all.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/datetimepicker/css/datetimepicker.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/sweetalert/sweetalert.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.default.css" id="theme-stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>css/custom.css">
        <link rel="shortcut icon" href="<?= base_url('assets/') ?>img/favicon.ico">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <?php
    $user_type = $this->session->userdata('users_info')['type'];
    ?>
    <body>
        <!-- Side Navbar -->
        <nav class="side-navbar">
            <div class="side-navbar-wrapper">
                <!-- Sidebar Header    -->
                <div class="sidenav-header d-flex align-items-center justify-content-center">
                    <!-- User Info-->
                    <div class="sidenav-header-inner text-center"><a href="<?= base_url('users/profile') ?>"><img src="<?= view_uploaded_image($this->session->userdata('users_info')['profile_pic_id']) ?>" alt="person" class="img-fluid rounded-circle"></a>
                        <h2 class="h5"><?= $this->session->userdata('users_info')['first_name'] . ' ' . $this->session->userdata('users_info')['last_name'] ?></h2><span><?= strtoupper($this->session->userdata('users_info')['type']) ?></span>
                    </div>
                    <!-- Small Brand information, appears on minimized sidebar-->
                    <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>TM</strong><strong class="text-primary">S</strong></a></div>
                </div>
                <!-- Sidebar Navigation Menus-->
                <div class="main-menu">
                    <ul id="side-main-menu" class="side-menu list-unstyled">
                        <li class="<?= (isset($title) && $title == 'home') ? 'active' : '' ?>"><a href="<?= base_url() ?>"> <i class="fa fa-home"></i>Home</a></li>
                        <?php
                        if ($user_type == 'admin' || $user_type == 'client' || $user_type == 'developer') {
                            ?>
                            <li class="<?= (isset($title) && $title == 'projects') ? 'active' : '' ?>"><a href="#menu-projects" aria-expanded="<?= (isset($title) && $title == 'projects') ? 'true' : 'false' ?>" data-toggle="collapse"> <i class="fa fa-save"></i>Projects <i class="fa fa-caret-right"></i></a>
                                <ul id="menu-projects" class="collapse <?= (isset($title) && $title == 'projects') ? 'show' : '' ?> list-unstyled ">
                                    <li class="<?= (isset($subtitle) && $subtitle == 'create_project') ? 'active' : '' ?>"><a href="<?= base_url('projects/create') ?>">Create</a></li>
                                    <li class="<?= (isset($subtitle) && $subtitle == 'list_projects') ? 'active' : '' ?>"><a href="<?= base_url('projects/') ?>">List</a></li>
                                </ul>
                            </li>
                            <li class="<?= (isset($title) && $title == 'tasks') ? 'active' : '' ?>"><a href="#menu-tasks" aria-expanded="<?= (isset($title) && $title == 'tasks') ? 'true' : 'false' ?>" data-toggle="collapse"> <i class="fa fa-tasks"></i>Tasks <i class="fa fa-caret-right"></i></a>
                                <ul id="menu-tasks" class="collapse <?= (isset($title) && $title == 'tasks') ? 'show' : '' ?> list-unstyled ">
                                    <li class="<?= (isset($subtitle) && $subtitle == 'create_task') ? 'active' : '' ?>"><a href="<?= base_url('tasks/create') ?>">Create</a></li>
                                    <li class="<?= (isset($subtitle) && $subtitle == 'list_tasks') ? 'active' : '' ?>"><a href="<?= base_url('tasks/') ?>">List</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        if ($user_type == 'admin' || $user_type == 'marketing') {
                            ?>
                            <li class="<?= (isset($title) && $title == 'marketing') ? 'active' : '' ?>"><a href="#menu-marketing" aria-expanded="<?= (isset($title) && $title == 'marketing') ? 'true' : 'false' ?>" data-toggle="collapse"> <i class="fa fa-credit-card"></i>Marketing <i class="fa fa-caret-right"></i></a>
                                <ul id="menu-marketing" class="collapse <?= (isset($title) && $title == 'marketing') ? 'show' : '' ?> list-unstyled ">
                                    <li class="<?= (isset($subtitle) && $subtitle == 'visit') ? 'active' : '' ?>"><a href="<?= base_url('marketing/visit') ?>">Visit</a></li>
                                    <li class="<?= (isset($subtitle) && $subtitle == 'tele') ? 'active' : '' ?>"><a href="<?= base_url('marketing/tele') ?>">Telemarketing</a></li>
                                    <li class="<?= (isset($subtitle) && $subtitle == 'list_marketing') ? 'active' : '' ?>"><a href="<?= base_url('marketing/') ?>">List</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        if ($user_type == 'admin') {
                            ?>
                            <li class="<?= (isset($title) && $title == 'users') ? 'active' : '' ?>"><a href="#menu-users" aria-expanded="<?= (isset($title) && $title == 'users') ? 'true' : 'false' ?>" data-toggle="collapse"> <i class="fa fa-user"></i>Users <i class="fa fa-caret-right"></i></a>
                                <ul id="menu-users" class="collapse <?= (isset($title) && $title == 'users') ? 'show' : '' ?> list-unstyled ">
                                    <li class="<?= (isset($subtitle) && $subtitle == 'create_user') ? 'active' : '' ?>"><a href="<?= base_url('users/create') ?>">Create</a></li>
                                    <li class="<?= (isset($subtitle) && $subtitle == 'list_users') ? 'active' : '' ?>"><a href="<?= base_url('users/') ?>">List</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="page">
            <!-- navbar-->
            <header class="header">
                <nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-holder d-flex align-items-center justify-content-between">
                            <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars"> </i></a><a href="index.html" class="navbar-brand">
                                    <div class="brand-text d-none d-md-inline-block"><span>Task Management </span><strong class="text-primary">System</strong></div></a></div>
                            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                <!-- Notifications dropdown-->
                                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning"><?= notification_count() ?></span></a>
                                    <ul aria-labelledby="notifications" class="dropdown-menu">
                                        <?= notifications() ?>
                                    </ul>
                                </li>
                                <!-- Log out-->
                                <li class="nav-item"><a href="<?= base_url('auth/logout') ?>" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span> <i class="fa fa-sign-out-alt"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <section>