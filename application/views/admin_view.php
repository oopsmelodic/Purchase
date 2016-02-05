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
            <a class="navbar-brand" href="index.html"><i class="glyphicon  glyphicon-send" aria-hidden="true"></i> Coordinator</a>
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
                <li>
                    <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="tables.php"><i class="fa fa-fw fa-table"></i> Purchases</a>
                </li>
                <li class="active">
                    <a href="forms.php"><i class="fa fa-fw fa-edit"></i>  User administration</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper" style="background-color: #E0E0E0;">

        <div class="container-fluid">

            <!-- Page Heading -->

            <!-- /.row -->

            <div class="row" style="margin-top:10px;">
                <div class="col-lg-12" style="padding:0px;">
                    <div class="col-lg-12">
                        <div class="col-lg-12 shadow" style="padding:20px 20px 0px 20px;">
                            <form class="form-horizontal " autocomplete="off">
                                <fieldset>
                                    <legend>
                                        <button class="btn btn-success btn-sm ndisp" style="display:inline; margin-bottom: 3px;" id="showPanel"><i class="glyphicon glyphicon-arrow-down" aria-hidden="true"></i></button>
                                        Create new user
                                    </legend>
                                    <div  id="userPanel" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="form-group has-error">
                                                <label for="usernick" class="col-lg-3 control-label">Username</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="usernick" placeholder="Username" autocomplete="off">
                                                    <span class="help-block" id="usercontroll">Minimum of 3 characters</span>
                                                </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label for="userMail" class="col-lg-3 control-label">E-mail</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="userMail" placeholder="E-mail" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label for="userName" class="col-lg-3 control-label">Name</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="userName" placeholder="Name" autocomplete="off">
                                                    <span class="help-block">Only letters</span>
                                                </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label for="userSecondname" class="col-lg-3 control-label">Second name</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="userSecondname" placeholder="Second name" autocomplete="off">
                                                    <span class="help-block">Only letters</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="department" class="col-lg-3 control-label">Department</label>
                                                <div class="col-lg-9">
                                                    <select class="selectpicker" id="departments" data-width="100%" style="display:inline;">
                                                        <?php 
                                                            echo $data['departments'];
                                                        ?>        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group has-error">
                                                <label for="userPosition" class="col-lg-3 control-label">Position</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="userPosition" placeholder="Position" autocomplete="off">
                                                    <span class="help-block">Only letters</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="role" class="col-lg-3 control-label">Role</label>
                                                <div class="col-lg-9">
                                                    <select class="selectpicker" id="roles" data-width="100%" style="display:inline;">
                                                        <?php
                                                        echo $data['roles'];
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group has-error">
                                                <label for="inputPassword" class="col-lg-3 control-label">Password</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off">
                                                    <span class="help-block">Minimum of 6 characters</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button  class="btn btn-success disabled" id="addUser" style="width:100%;">Add user</button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12 shadow" style="margin-top:10px;">
                            <div class="table-responsive">
                                <table id="testtable" class="table table-bordered" style="table-layout:fixed; margin-bottom: 0px; margin-right: 10px;">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="/js/main/adminPanel.js" type="text/javascript"></script>