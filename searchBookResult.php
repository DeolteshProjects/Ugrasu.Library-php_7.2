<?php
session_start();
if (!isset($_POST['submit'])) {
    header('Location: searchBook.php');
} else {
    require('system/classes/class.irbis64_debug.php');
    require('system/classes/class.parser.php');
    $Irbis = new irbis64();
    $Parser = new ItMyParser();
    //Попытка авторизации
    $login = $Irbis->login();

    if ($login) {
        if (isset($_POST["submit"])) {
            (!empty($_POST["bookAuthor"])) ? $Author = $_POST['bookAuthor'] : $Author = null;
            (!empty($_POST["bookTitle"])) ? $Title = $_POST['bookTitle'] : $Title = null;
            (!empty($_POST["bootKeyWord"])) ? $WordKey = $_POST['bootKeyWord'] : $WordKey = null;
            (!empty($_POST["bootLimit"])) ? $Limit = $_POST['bootLimit'] : $Limit = 1;
            (!empty($_POST["DataBase"])) ? $DataBase = $_POST['DataBase'] : $DataBase = null;
        }
        $Irbis->set_db($DataBase);
        $query = $Irbis->getQuery($Author, $Title, $WordKey);
        $result = $Irbis->recordsSearch($query, $Limit, 1, "@");
        count($result['records']);
        if (count($result['records']) > 0) {
            if (count($result['records'])>$Limit) {
                for ($i = 1; $i<=$Limit; $i++) {
                    $Answer[$i] = $Parser->getSmallParse($result['records'][$i]);
                }
            } else {
                for ($i = 1; $i<=count($result['records']); $i++) {
                    $Answer[$i] = $Parser->getSmallParse($result['records'][$i]);
                }
            }
            $Limit = count($Answer);
        }
    }
}
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
                <ul id="sidebarnav">
                    <li><a class="has-arrow waves-effect waves-dark" href="searchBook.php" aria-expanded="false"><i
                                    class="fa fa-book"></i><span class="hide-menu">Поиск книг</span></a></li>
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
                        <div class="card-body">
                            <h4 class="card-title">Результаты поиска по запросу "<?= $query ?>"</h4>
                            <h6 class="card-subtitle">Найденно <?= $result['number'] ?> записей (Поиск
                                занял <?= $result['time'] ?> секунд)</h6>
                            <ul class="search-listing">
                                    <?php
                                    for ($i = 1; $i<=(count($Answer)); $i++) {
                                        echo "<li>";
                                        if (!empty($Answer[$i]['Author'])) echo "<p><h3>".$Answer[$i]['Author']."<b id='".$Answer[$i]['Id']."'> ".$DataBase."#".$Answer[$i]['Id']."</b></h3></p>";
                                        else echo "<h3>Автор неизвестен</h3>";
                                        if (!empty($Answer[$i]['SmallDescription'])) echo "<p>".$Answer[$i]['SmallDescription']."</p>";
                                        else echo "Описание недоступно неизвестен";
                                        echo "<p>Количество экземпляров в библиотеке: <i class='search-link'>".$Answer[$i]['NumberOfCopies']." шт.</i></p>";
                                        echo "<button class='btn btn-primary' id='".$i."' onclick='addToReport(".$i.")'>Добавить в справку</button> ";
                                        echo "<button class='btn btn-primary' id='".$i."' onclick='addToReport(".$i.")'>Добавить в дополнительную</button>";
                                        echo "</li>";
                                    }
                                    ?>
                            </ul>
                            <nav aria-label="Page navigation example" class="m-t-40">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Туда</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Сюда</a>
                                    </li>
                                </ul>
                            </nav>
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
<script>
    function addToReport(id) {
        var TOWN = '<?php echo $CITY;?>';
        var string = '<?php echo $Answer[1]["SmallDescription"] ?>';
        //Отключение кнопки
        document.getElementById(id).disabled = true;
        document.getElementById(id).hidden = true;
        alert("Книга была добавленна в библиотечную справку");
        alert(string);
    }
</script>
</body>

</html>
