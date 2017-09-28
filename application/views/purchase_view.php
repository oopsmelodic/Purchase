
<div class="container-fluid"  ng-app="mainApp" ng-controller="myNotify">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12" style="padding:0px;">
            <ul class="nav nav-pills" style="margin-bottom: 15px; display: none;">
                <li class="active"><a data-toggle="pill" href="#home">My active appliements</a></li>
<!--                <li class=""><a data-toggle="pill" href="#menu2">My active 123</a></li>-->
            </ul>
            <div class="tab-content" >
                <div id="home" class="tab-pane fade in active" style="min-height: 500px;">
                    <div class="col-lg-12 shadow">
                        <div id="toolbar">
                            <a id="newPurchase" href="#" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i> New IOM
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="testtable" class="table table-striped table-bordered" style="table-layout:fixed; margin-bottom: 0px; margin-right: 10px;">
                            </table>
                        </div>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <div class='row'>
                        <div class='column'>
<!--                                <div class='comments' ng-controller='CommentsCtrl'>-->
<!--                                    <form>-->
<!--                                        <fieldset>-->
<!--                                            <legend>-->
<!--                                                Your comment-->
<!--                                            </legend>-->
<!--                                            <div>-->
<!--                                                <label>-->
<!--                                                    Name:-->
<!--                                                    <input ng-model='name' type='text'>-->
<!--                                                </label>-->
<!--                                            </div>-->
<!--                                            <div>-->
<!--                                                <label>-->
<!--                                                    Comment:-->
<!--                                                    <textarea ng-model='text'></textarea>-->
<!--                                                </label>-->
<!--                                            </div>-->
<!--                                            <div>-->
<!--                                                <input class='button' ng-click='submit()' type='submit' value='Submit'>-->
<!--                                            </div>-->
<!--                                        </fieldset>-->
<!--                                    </form>-->
<!--                                    <h3>-->
<!--                                        {{comments.length}} Comments-->
<!--                                    </h3>-->
<!--                                    <ul>-->
<!--                                        <li ng-repeat='comment in comments'>-->
<!--                                            <div class='comment' ng-class='{approved: comment.approved}'>-->
<!--                                                <h5>-->
<!--                                                    {{comment.name}}:-->
<!--                                                </h5>-->
<!--                                                <div>-->
<!--                                                    {{comment.text}}-->
<!--                                                </div>-->
<!--                                                <p>-->
<!--                                                    <small>-->
<!--                                                        <a ng-click='approve(comment)' ng-hide='comment.approved'>-->
<!--                                                            approve comment-->
<!--                                                            |-->
<!--                                                        </a>-->
<!--                                                        <a ng-click='drop(comment)'>-->
<!--                                                            delete comment-->
<!--                                                        </a>-->
<!--                                                    </small>-->
<!--                                                </p>-->
<!--                                            </div>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<div class="container left" id="myWizard">
    <br>
    <legend iom_id="" id="legend_iom">Create Application</legend><button id="myWizardMini" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
    <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4" style="width: 20%;">
            Step 1 of 3
        </div>
    </div>
    <div class="form-group col-lg-12">
        <h4 class="col-lg-12"><legend id="user_id" user_id="0"><i class="fa fa-user"></i> <?php echo $data['fullname'] ?> from <?php echo $data['department'] ?> department.</legend></h4>
    </div>
    <div class="navbar">
        <div class="navbar-inner">
            <ul class="nav nav-pills">
                <li class="active disabled"><a href="#step1" data-toggle="tab" data-step="1">Step 1</a></li>
                <li class="disabled"><a href="#step2" data-toggle="tab" data-step="2">Step 2</a></li>
                <li class="disabled"><a href="#step3" data-toggle="tab" data-step="3">Step 3</a></li>
                <li class="disabled"><a href="#step4" data-toggle="tab" data-step="4">Step 4</a></li>
                <!--                    <li><a href="#step3" data-toggle="tab" data-step="3">Step 5</a></li>-->
            </ul>
        </div>
    </div>
    <div class="tab-content"  style="height: inherit;">
        <form class="tab-pane fade in active step" lang="en" id="step1">

            <div class="well">
                <label>IOM Name: </label>
                <input id="purchase_text" rows="4" style="width:100%; max-width: 100%; " class="form-control" required>
                <span class="help-block with-errors"></span>
                <label>Description: </label>
                <textarea name="summernote" id="summernote" cols="10" rows="10"><br></textarea>
                <!--                <span class="help-block with-errors"></span>-->
            </div>
            <div class="step-footer form-group">
                <button type="submit" class="btn btn-default btn-lg next" href="#">Continue</button>
                <!--                    <button class="btn btn-warning btn-lg back" href="#">Back</button>-->
                <button class="btn btn-danger btn-lg first" href="#">Cancel</button>
            </div>
        </form>
        <form class="tab-pane fade step" id="step2">

            <div class="form-group col-lg-12 step-body">
                <div class="col-lg-12">
                    <label>Budgets: </label>
                    <!--                    <select id="budget_select" data-live-search="true" data-minlength="1" data-selector="true" class="selectpicker form-control" data-width="100%" multiple data-selected-text-format="count" required>-->
                    <!--                    </select>-->
                    <table id="purchase_budget_table"></table>
                </div>
                <div class="col-lg-12">
                    <label>Ioms: </label>
                    <table id="purchase_iomsource_table"></table>
                </div>
            </div>
            <div class="step-footer form-group">
                <button  type="submit" class="btn btn-default btn-lg next" href="#">Continue</button>
                <button class="btn btn-warning btn-lg back" href="#">Back</button>
                <button class="btn btn-danger btn-lg first" href="#">Cancel</button>
            </div>

        </form>
        <form class="tab-pane fade step" id="step3">
            <div class="form-group col-lg-12 step-body">
                <select id="saved_chain" class="selectpicker" data-width="20%" data-selected-text-format="count">
                    <?php echo $data['chain'];?>
                </select>
                <button id="load_chain" class="btn btn-success"><i class="glyphicon glyphicon-collapse-up"></i>&nbsp; Fill</button>
                <button id="save_chain" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Save</button>
                <button id="delete_chain" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;Delete</button>
                <ul class="list-group" id="chain_list">
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">1. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Department Leader #1</h5>
                        <div class="col-lg-9 form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['Department leader']);?>
                            </select>
                            <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">2. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Department Leader #2</h5>
                        <div class="col-lg-9  form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['Department leader']);?>
                            </select>
                            <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->

                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">3. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Finance Analyst</h5>
                        <div class="col-lg-9  form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['Finance Analyst']);?>
                            </select>
                            <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->

                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">4. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Finance Controller</h5>
                        <div class="col-lg-9  form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['Finance Controller']);?>
                            </select>
                            <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->

                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">5. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Finance Director</h5>
                        <div class="col-lg-9  form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['Finance Director']);?>
                            </select>
                            <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->

                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="list-group-item-heading">6. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Country Head</h5>
                        <div class="col-lg-9  form-group">
                            <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" >
                                <?php echo implode('', $data['roles']['CH']);?>
                            </select>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="step-footer form-group">
                <button  type="submit" class="btn btn-default btn-lg next" href="#">Continue</button>
                <button class="btn btn-warning btn-lg back" href="#">Back</button>
                <button class="btn btn-danger btn-lg first" href="#">Cancel</button>
            </div>
        </form>
        <form class="tab-pane fade step" id="step4">
            <div class="form-group col-lg-12 step-body">
                <div id="reset_files"></div>
            </div>
            <div class="form-group col-lg-12 step-body">
                <legend>Upload Iom Files:</legend>
                <input id="input-1" multiple type="file" class="file file-loading" data-allowed-file-extensions='["txt","jpg","tif","doc","pdf","webm"]'>
            </div>
            <div class="step-footer form-group">
                <button id="create_app" class="btn btn-success btn-lg" href="#">Create Application</button>
                <button class="btn btn-warning btn-lg back" href="#">Back</button>
                <!--                    <button class="btn btn-danger btn-lg next" href="#">Cancel</button>-->
            </div>

        </form>
    </div>
</div>

<script src="/js/main/purchasePanel.js?<?php echo $data['script_version']?>" type="text/javascript"></script>