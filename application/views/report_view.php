<div class="container-fluid"  ng-app="mainApp" ng-controller="myNotify" >
    <div class="col-lg-12 shadow">
        <h2 class="page-header">Reports</h2>
        <select id="budgets_graph" class="selectpicker" data-width="20%" data-live-search="true" data-selected-text-format="count" >
            <?php echo $data['departments'];?>
        </select>
        <div id="report_chart"></div>
        <h2 class="page-header">Selected Budget</h2>
        <table id="report_data" class="table table-striped table-bordered" style="table-layout:fixed; margin-bottom: 0px; margin-right: 10px;">
        </table>
    </div>
</div>
<script src="/js/main/reports.js" type="text/javascript"></script>