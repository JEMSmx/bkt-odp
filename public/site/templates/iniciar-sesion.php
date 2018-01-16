<?php if($user->isLoggedin()) $session->redirect("/calendario"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ODP| BKT Mobiliario</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>plugins/iCheck/square/blue.css">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="height:auto;">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>BKT </b>Mobiliario Urbano</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar sesión</p>

    <form id="login">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="user" id="user">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="pass" id="pass">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

    <a href="#">Olvide mi contraseña</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo $config->urls->templates ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $config->urls->templates ?>plugins/iCheck/icheck.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.js"></script>
<script type='text/javascript'>
    $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
  $('#login').on('submit', function (e) { 
    if($("#user").val().length < 3){
        swal({
          type: 'error',
          title: 'Ingrese su nombre de usuario completo',
          confirmButtonText: 'Ok'
        });
        $("#user").focus();
    }else if($("#pass").val().length < 6){
        swal({
          type: 'error',
          title: 'La contraseña debe ser de al menos 6 caracteres',
          confirmButtonText: 'Ok'
        });
    }else{
      $.ajax({
          url: "/login",
          type: "post",
          data: $(this).serialize(),
          dataType: "json",
        }).done(function(msg){
          if(msg['result']){
            swal({
              title: 'Iniciando Sesión...',
              text: 'Sera redirigido en segundos',
              type: 'success',
              timer: 1300,
              showConfirmButton: false
              },
              setTimeout(function(){
                top.window.location='/calendario';
            }, 1300)
              );
          }else{
            swal({
              type: 'error',
              title: 'La contraseña y/o usuario son incorrectos, revisa y vuelve intentar',
              confirmButtonText: 'Ok'
            });
          }
        }).fail(function (jqXHR, textStatus) {
            swal({
              type: 'error',
              title: 'Algo anda mal, refresca la pagina y vuelve a intentar',
              confirmButtonText: 'Ok'
            });
        });
    }
    e.preventDefault(); 
  });
</script>
</body>
</html>