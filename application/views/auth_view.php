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
  <!-- Custom Fonts -->
  <link href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="/bower_components/bootstrap-table-master/bootstrap-table.min.css" rel="stylesheet" type="text/css">
  <link href="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
  <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
  <![endif]-->

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
  <script src="/bower_components/angular-notify-master/dist/angular-notify.min.js" type="text/javascript"></script>
  <link href="/bower_components/angular-notify-master/dist/angular-notify.min.css" rel="stylesheet" type="text/css"/>
  <script src="/bower_components/ng-notify-master/src/scripts/ng-notify.js" type="text/javascript"></script>
  <script src="/bower_components/angular-help-overlay-master/src/angular-help-overlay.js" type="text/javascript"></script>
  <link href="/bower_components/ng-notify-master/dist/ng-notify.min.css" rel="stylesheet" type="text/css"/>

  <script src="/bower_components/highcharts-4.1.9/js/highcharts.js" type="text/javascript"></script>
  <script src="/bower_components/bootstrap-table-master/bootstrap-table-all.js" type="text/javascript"></script>
  <script src="/bower_components/bootstrap-table-master/locale/bootstrap-table-en-US.js" type="text/javascript"></script>
  <script src="/bower_components/bootstrap-table-master/extensions/group-by/bootstrap-table-group-by.js" type="text/javascript"></script>
  <script src="/bower_components/bootbox-4.4.0/bootbox.js" type="text/javascript"></script>
  <script src="/js/main/app.js" type="text/javascript"></script>
</head>

<body>

<div class="maxer">
  <div class="blur"></div>
  <div class="inner-wrapper shadow">
    <form  role="form" action="" method="post" class="form-horizontal " autocomplete="off">
      <fieldset>
        <legend>
          <i class="glyphicon  glyphicon-send" aria-hidden="true"></i> Coordinator
        </legend>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-3 control-label">Username</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" name="login" id="inputUsername" placeholder="Username" autocomplete="off">

          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-3 control-label">Password</label>
          <div class="col-lg-9">
            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-9 col-lg-offset-3">
            <button  class="btn btn-success" id="login" style="width:100%;">Login</button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
<!-- /#wrapper -->

</body>