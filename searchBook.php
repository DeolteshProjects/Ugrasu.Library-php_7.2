<?php
session_start();
if (!isset($_SESSION['access'])) header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Автоматизированная система составлениня библиотечных справок</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header card-no-border fix-sidebar">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Автоматизированная система составления библиотечных справок</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">
                    <!-- Logo icon --><b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo icon -->
                        <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo"/>
                        <!-- Light Logo text -->
                         <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage"/></span> </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="sl-icon-menu"></i></a></li>
                    <li class="nav-item"><a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="sl-icon-menu"></i></a></li>
                    <!-- ============================================================== -->
                </ul>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"> <i class="icon-Bell"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                            <ul>
                                <li>
                                    <div class="drop-title">Уведомления</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="btn btn-success btn-circle"><i class="fa fa-book"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Библиотека</h5> <span class="mail-desc">Ваша библиотечная справка была принята!</span>
                                                <span class="time">9:30 AM</span></div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Показать все
                                            уведомления</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Messages -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-Mail"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown"
                             aria-labelledby="2">
                            <ul>
                                <li>
                                    <div class="drop-title">У вас новые сообщения</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <!-- Message -->
                                        <a href="#">
                                            <div class="user-img"><img src="assets/images/users/1.jpg" alt="user"
                                                                       class="img-circle"> <span
                                                        class="profile-status online pull-right"></span></div>
                                            <div class="mail-contnet">
                                                <h5>Пупкин Иван</h5> <span
                                                        class="mail-desc">Вроде пока не рабоатает!</span> <span
                                                        class="time">9:30</span></div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Показать все
                                            сообщения</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Messages -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- Profile -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown u-pro">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class=""/> <span
                                    class="hidden-md-down"><?= $_SESSION['username'] ?> &nbsp;<i
                                        class="fa fa-angle-down"></i></span> </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="assets/images/users/1.jpg" alt="user"></div>
                                        <div class="u-text">
                                            <h4><?= $_SESSION['username'] ?></h4>
                                            <p class="text-muted"><?= $_SESSION['access'] ?></p></div>
                                    </div>
                                </li>
                                <li>
                                    <button class="btn btn-block btn-outline-info" onclick="fastLogout()"><i
                                                class="fa fa-power-off"></i> Выйти
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li><a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i
                                    class="icon-Car-Wheel"></i><span class="hide-menu">Главная <span
                                        class="label label-rounded label-info">{info}</span></span></a></li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Стартовая страница</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Главная</a></li>
                        <li class="breadcrumb-item active">Стартовая страница</li>
                    </ol>
                </div>
                <div class="col-md-7 align-self-center text-right d-none d-md-block">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus-circle"></i> Создать библиотечную
                        справку
                    </button>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">Форма поиска книг</h4>
                        </div>
                        <div class="card-body">
                            <form action="searchBookResult.php" method="POST">
                                <div class="form-body">
                                    <h3 class="card-title">Введите необходимые параметры поиска</h3>
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Автор книги</label>
                                                <input type="text" id="bootAuthor" name="bookAuthor"
                                                       class="form-control" placeholder="Петров">
                                                <small class="form-control-feedback">Это человек написавший книгу
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Заглавие</label>
                                                <input type="text" id="bootTitle" name="bookTitle" class="form-control"
                                                       placeholder="Математика">
                                                <small class="form-control-feedback">Это название книги</small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Ключевые слова</label>
                                                <input type="text" id="bootKeyWord" name="bootKeyWord"
                                                       class="form-control"
                                                       placeholder="Математическая статистика">
                                                <small class="form-control-feedback">Уточнаяющие слова для поиска
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Ограничение количества поиска</label>
                                                <select class="form-control custom-select" id="bootLimit" name="bootLimit"
                                                        type="text" required>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="200">200</option>
                                                    <option value="300">300</option>
                                                    <option value="500">500</option>
                                                    <option value="1000">1000. Вы реально можете дойти до конца?
                                                    </option>
                                                    <option value="5000">5000. Вы уверены что вам действительно нужна
                                                        эта книга?
                                                    </option>
                                                </select>
                                                <small class="form-control-feedback"> От этого параметра будет зависеть
                                                    скорость загрузки результатов.
                                                </small>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <h3 class="box-title m-t-40">Место поиска</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                                <label class="control-label">База данных поиска</label>
                                                <select class="form-control custom-select" id="DataBase" name="DataBase"
                                                        type="text" required>
                                                    <option value="FOND">Библиотечный фонд</option>
                                                    <option value="ZNANIUM">База данных "Знаниум"</option>
                                                    <option value="URAIT">База данных "Юрайт"</option>
                                                    <option value="LAN">База данных "Лань"</option>
                                                    <option value="IBIS">Локальная база</option>
                                                </select>
                                                <small class="form-control-feedback"> Выберите базу данных, в которой
                                                    будет выполняться поиск.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="submit" class="btn btn-primary"><i
                                                class="fa fa-check"></i>Поиск
                                    </button>
                                    <button type="reset" class="btn btn-inverse">Сброс</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            Это текст стартовой страницы.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            © <?= date("Y") ?> Denis Shilenkov for VKR
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/node_modules/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/node_modules/bootstrap/js/popper.min.js"></script>
<script src="assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/node_modules/ps/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="assets/js/waves.js"></script>
<!--Menu sidebar -->
<script src="assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="assets/node_modules/styleswitcher/jQuery.style.switcher.js"></script>

<script src="assets/js/fast_auth.js"></script>
</body>

</html>
