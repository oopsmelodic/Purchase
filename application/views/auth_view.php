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

<script>
  $(document).ready(function () {

//    $('#login').click(function (event) {
//      event.preventDefault();
//      $.ajax({
//        url: "php/login.php",
//        type: "POST",
//        dataType: "html",
//        data: {
//          "$username": $('#inputUsername').val(),
//          "pass": $('#inputPassword').val()
//        },
//        success: function (data)
//        {
//          if (data != "Location:tables.php")
//            alert(data);
//          else
//            window.location.href = "http://localhost/dash/tables.php";
//        }
//      });
//    });
//  });

</script>