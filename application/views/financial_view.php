<div class="container-fluid"  ng-app="mainApp" ng-controller="myNotify" >

    <ul class="nav nav-pills" style="margin-bottom: 15px;">
        <li class="active"><a data-toggle="pill" href="#budgets" table="">Budgets</a></li>
        <li class=""><a data-toggle="pill" href="#ioms" table="">Iom's</a></li>
    </ul>
    <div class="tab-content" >
        <div id="budgets" class="tab-pane fade in active" style="min-height: 500px;">
            <div class="col-lg-12 shadow">
                <h2 class="page-header">Budgets Control</h2>
                <table id="budgets_table" class="table table-condensed table-bordered table-striped"></table>
            </div>
        </div>
        <div id="ioms" class="tab-pane fade">
            <div class="col-lg-12 shadow">
                <h2 class="page-header">Iom Control</h2>
                <table id="iom_table" class="table table-condensed table-bordered table-striped"></table>
            </div>
    </div>
</div>
<script src="/js/main/test.js?<?php echo $data['script_version']?>" type="text/javascript"></script>