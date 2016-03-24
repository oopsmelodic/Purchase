


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
                                            <legend id ="iom_id" iom_id="<?php echo $data['id']; ?>"><i class="glyphicon glyphicon-send" aria-hidden="true"></i> IOM №<?php echo $data['id']; ?> </legend>
                                            <div class="form-group col-lg-12">
                                                <h4 class="col-lg-6"><legend id="user_id" user_id="<?php echo $data['employee_id'] ?>"><i class="fa fa-user"></i> <?php echo $data['fullname']; ?> </legend></h4>
                                                <h4 class="col-lg-6"><legend id="department_id" department_id="<?php echo $data['department_id'] ?>"><span class="label label-default">Department: </span> <?php echo $data['department']; ?></legend></h4>
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <div class="col-lg-6">
                                                    <h4 class="col-lg-6"><span class="label label-default">Budgets: </span></h4>
                                                    <table id="budgets"></table>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <h3 class="col-lg-4"><span class="label label-default"> Purchase: </span></h3>
                                                <div class="col-lg-12">
                                                    <textarea id="purchase_text" rows="4" style="width:100%; max-width: 100%; " class="form-control" required>
                                                        <?php echo $data['name']; ?>
                                                    </textarea>
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
<script src="/js/main/iomInfo.js" type="text/javascript"></script>
<script src="/js/main/iomShow.js" type="text/javascript"></script>