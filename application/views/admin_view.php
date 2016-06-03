<div class="container-fluid" ng-app="mainApp" ng-controller="myNotify">
    <!-- Page Heading -->
    <!-- /.row -->
    <div class="row" style="margin-top:10px;">

        <div class="col-lg-12" style="padding:0px;">
            <ul class="nav nav-pills" style="margin-bottom: 15px;">
                <li class="active"><a data-toggle="pill" href="#home" table="employee">Employees</a></li>
                <li class=""><a data-toggle="pill" href="#home" table="budget">Budgets</a></li>
                <li class=""><a data-toggle="pill" href="#home" table="budget_mapping">Budgets Mapping</a></li>
                <li class=""><a data-toggle="pill" href="#home" table="budget_brand">Budgets Brand</a></li>
            </ul>
            <div class="tab-content" >
                <div id="home" class="tab-pane fade in active" style="min-height: 500px;">
                    <div class="col-lg-12 shadow" style="margin-top:10px;">
                        <div id="toolbar">
                            <button id="addUser" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i> Add
                            </button>
                        </div>
                        <table id="datatable" data-toolbar="#toolbar" class="table table-bordered" style="table-layout:fixed; margin-bottom: 0px; margin-right: 10px;">
                        </table>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <div class="col-lg-12 shadow" style="margin-top:10px;">
                        <div id="toolbar">
                            <button id="addUser" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i> Add
                            </button>
                        </div>
                        <table id="budgettable" data-toolbar="#toolbar" class="table table-bordered" style="table-layout:fixed; margin-bottom: 0px; margin-right: 10px;">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->

<!-- jQuery -->
<script src="/js/main/adminPanel.js" type="text/javascript"></script>