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

                                <div class="col-lg-6">
                                    <div class="col-lg-12 shadow" style="padding:15px;">
                                        <legend><i class="glyphicon glyphicon-send" aria-hidden="true"></i> Profile info</legend>
                                        <div class="form-group col-lg-12">
                                            <h4 class="col-lg-6"><legend><i class="fa fa-user"></i> <?php echo $data['employee']['fullname']; ?> </legend></h4>
                                            <h4 class="col-lg-6">
                                                <legend><span class="label label-default">Department:</span> <?php echo $data['employee']['department']; ?></legend><br>
                                                <legend><span class="label label-default">Position:</span> <?php echo $data['employee']['position']; ?></legend>
                                            </h4>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <h4 class="col-lg-6"><legend><i class="fa fa-envelope"></i> <?php echo $data['employee']['email']; ?> </legend></h4>
                                            <h4 class="col-lg-6"><legend><span class="label label-default">Role:</span> <?php echo $data['employee']['role_name']; ?></legend></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-12 shadow" style="padding:15px;">
                                        <legend><i class="fa fa-cog" aria-hidden="true"></i> Settings</legend>
                                        <form class="form-horizontal" id="saveForm">
                                            <div class="col-lg-12">
                                                <h4 class="col-lg-12">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id="email" <?php echo ($data['settings']['email'] == 1 ? "checked" : "") ?>>Email notification</label>
                                                    </div>
                                                </h4>
                                            </div>
                                            <div class="col-lg-12">
                                                <h4 class="col-lg-12">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id="stay_login" <?php echo ($data['settings']['stay_login'] == 1 ? "checked" : "") ?>>Stay login</label>
                                                    </div>
                                                </h4>
                                            </div>
                                            <div class="col-lg-3  col-lg-offset-9">
                                                <button type="submit" class="btn btn-success">Save changes</div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
<script src="/js/main/profile.js" type="text/javascript"></script>