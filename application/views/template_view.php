<!DOCTYPE html>
<html lang="en" ng-app="mainApp">

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
    <link rel="stylesheet" href="/css/main.css?v1332">
    <link href="/css/spinner.css" rel="stylesheet" type="text/css"/>
    <link href="/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <!-- Custom Fonts -->
    <link href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/bootstrap-table.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/ng-table-master/dist/ng-table.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
<!--    <![endif]-->

    <!-- jQuery -->
<!--    <script src="/js/jquery.js"></script>-->
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/validator.js"></script>
    <script src="/js/date.js"></script>
    <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    <!--    <script src="/js/main/purchasePanel.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="/js/jquery.treegrid.js"></script>
    <script src="/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="/js/fileupload/fileinput.js" type="text/javascript"></script>
    <script src="/bower_components/tinymce/tinymce.min.js" type="text/javascript"></script>
    <script src="/js/sortable.min.js" type="text/javascript"></script>
    <script src="/js/FileSaver.js" type="text/javascript"></script>
    <script src="/js/Blob.js" type="text/javascript"></script>
<!--    Angular Part-->
    <script src="/bower_components/angular/angular.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-resource/angular-resource.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-route/angular-route.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-help-overlay-master/src/angular-help-overlay.js" type="text/javascript"></script>
    <script src="/bower_components/angular-notification-master/angular-notification.min.js" type="text/javascript"></script>
    <script src="/bower_components/Smart-Table-master/dist/smart-table.min.js" type="text/javascript"></script>
    <script src="/js/ui-bootstrap-tpls-1.2.5.js" type="text/javascript"></script>
    <script src="/bower_components/ng-table-master/dist/ng-table.min.js" type="text/javascript"></script>

    <script src="/bower_components/Highstock-5.0.12/code/highstock.js" type="text/javascript"></script>
<!--    <script src="/bower_components/highcharts-4.1.9/js/highcharts.js" type="text/javascript"></script>-->
    <script src="/bower_components/bootstrap-table-master/bootstrap-table-all.js" type="text/javascript"></script>
    <script type="text/javascript" src="/bower_components/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
    <script type="text/javascript" src="/bower_components/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
    <script type="text/javascript" src="/bower_components/tableExport.jquery.plugin-master/libs/html2canvas/html2canvas.min.js"></script>
    <script type="text/javascript" src="/bower_components/tableExport.jquery.plugin-master/tableExport.min.js"></script>
    <script src="/bower_components/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.js" type="text/javascript"></script>
<!--    <script src="/bower_components/bootstrap-table-master/extensions/filter-control/bootstrap-table-filter-control.js" type="text/javascript"></script>-->
    <script src="/bower_components/bootstrap-table-master/locale/bootstrap-table-en-US.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/filter-control/bootstrap-table-filter-control.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/export/bootstrap-table-export.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/sticky-header/bootstrap-table-sticky-header.min.js" type="text/javascript"></script>
    <script src="/bower_components/bootbox-4.4.0/bootbox.js" type="text/javascript"></script>
    <script src="/js/main/app.js" type="text/javascript"></script>
</head>

<body lang="en">
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top" role="navigation" ng-controller="myNotify">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/img/logo.png" style="display: inline-block;" height="30"> IOM Tracking System</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li>
                <a href="#" popover-placement="bottom" popover-trigger="focus" uib-popover-html="htmlPopover" popover-title="Last Alerts"><i class="fa fa-fw fa-bell"></i> </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/img/default-user-image.png" class="img-circle img-user" department_id="<?php echo $_SESSION['user']['department_id']?>" user_id="<?php echo $_SESSION['user']['id']?>"> <?php echo $_SESSION['user']['fullname']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="disabled">
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <li  class="disabled">
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
<!--        --><?php //print_r($data)?>
    </div>

</div>

<script src="/js/main/createPurchase.js?<?php echo $data['script_version']?>" type="text/javascript"></script>

<script>
    var footerTemplate = '<div class="file-thumbnail-footer">\n' +
        '   <div style="margin:5px 0">\n' +
        '       <input name="input_comment" class="kv-input form-control input-sm kv-new" value="{caption}" placeholder="Enter caption...">\n' +
        '   </div>\n' +
        '   {actions}\n' +
        '</div>';
    $("#input-1").fileinput({
        uploadUrl: "/php/upload.php", // server upload action
        uploadAsync: true,
        maxFileCount: 5,
        showUpload:false,
        dropZoneEnabled:false,
        allowedFileTypes: ['png','pdf','xls','xlsx','jpg','jpeg','bmp','doc','docx','txt','msg'],
        layoutTemplates: {footer: footerTemplate},
        uploadExtraData: function () {  // callback example
            var out = {}, key, i = 0;
            $('.kv-input:visible').each(function () {
                $el = $(this);
                key = 'new_' + i;
                out[key] = $el.val();
                i++;
            });
            return out;
        }
    });

</script>
</body>
</html>