<div ng-app="mainApp">
    <div class="container-fluid" ng-controller="myNotify">

        <!-- Page Heading -->
        <div class="row shadow-block">
            <h1 class="page-header">
                Dashboard <small>Test Overview</small>
            </h1>
            <div class="col-lg-7">
                <div class="col-lg-6 col-md-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-table fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{app_count}}</div>
                                    <div>New Applications!</div>
                                </div>
                            </div>
                        </div>
                        <a href="/purchase">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bell fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{msg_count}}</div>
                                    <div>New Alerts!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="test_chart"></div>
            </div>
            <div class="col-lg-5">
                <div class="col-lg-12 col-md-12">
                    <span class="label label-primary">Latest Actions:</span>
                    <table id="latest_actions"></table>


                </div>
            </div>

        </div>
    </div>
<!--    <div ng-controller="safeCtrl">-->
<!---->
<!--        <button type="button" ng-click="addRandomItem(row)" class="btn btn-sm btn-success">-->
<!--            <i class="glyphicon glyphicon-plus">-->
<!--            </i> Add random item-->
<!--        </button>-->
<!---->
<!--        <table st-table="displayedCollection" st-safe-src="rowCollection" class="table table-striped">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th st-sort="firstName">first name</th>-->
<!--                <th st-sort="lastName">last name</th>-->
<!--                <th st-sort="birthDate">birth date</th>-->
<!--                <th st-sort="balance">balance</th>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th colspan="5"><input st-search="" class="form-control" placeholder="global search ..." type="text"/></th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr ng-repeat="row in displayedCollection">-->
<!--                <td>{{row.firstName}}</td>-->
<!--                <td>{{row.lastName}}</td>-->
<!--                <td>{{row.birthDate}}</td>-->
<!--                <td>{{row.balance}}</td>-->
<!--                <td>-->
<!--                    <button type="button" ng-click="removeItem(row)" class="btn btn-sm btn-danger">-->
<!--                        <i class="glyphicon glyphicon-remove-circle">-->
<!--                        </i>-->
<!--                    </button>-->
<!--                </td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        </table>-->
<!---->
<!--    </div>-->
<!-- /.container-fluid -->
</div>
<script src="/js/main/main.js" type="text/javascript"></script>
