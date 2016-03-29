


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
                <!--                <li>-->
                <!--                    <a href="/main"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>-->
                <!--                </li>-->
                <li class="">
                    <a href="/main"><i class="fa fa-fw fa-table"></i> Purchases</a>
                </li>
                <li>
                    <a href="/admin"><i class="fa fa-fw fa-edit"></i>  User administration</a>
                </li>
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
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<script src="/js/main/newPurchase.js" type="text/javascript"></script>
<script>
    
    
    $("#input-1").fileinput({
        uploadUrl: "/php/upload.php", // server upload action
        uploadAsync: true,
        maxFileCount: 5,
        showUpload: false,
        layoutTemplates: {footer: footerTemplate}
    });
    
    
</script>