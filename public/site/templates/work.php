<?php if(!$user->isLoggedin()) $session->redirect("/iniciar-sesion"); ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BKT | ODT Master</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orden de trabajo: <strong><?= $page->title; ?></strong>
        <small>Lista con todas las ordenes de trabajo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Ordenes de trabajo</li>
        <li class="active"><?= $page->title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- ------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Tabla con el desgloce de actividades de la orden de trabajo <strong><?= $page->title; ?></strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Proceso</th>
                    <th>Producto</th>
                    <th>Tiempo p/u</th>
                    <th>Qty</th>
                    <th>Tiempo total</th>
                    <th>Asignado</th>
                    <th>Progreso</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php   $colores=array('btn-default', 'btn-danger', 'btn-primary', 'btn-success');
                          $nombres=array('Pendiente', 'Pausada', 'En Proceso', 'Terminada');
                          $color=array('gray', 'red', 'blue', 'green');
                          $porcen=array('0', '50', '50', '100');
                          $datos=explode("$", $page->datos);
                          $arid=array();
                          foreach ($datos as $value) {
                             $val=explode('/', $value);
                             $arid[]=$val[0];
                          }
                          $arid=implode(',', $arid);
                          $processes= $pages->getById($arid);
                          foreach ($processes as $key=>$process) {
                              $cant=explode("/", $datos[$key]);
                                $pro=explode(",", $cant[2]);
                              foreach (explode(",", $process->tiempos) as $key=>$value) {
                                $fabtim=explode('/', $value); 
                                 $status=explode('-', $pro[$key]); ?>
                              
                    <tr>
                      <td><?= $fabtim[0]; ?></td>
                      <td><?= $process->title; ?></td>
                      <td><?= $fabtim[1]; ?></td>
                      <td><?= $cant[1]; ?></td>
                      <td><?= date("h:i", strtotime($fabtim[1]) * $cant[1]); ?></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-xs">Sin asignar</button>
                          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Hugo</a></li>
                            <li><a href="#">Paco</a></li>
                            <li><a href="#">Luis</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Sin asignar</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><span class="badge bg-<?=$color[$status[0]];?>"><?=$porcen[$status[0]]; ?>%</span></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn <?= $colores[$status[0]]; ?> btn-xs"><?= $nombres[$status[0]]; ?></button>
                          <button type="button" class="btn <?= $colores[$status[0]]; ?> btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu" id="<?= $cant[0].'/'.$key; ?>">
                            <li data-key="0"><a href="#">Pendiente</a></li>
                            <li data-key="2"><a href="#">En Proceso</a></li>
                            <li data-key="3"><a href="#">Terminada</a></li>
                            <li data-key="1"><a href="#">Pausada</li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <?php }   }  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Proceso</th>
                    <th>Producto</th>
                    <th>Tiempo p/u</th>
                    <th>Qty</th>
                    <th>Tiempo total</th>
                    <th>Asignado</th>
                    <th>Progreso</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
          <!-- /.box -->
        </div>

        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      El fracaso es una gran oportunidad para empezar otra vez con más inteligencia
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?php echo $config->urls->templates ?>bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $config->urls->templates ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $config->urls->templates ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $config->urls->templates ?>dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $('.dropdown-menu li').click(function(){
    var key=$(this).data('key');
    var id=$(this).closest("ul").prop("id");
    $.ajax({
      url: "/change-status",
      type: "post",
      data: {status:key,id:id,odt:<?=$page->id;?>},
      dataType: "html",
      }).done(function(msg){
        if(msg){
            swal({
          title: "Correcto",
          text: "Se actualizo el status",
          type: "success",
        })
        .then(willDelete => {
          if (willDelete) {
            window.location='';
          }
        });
        }
      }).fail(function (jqXHR, textStatus) {
              
    });
 });
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
