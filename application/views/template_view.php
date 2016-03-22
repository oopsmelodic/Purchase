<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Coordinator - Admin panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/jquery.treegrid.css">
    <link rel="stylesheet" href="/css/main.css">
    <link href="/css/spinner.css" rel="stylesheet" type="text/css"/>
    <link href="/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <!-- Custom Fonts -->
    <link href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/bootstrap-table.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <![endif]-->

    <!-- jQuery -->
<!--    <script src="/js/jquery.js"></script>-->
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/validator.js"></script>
    <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    <!--    <script src="/js/main/purchasePanel.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="/js/jquery.treegrid.js"></script>
    <script src="/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="/js/fileupload/fileinput.js" type="text/javascript"></script>
    <script src="/js/summernote.min.js" type="text/javascript"></script>
    <script src="/js/sortable.min.js" type="text/javascript"></script>
    //Angular Part
    <script src="/bower_components/angular/angular.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-notify-master/dist/angular-notify.min.js" type="text/javascript"></script>
    <link href="/bower_components/angular-notify-master/dist/angular-notify.min.css" rel="stylesheet" type="text/css"/>
    <script src="/bower_components/ng-notify-master/src/scripts/ng-notify.js" type="text/javascript"></script>
    <script src="/bower_components/angular-help-overlay-master/src/angular-help-overlay.js" type="text/javascript"></script>
    <link href="/bower_components/ng-notify-master/dist/ng-notify.min.css" rel="stylesheet" type="text/css"/>

    <script src="/bower_components/highcharts-4.1.9/js/highcharts.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/bootstrap-table-all.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/locale/bootstrap-table-en-US.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.js" type="text/javascript"></script>
    <script src="/bower_components/bootbox-4.4.0/bootbox.js" type="text/javascript"></script>
    <script src="/js/main/app.js" type="text/javascript"></script>
</head>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><i class="glyphicon  glyphicon-send" aria-hidden="true"></i> Coordinator</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['user']['fullname']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="/main/logout" id="logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <?php echo $data['dropdown_active']; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper" style="background-color: #E0E0E0;">
        <?php include 'application/views/'.$content_view; ?>
    </div>

</div>

</body>
</html>