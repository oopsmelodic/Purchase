
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
                                <i class="glyphicon glyphicon-plus"></i> New appliements
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

<script src="/js/main/purchasePanel.js" type="text/javascript"></script>