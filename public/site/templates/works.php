<?php include('./_head.php'); ?>
<style type="text/css">
.swal2-overflow {
  overflow-x: visible;
  overflow-y: visible;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ordenes de producción
        <small>Lista con todas las ordenes de producción</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/calendario"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ordenes de producción</li>
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
                      <h3 class="box-title">Tabla con todos las ordenes de producción y resumen de progreso</h3>
                  </div>
                  <div class="col-md-6" align="right">
                    <button type="button" class="btn btn-block btn-success" style="max-width: 120px;" data-toggle="modal" data-target="#modal-info">Agregar ODP</button>
                  </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Folio</th>
                    <th>ODT</th>
                    <th>Cotización</th>
                    <th>Empresa</th>
                    <th>Fecha inicio</th>
                    <th>Fecha entrega</th>
                    <th>Progreso</th>
                    <th>Información</th>
                    <th>Editar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php $works=$pages->find("template=work"); 
                      $total=0;
                      $inc=0;
                      foreach ($works as $work) { 
                        if($work->children()->count()==0)
                            $porcen=0;
                        else
                        $porcen=($work->children("state=3")->count()*100)/($work->children()->count());

                      ?>  

                    <tr id="sh-<?=$work->id?>">
                      <td><?= $work->title; ?></td>
                      <td><?= $work->numodt; ?></td>
                      <td><?= $work->cotizacion; ?></td>
                      <td><?= $work->cliente; ?></td>
                      <td><?= $work->fechai; ?></td>
                      <td><?= $work->fechaf; ?></td>
                      
                      <td><span class="badge bg-green"><?=round($porcen);?>%</span></td>
                      <td><a href="<?= $work->url; ?>"><button type="button" class="btn btn-block btn-primary btn-xs">Ver ODP</button></a></td>
                      <td><button data-id="<?=$work->id?>" type="button" class="btn btn-block btn-primary btn-xs edit">Modificar ODP</button></td>
                    </tr>
                    <tr id="ed-<?=$work->id?>" style="display:none;">
                      <td><input style="max-width:100px" id="title-<?=$work->id?>" type="text" class="form-control" value="<?= $work->title; ?>"></td>
                      <td><input style="max-width:100px" id="numodt-<?=$work->id?>" type="text" class="form-control" value="<?= $work->numodt; ?>"></td>
                      <td><input style="max-width:100px" id="cotizacion-<?=$work->id?>" type="text" class="form-control" value="<?= $work->cotizacion; ?>"></td>
                      <td><input  style="max-width:100px" id="cliente-<?=$work->id?>" type="text" class="form-control" value="<?= $work->cliente; ?>"></td>
                      <td><div class="form-group">
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input style="max-width:130px" id="fechai-<?=$work->id?>" type="text" class="form-control pull-right datepicker" value="<?= $work->fechai; ?>">
                          </div>
                          <!-- /.input group -->
                        </div>
                      </td>
                      <td><div class="form-group">
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input style="max-width:130px" id="fechaf-<?=$work->id?>" type="text" class="form-control pull-right datepicker" value="<?= $work->fechaf; ?>">
                          </div>
                          <!-- /.input group -->
                        </div></td>
                      <td><span style="max-width:50px" class="badge bg-green"><?=round($porcen);?>%</span></td>
                      <td><button style="max-width:100px" data-id="<?=$work->id?>" type="button" class="btn btn-block btn-success btn-xs accept">Aceptar</button></td>
                      <td><button style="max-width:100px" data-id="<?=$work->id?>" type="submit" class="btn btn-block btn-danger btn-xs cancel">Cancelar</button></td>
                    </tr>
                    
                  <?php } ?>
                  </tbody>
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
    <strong>Copyright &copy; <?=date('Y')?> <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
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
<form id="addWork">
<div class="modal" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Agregar ODP</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Folio de la ODP <b style="margin-left: 8px">1/6</b></h4>
          <input class="form-control input-lg" type="text" placeholder="El numero que aparece en la orden de producción" name="title">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#modal-info5">Siguiente</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal" id="modal-info5">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Agregar Numero ODT</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Numero de la ODT <b style="margin-left: 8px">2/6</b></h4>
          <input class="form-control input-lg" type="text" placeholder="El numero que aparece en la orden de trabajo" name="odt">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info">Regresar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#modal-info1">Siguiente</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal" id="modal-info1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Cotización</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Numero de cotización <b style="margin-left: 8px">3/6</b></h4>
          <input class="form-control input-lg" type="text" placeholder="Ingrese el numero de cotización" name="cotizacion">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info5">Regresar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#modal-info2">Siguiente</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal" id="modal-info2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Empresa</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Nombre de la empresa <b style="margin-left: 8px">4/6</b></h4>
          <input class="form-control input-lg" type="text" placeholder="Ingrese el nombre de la empresa" name="empresa">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info2">Regresar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#modal-info3">Siguiente</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal" id="modal-info3">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Fecha Inicio</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Fecha de Inicio<b style="margin-left: 8px">5/6</b></h4>
          <div class="input-group date">
                 <div class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                  </div>
                  <input name="fechaIni" type="text" class="form-control pull-right datepicker">
                </div>
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info3">Regresar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#modal-info4">Siguiente</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal" id="modal-info4">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Fecha Entrega</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Fecha de Entrega<b style="margin-left: 8px">6/6</b></h4>
          <div class="input-group date">
                 <div class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                  </div>
                  <input name="fechaFin" type="text" class="form-control pull-right datepicker">
                </div>
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info3">Regresar</button>
          <button type="submit" class="btn btn-success">Terminar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
    <!-- /.modal-dialog -->
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
    $('#example1').DataTable({
      "ordering": false
    })
  })


  $(".edit").click(function() {
      $("#sh-"+$(this).data('id')).hide();
      $("#ed-"+$(this).data('id')).show();
  })
  $(".cancel").click(function() {
      $("#ed-"+$(this).data('id')).hide();
      $("#sh-"+$(this).data('id')).show();
  })
  $(".accept").click(function() {
    var id=$(this).data('id');
      $.ajax({
          url: "/add-odt",
          type: "post",
          data: {edit:'true',id:id,title:$("#title-"+id).val(),cotizacion:$("#cotizacion-"+id).val(),cliente:$("#cliente-"+id).val(),fechai:$("#fechai-"+id).val(),fechaf:$("#fechaf-"+id).val(),numodt:$("#numodt-"+id).val()},
          dataType: "html",
          }).done(function(msg){
            console.log(msg);
            if(msg){
                swal({
              title: "Correcto",
              text: "Se actualizo la ODP",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='/ordenes-de-produccion';
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
  })

  $(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

  $( "#addWork" ).submit(function( event ) {
    $.ajax({
          url: "/add-odt",
          type: "post",
          data: $(this).serialize(),
          dataType: "html",
          }).done(function(msg){
            $('#modal-info4').modal('toggle');
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
    
    event.preventDefault();
  });

  $('.datepicker').datepicker({
      autoclose: true
    })
  
          
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>