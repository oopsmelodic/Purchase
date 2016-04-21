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
        <!--    <![endif]-->-->

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
        <script src="/bower_components/angular-help-overlay-master/src/angular-help-overlay.js" type="text/javascript"></script>
        <script src="/bower_components/angular-notification-master/angular-notification.min.js" type="text/javascript"></script>
        <script src="/bower_components/Smart-Table-master/dist/smart-table.min.js" type="text/javascript"></script>
        <script src="/js/ui-bootstrap-tpls-1.2.5.js" type="text/javascript"></script>

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
                    <li>
                        <a href="#" popover-placement="bottom" popover-trigger="mouseenter" uib-popover-html="htmlPopover" popover-title="New Alerts!"><i class="fa fa-fw fa-bell"></i> </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/img/default-user-image.png" class="img-circle img-user"> <?php echo $_SESSION['user']['fullname']; ?> <b class="caret"></b></a>
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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12" style="padding:0px;">
                            <div class="tab-content" >
                                <div id="home" class="tab-pane fade in active">
                                    <div class="col-lg-12">
                                        <form class="form-horizontal " autocomplete="off" id="purchase_form"  data-toggle="validator">
                                            <fieldset>
                                                <div class="col-lg-8 shadow" style="padding:20px 20px 0px 20px;">
                                                    <legend><i class="glyphicon glyphicon-send" aria-hidden="true"></i> New application for purchase</legend>
                                                    <div class="form-group col-lg-12">
                                                        <h4 class="col-lg-6"><legend id="user_id" user_id="<?php echo $data['user_id'] ?>"><i class="fa fa-user"></i> <?php echo $data['fullname']; ?> </legend></h4>
                                                        <h4 class="col-lg-6"><legend id="department_id" department_id="<?php echo $data['department_id'] ?>"><span class="label label-default">Department:</span> <?php echo $data['department']; ?></legend></h4>
                                                    </div>
                                                    <div class="col-lg-12 form-group">
                                                        <div class="col-lg-6">
                                                            <h4 class="col-lg-6"><span class="label label-default">Budgets: </span></h4>
                                                            <select id="budget_select" data-live-search="true" data-minlength="1" data-selector="true" class="selectpicker form-control" data-width="100%" multiple data-selected-text-format="count">
                                                                <?php echo $data['budgets']; ?>
                                                            </select>
                                                            <span class="help-block with-errors"></span>
                                                            <!--                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                        </div>
                                                        <div class="col-lg-6" id="budget_inputs">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 form-group">
                                                        <div class="col-lg-6">

                                                            <h4 class="col-lg-6"><span class="label label-default">Expense size: </span></h4>
                                                            <input id="expense" class="form-control" type="number" min="0" data-minlength="1" required>
        <!--                                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                            <span class="help-block with-errors"></span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <div>
                                                            <h3 class="col-lg-4"><span class="label label-default"> Purchase: </span></h3>
                                                            <div class="col-lg-12">
                                                                <textarea id="purchase_text" rows="4" style="width:100%; max-width: 100%;" class="form-control" required></textarea>
                                                                <span class="help-block with-errors"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h3 class="col-lg-6"><span class="label label-default"> Substantiation: </span></h3>
                                                        <div class="col-lg-12">
                                                            <textarea name="summernote" id="summernote" cols="10" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h3 class="col-lg-4"><span class="label label-default"> Files: </span></h3>
                                                        <div class="col-lg-12">
                                                            <input id="input-1" multiple type="file" class="file file-loading" data-allowed-file-extensions='["txt","jpg","tif","doc","pdf","webm"]'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="col-lg-12 shadow" style="padding-top:15px;">
                                                        <ul class="list-group" id="chain_list">
                                                            <li class="list-group-item">
                                                                <h5 class="list-group-item-heading">1. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Department leader</h5>
                                                                <div class="col-lg-9 form-group">
                                                                    <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>
                                                                        <?php echo implode('', $data['roles']['Department leader']); ?>
                                                                    </select>
                                                                    <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                                    <span class="help-block with-errors"></span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <h5 class="list-group-item-heading">2. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial</h5>
                                                                <div class="col-lg-9  form-group">
                                                                    <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>
                                                                        <?php echo implode('', $data['roles']['Financial']); ?>
                                                                    </select>
                                                                    <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                                    <span class="help-block with-errors"></span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <h5 class="list-group-item-heading">3. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial controller</h5>
                                                                <div class="col-lg-9  form-group">
                                                                    <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>
                                                                        <?php echo implode('', $data['roles']['Financial controller']); ?>
                                                                    </select>
                                                                    <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                                    <span class="help-block with-errors"></span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <h5 class="list-group-item-heading">4. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial director</h5>
                                                                <div class="col-lg-9  form-group">
                                                                    <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>
                                                                        <?php echo implode('', $data['roles']['Financial director']); ?>
                                                                    </select>
                                                                    <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                                                    <span class="help-block with-errors"></span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <h5 class="list-group-item-heading">5. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> General director</h5>
                                                                <div class="col-lg-9  form-group">
                                                                    <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>
                                                                        <?php echo implode('', $data['roles']['General director']); ?>
                                                                    </select>
                                                                    <span class="help-block with-errors"></span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="form-group col-lg-12">
                                                            <button type="submit" id="create2purch" class="btn btn-success disabled" style="width:100%; margin-bottom: 15px;">Create application for purchase</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                                <div id="menu2" class="tab-pane fade">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->


                <script src="/js/main/newPurchase.js" type="text/javascript"></script>
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
                        showUpload: false,
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

            </div>

        </div>

    </body>
</html>