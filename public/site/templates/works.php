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
  <title>BKT | ODP Master</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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
<style type="text/css">
.swal2-overflow {
  overflow-x: visible;
  overflow-y: visible;
}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ordenes de trabajo
        <small>Lista con todas las ordenes de trabajo</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ordenes de trabajo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="row">
                  <div class="col-md-6">
                      <h3 class="box-title">Tabla con todos las ordenes de trabajo y resumen de progreso</h3>
                  </div>
                  <div class="col-md-6" align="right">
                    <button id="add-odt" type="button" class="btn btn-block btn-success" style="max-width: 120px;">Agregar ODP</button>
                  </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Cotización</th>
                    <th>Cliente</th>
                    <th>Fecha inicio</th>
                    <th>Fecha entrega</th>
                    <th>Progreso</th>
                    <th></th>
                    <th>Información</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php $works=$pages->find("template=work, sort=-published"); 
                      foreach ($works as $work) { 
                            if($work->datos=='') continue;
                           $data_all=explode('$', $work->datos);
                           $inc=0;
                           $total=0;
                      foreach ($data_all as $pronum) {
                          if($pronum=='') continue;
                          $data=explode('/', $pronum);
                        $total+=count(explode(',', $data[2]));
                          foreach(explode(',', $data[2]) as $num){
                              $nume=explode('-', $num);
                              if($nume[0]==3)
                                $inc++; }   
                      }
                          if($total==0)
                            $porcen=0;
                        else
                        $porcen=($inc*100)/$total;?>  
                    <tr>
                      <td><?= $work->title; ?></td>
                      <td><?= $work->cotizacion; ?></td>
                      <td><?= $work->cliente; ?></td>
                      <td><?= $work->fechai; ?></td>
                      <td><?= $work->fechaf; ?></td>
                      <td>
                        <div class="progress progress-xs progress-striped active">
                          <div class="progress-bar progress-bar-success" style="width: <?=round($porcen);?>%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-green"><?=round($porcen);?>%</span></td>
                      <td><a href="<?= $work->url; ?>"><button type="button" class="btn btn-block btn-primary btn-xs">Más información</button></a></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Folio</th>
                    <th>Cotizacion</th>
                    <th>Cliente</th>
                    <th>Fecha inicio</th>
                    <th>Fecha entrega</th>
                    <th>Progreso</th>
                    <th></th>
                    <th>Información</th>
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
<script src="<?php echo $config->urls->templates ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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

  $('#datepicker').datepicker({
      autoclose: true
    })

  $("#add-odt").click(function() {
      swal.setDefaults({
          input: 'text',
          confirmButtonText: 'Next &rarr;',
          showCancelButton: true,
          progressSteps: ['1', '2', '3', '4', '5']
        })

      var steps = [
        {
          title: 'Folio',
          text: 'Ingrese el numero de folio',
          inputValidator: function (value) {
            return !value && 'Escriba el numero de folio'
          }
        },
        {
          title: 'Cotización',
          text: 'Ingrese el numero de cotización',
          inputValidator: function (value) {
            return !value && 'Escriba el numero de cotización'
          }
        },
        {
          title: 'Empresa',
          text: 'Ingrese el nombre de la empresa',
          inputValidator: function (value) {
            return !value && 'Escriba el numero de cliente'
          }
        },
        {
          title: 'Fecha de inicio',
          html: '<div class="form-group">'+
                '<label>Date:</label>'+
                '<div class="input-group date">'+
                 '<div class="input-group-addon">'+
                   '<i class="fa fa-calendar"></i>'+
                  '</div>'+
                  '<input name="fechIni" type="text" class="form-control pull-right" id="fechIni">'+
                '</div>'+
              '</div>',
          focusConfirm: false,
          onOpen: function() {
            $(".swal2-input").hide();
            $('#fechIni').datepicker({
              onSelect: swal.clickConfirm
            });
          },
            preConfirm: () => {
              return [$('#fechIni').val() ]
            }
        },
        {
          title: 'Fecha de Entrega',
          html: '<div class="form-group">'+
                '<label>Date:</label>'+
                '<div class="input-group date">'+
                 '<div class="input-group-addon">'+
                   '<i class="fa fa-calendar"></i>'+
                  '</div>'+
                  '<input name="fechaFin" type="text" class="form-control pull-right" id="fechaFin">'+
                '</div>'+
              '</div>',
          focusConfirm: false,
          onOpen: function() {
            $(".swal2-input").hide();
            $('#fechaFin').datepicker({
              onSelect: swal.clickConfirm
            });
          },
            preConfirm: () => {
              return [ $('#fechaFin').val() ]
            }
        }
      ]

      swal.queue(steps).then(function (result) {
        swal.resetDefaults()

        if (result.value) {
          $.ajax({
          url: "/add-odt",
          type: "post",
          data: {data:result.value},
          dataType: "html",
          }).done(function(msg){
            if(msg){
                swal({
              title: "Correcto",
              text: "Se creo la ODP, ahora puedes agregar productos",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location=msg;
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
        }
      })
  });
          
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>