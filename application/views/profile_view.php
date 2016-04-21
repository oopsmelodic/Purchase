

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
                                                    <label><input type="checkbox" id="email" <?php echo ($data['settings']['email'] ? "checked" : "") ?>>Email notification</label>
                                                </div>
                                            </h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <h4 class="col-lg-12">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" id="stay_login" <?php echo ($data['settings']['stay_login'] ? "checked" : "") ?>>Stay login</label>
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

<script src="/js/main/profile.js" type="text/javascript"></script>