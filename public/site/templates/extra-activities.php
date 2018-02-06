<?php include('./_head.php'); ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.css">

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Actividades Extra
        <small>Lista con todas las actividades extras dadas de alta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/calendario"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Actividades extra</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Tabla con todas las actividades extra</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body" id="activities">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre Actividad</th>
                    <th>Tiempo total</th>
                    <th>Asignado</th>
                    <th></th>
                    
                    <th>Modificar</th>
                    <th>Eliminar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php   $colores=array('btn-default', 'btn-danger', 'btn-primary', 'btn-success');
                          $nombres=array('Pendiente', 'Pausada', 'En Proceso', 'Terminada');
                          $color=array('gray', 'red', 'blue', 'green');
                          $porcen=array('0', '50', '50', '100');
                          foreach ($page->children("type=extra-activity, prid<1, status<3") as $key => $value) { ?>
                              
                    <tr id="sh-<?=$value->id?>">
                      <td><?= $value->title ?></td>
                      <td><?= $value->duration ?></td>
                      <td>
                        <div class="btn-group">
                          <?php if(empty($value->assign)){ 
                                  $asig='Sin asignar';
                                  $clr='default';
                                }else{ 
                                  $asig=$value->assign->namefull;
                                  $clr='primary';
                                } ?>
                          <button type="button" class="btn btn-<?=$clr;?> btn-xs"><?=$asig;?></button>
                        </div>
                      </td>
                      <td></td>
                      <td><button data-id="<?=$value->id?>" type="button" class="btn btn-block btn-primary btn-xs edit">Modificar</button></td>
                      <td><button data-id="<?=$value->id?>" type="button" class="btn btn-block btn-danger btn-xs delete">Eliminar</button></td>
                    </tr>
                    <tr id="ed-<?=$value->id?>" style="display:none;">
                      <td><input id="title-<?=$value->id?>" type="text" class="form-control" value="<?= $value->title; ?>"></td>
                      <td><input id="duration-<?=$value->id?>" type="text" class="form-control" value="<?= $value->duration; ?>"></td>
                      <td>
                        <div class="btn-group">
                          <?php if(empty($value->assign)){ 
                                  $asig='Sin asignar';
                                  $clr='default';
                                }else{ 
                                  $asig=$value->assign->namefull;
                                  $clr='primary';
                                } ?>
                          <button type="button" class="btn btn-<?=$clr;?> btn-xs"><?=$asig;?></button>
                        </div>
                      </td>
                      <td></td>
                      <td><button data-id="<?=$value->id?>" type="button" class="btn btn-block btn-success btn-xs update">Aceptar</button></td>
                      <td><button data-id="<?=$value->id?>" type="submit" class="btn btn-block btn-danger btn-xs cancel">Cancelar</button></td>
                    </tr>
                    <?php  }  ?>
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
  <?php include('./_main-footer.php'); ?>

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
<script src="<?php echo $config->urls->templates ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.js"></script>
<!-- page script -->
<script>
  $('.timepicker').timepicker({
      showSeconds: false,
      showMeridian: false,
      defaultTime: '00:00 AM'
    });
  $(function () {
    $('#example1').DataTable()
  });
  $(".edit").click(function() {
      $("#sh-"+$(this).data('id')).hide();
      $("#ed-"+$(this).data('id')).show();
  })
  $(".cancel").click(function() {
      $("#ed-"+$(this).data('id')).hide();
      $("#sh-"+$(this).data('id')).show();
  })
  
  $(".delete").click(function() {
    var id=$(this).data('id');
    swal({
      title: '¿Estás seguro?',
      text: "La actividad será eliminada",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Quiero borrarla',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
          $.ajax({
          url: "/delete-activity-extra",
          type: "post",
          data: {key:id,edit:'delete'},
          dataType: "html",
          }).done(function(msg){
            console.log(msg);
            if(msg){
                swal({
              title: "Correcto",
              text: "Se borro la actividad",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='/actividades-extra';
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
        }
      })
  })
  $(".update").click(function() {
    var id=$(this).data('id');
      $.ajax({
          url: "/update-activity",
          type: "post",
          data: {key:id,title:$("#title-"+id).val(),duration:$("#duration-"+id).val()},
          dataType: "html",
          }).done(function(msg){
            console.log(msg)
            if(msg){
                swal({
              title: "Correcto",
              text: "Se actualizo la actividad",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='/actividades-extra';
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
  })
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
