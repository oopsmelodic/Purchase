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
    <link href="/css/animate.css" rel="stylesheet" type="text/css"/>
    <!-- Custom Fonts -->
    <link href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/bootstrap-table.min.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.css" rel="stylesheet" type="text/css">
    <link href="/bower_components/ng-table-master/dist/ng-table.min.css" rel="stylesheet" type="text/css">
    <link href="dev.css" rel="stylesheet" type="text/css">
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
    <script src="/bower_components/angular-resource/angular-resource.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-route/angular-route.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-help-overlay-master/src/angular-help-overlay.js" type="text/javascript"></script>
    <script src="/bower_components/angular-notification-master/angular-notification.min.js" type="text/javascript"></script>
    <script src="/bower_components/Smart-Table-master/dist/smart-table.min.js" type="text/javascript"></script>
    <script src="/js/ui-bootstrap-tpls-1.2.5.js" type="text/javascript"></script>
    <script src="/bower_components/ng-table-master/dist/ng-table.min.js" type="text/javascript"></script>


    <script src="/bower_components/highcharts-4.1.9/js/highcharts.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/bootstrap-table-all.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/locale/bootstrap-table-en-US.js" type="text/javascript"></script>
    <script src="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.js" type="text/javascript"></script>
    <script src="/bower_components/bootbox-4.4.0/bootbox.js" type="text/javascript"></script>
<!--    <script src="/js/main/app.js" type="text/javascript"></script>-->
</head>
<body>
<div class="control-block">
    <button class="btn btn-primary">Control</button>
</div>
<div class="container left" id="myWizard">
        <hr>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4" style="width: 20%;">
                Step 1 of 3
            </div>
        </div>
        <div class="form-group col-lg-12">
            <h4 class="col-lg-12"><legend id="user_id" user_id="0"><i class="fa fa-user"></i> Test Name from IT department.</legend></h4>
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
        <div class="tab-content">
            <form class="tab-pane fade in active" id="step1">

                <div class="well">
                    <label>Purchase Name: </label>
                    <input id="purchase_text" rows="4" style="width:100%; max-width: 100%; " class="form-control" required>
                    <span class="help-block with-errors"></span>
                    <label>Substantiation: </label>
                    <textarea name="summernote" id="summernote" cols="10" rows="10"></textarea>
    <!--                <span class="help-block with-errors"></span>-->
                </div>
                <div class="step-footer form-group">
                    <button type="submit" class="btn btn-default btn-lg next" href="#">Continue</button>
<!--                    <button class="btn btn-warning btn-lg back" href="#">Back</button>-->
                    <button class="btn btn-danger btn-lg first" href="#">Cancel</button>
                </div>
            </form>
            <form class="tab-pane fade" id="step2">

                    <div class="form-group col-lg-12 step-body">
                        <div class="col-lg-12 well">
                            <label>Expense type: </label>
                            <select id="budget_select" data-live-search="true" data-minlength="1" data-selector="true" class="selectpicker form-control" data-width="100%" multiple data-selected-text-format="count" required>
                                <optgroup label="CAPEX" data-max-options="">
                                    <option data-content="<h5>Budget 1<small>1000000</small></h5>" planed_cost="1000000">1</option>
                                    <option data-content="<h5>Budget 3<small>580000</small></h5>" planed_cost="580000">4</option>
                                </optgroup>
                                <optgroup label="OPEX" data-max-options="">
                                    <option data-content="<h5>Budget 2<small>500000</small></h5>" planed_cost="500000">2</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-12 well" id="budget_inputs">
                        </div>
                    </div>
                    <div class="step-footer form-group">
                        <button  type="submit" class="btn btn-default btn-lg next" href="#">Continue</button>
                        <button class="btn btn-warning btn-lg back" href="#">Back</button>
                        <button class="btn btn-danger btn-lg first" href="#">Cancel</button>
                    </div>

            </form>
            <form class="tab-pane fade" id="step3">
                <div class="step-body">
                    <ul class="list-group" id="chain_list">
                        <li class="list-group-item">
                            <h5 class="list-group-item-heading">1. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Department leader</h5>
                            <div class="col-lg-9 form-group">
                                <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>

                                    <option data-content="<h5>Betsy Burton<small>Management</small></h5>" emp_id="60" role_power="0">60</option><option data-content="<h5>Erin Marshall<small>Financial</small></h5>" emp_id="68" role_power="0">68</option><option data-content="<h5>Tim French<small>Human Resources</small></h5>" emp_id="70" role_power="0">70</option><option data-content="<h5>Eunice Mcbride<small>Purchasing</small></h5>" emp_id="74" role_power="0">74</option><option data-content="<h5>Marco Robbins<small>IT</small></h5>" emp_id="78" role_power="0">78</option><option data-content="<h5>Yvette Brown<small>Inventory</small></h5>" emp_id="82" role_power="0">82</option>
                                </select>
                                <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                <span class="help-block with-errors"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5 class="list-group-item-heading">2. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial</h5>
                            <div class="col-lg-9  form-group">
                                <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>

                                    <option data-content="<h5>James Doyle<small>Financial</small></h5>" emp_id="67" role_power="0">67</option>
                                </select>
                                <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                <span class="help-block with-errors"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5 class="list-group-item-heading">3. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial controller</h5>
                            <div class="col-lg-9  form-group">
                                <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>

                                    <option data-content="<h5>Colleen Caldwell<small>Financial</small></h5>" emp_id="76" role_power="0">76</option><option data-content="<h5>Test Just Test<small>IT</small></h5>" emp_id="91" role_power="0">91</option>
                                </select>
                                <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                <span class="help-block with-errors"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5 class="list-group-item-heading">4. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Financial director</h5>
                            <div class="col-lg-9  form-group">
                                <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>

                                    <option data-content="<h5>Nettie Doyle<small>Financial</small></h5>" emp_id="65" role_power="0">65</option>
                                </select>
                                <!--                                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
                                <span class="help-block with-errors"></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5 class="list-group-item-heading">5. <i class="glyphicon glyphicon-user" aria-hidden="true"></i> General director</h5>
                            <div class="col-lg-9  form-group">
                                <select class="selectpicker chain_unit" data-width="100%" multiple data-live-search="true" data-selected-text-format="count" required>

                                    <option data-content="<h5>Caleb Lynch<small>Inventory</small></h5>" emp_id="85" role_power="0">85</option><option data-content="<h5>Cesar Ryan<small>Inventory</small></h5>" emp_id="86" role_power="0">86</option>
                                </select>
                                <span class="help-block with-errors"></span>
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
            <form class="tab-pane fade" id="step4">

                <div class="form-group col-lg-12 step-body">
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







<script src="dev.js" type="text/javascript"></script>
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
        showUpload:false,
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