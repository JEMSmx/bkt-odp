<?php include('./_head.php'); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trabajadores
        <small>Personal en planta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/calendario"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Trabajadores</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="col-md-6">
                    <h3 class="box-title">Tabla con los trabajadores del taller</h3>
                </div>
                <div class="col-md-6" align="right">
                  <button type="button" class="btn btn-block btn-success" style="max-width: 130px;" data-toggle="modal" data-target="#modal-info">Agregar Trabajador</button>
                </div>
              </div>

              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Usuario</th>
                    <th>Asignación del día</th>
                    <th>Hoy</th>
                    <th>Semana</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                 <?php $users_emp=$users->find("roles=empleado"); 
                       foreach ($users_emp as $emp) { ?>
                    <tr id="sh-<?=$emp->id;?>">
                      <td><?= $emp->namefull; ?></td>
                      <td><?= $emp->puesto; ?></td>
                      <td><?= $emp->name; ?></td>
                      <?php  
                            $hora='00:00';
                              foreach ($emp->children() as $key => $event) {
                                      $fechEvento=explode(" ", $event->ini);
                                      $hoy=date('Y-m-d');
                                      if($hoy==$fechEvento[0]){
                                        $hora=sumarHoras($hora,$event->odt->duration);
                                      }
                               } ?>
                      <td><?=round(convertDec($hora),2)?> de 8 horas</td>
                      <?php $ade='00:00'; $pas='00:00'; 
                                foreach ($emp->children() as $key => $event) {
                                      $fechEvento=explode(" ", $event->ini);
                                      $hoy=date('Y-m-d');
                                      if($hoy==$fechEvento[0]){
                                        $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                                        $fecha_entrada = strtotime($event->fin);
                                        if($fecha_actual > $fecha_entrada){
                                          if(intval($event->odt->state)<3){
                                            if($event->odt->cant<=1)
                                              $pas=sumarHoras($pas,$event->odt->duration);
                                            else
                                              $pas=sumarHoras($pas,mulhours($event->odt->duration,$event->odt->cant));
                                          }
                                        }else{
                                          if(intval($event->odt->state)==3){
                                            if($event->odt->cant<=1)
                                              $ade=sumarHoras($ade,$event->odt->duration);
                                            else
                                              $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                                          }
                                        }
                                      }
                               } $ade=convertDec($ade); $pas=convertDec($pas);
                               $hr=$ade-$pas;
                               $eti=($hr>0) ? 'success':'danger';
                               $fr=($hr>0) ? ' Horas adelantado':' Horas atrasado'; ?>
                      <td><small class="label label-<?= ($hr==0) ? 'primary':$eti;?>"><i class="fa fa-clock-o"></i> <?= ($hr==0) ? 'En tiempo':abs(round($hr,2)).$fr;?></small></td>

                      <?php $sem=date('w')-1; $d=date('d'); $inicioSem=(date('w')>1) ? $d-$sem:$sem; $ade='00:00'; $pas='00:00'; 
                            for ($i=0; $i < 7 ; $i++) { 
                              if($inicioSem<10){
                                $inicioSem='0'.$inicioSem;
                              }
                              $hoy=date('Y-m-'.$inicioSem);
                              foreach ($emp->children() as $key => $event) {
                                      $fechEvento=explode(" ", $event->ini);
                                      if($hoy==$fechEvento[0]){
                                        $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                                        $fecha_entrada = strtotime($event->fin);
                                        if($fecha_actual > $fecha_entrada){
                                          if(intval($event->odt->state)<3){
                                            if($event->odt->cant<=1)
                                              $pas=sumarHoras($pas,$event->odt->duration);
                                            else
                                              $pas=sumarHoras($pas,mulhours($event->odt->duration,$event->odt->cant));
                                          }
                                        }else{
                                          if(intval($event->odt->state)==3){
                                            if($event->odt->cant<=1)
                                              $ade=sumarHoras($ade,$event->odt->duration);
                                            else
                                              $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                                          }
                                        }
                                      }
                               }
                              $inicioSem++;
                            }
                                 
                      $ade=convertDec($ade); $pas=convertDec($pas);
                               $hr=$ade-$pas;
                               $eti=($hr>0) ? 'success':'danger';
                               $fr=($hr>0) ? ' Horas adelantado':' Horas atrasado'; ?>
                      <td><small class="label label-<?= ($hr==0) ? 'primary':$eti;?>"><i class="fa fa-clock-o"></i> <?= ($hr==0) ? 'En tiempo':abs(round($hr,2)).$fr;?></small></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-success btn-xs ">Opciones</button>
                          <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="" onclick="edit('<?=$emp->id;?>','<?=$emp->namefull;?>','<?=$emp->puesto;?>','<?=$emp->name;?>'); return false;">Editar</a></li>
                            <li><a href="/calendario/<?=$emp->name;?>">Ver calendario</a></li>
                            <li id="del-emp" data-id="<?=$emp->id;?>"><a href="#">Eliminar</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php }  ?>
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

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<form id="add-emp">
<div class="modal" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Nombre de trabajador</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Nombre completo <b style="margin-left: 8px">1/4</b></h4>
          <input class="form-control input-lg" type="text" placeholder="Nombre completo" name="namefull">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
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
          <h3 class="modal-title" style="color: white;">Puesto</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>¿Que labor desempeña? <b style="margin-left: 8px">2/4</b></h4>
          <input class="form-control input-lg" type="text" placeholder="Puesto del trabajador" name="puesto">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info">Regresar</button>
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
          <h3 class="modal-title" style="color: white;">Usuario</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Nombre de usuario <b style="margin-left: 8px">3/4</b></h4>
          <input class="form-control input-lg" type="text" placeholder="Usuario" name="name">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info1">Regresar</button>
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
          <h3 class="modal-title" style="color: white;">Foto</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Fotografia de trabajador<b style="margin-left: 8px">4/4</b></h4>
          <input class="form-control input-lg" type="file" name="foto">
        </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal-info2">Regresar</button>
          <button type="submit" class="btn btn-success">Terminar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</form>
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
  function edit(emp,nm,pu,us){
    $('#sh-'+emp).after('<tr id="ed-'+emp+'"><input type="hidden" value="'+emp+'"><td><input class="form-control" type="text" placeholder="Nombre Completo" name="namefull" value="'+nm+'" id="nm-'+emp+'"></td><td><input class="form-control" type="text" placeholder="Puesto" name="puesto" value="'+pu+'" id="pu-'+emp+'"></td><td><input class="form-control" type="text" placeholder="Usuario" name="usuario" value="'+us+'" id="us-'+emp+'"></td><td></td><td></td><td><button onclick="sendEdit('+emp+');" type="button" class="btn btn-success">Aceptar</button></td><td><button onclick="cancelEdit('+emp+');" type="button" class="btn btn-danger cancelEdit">Cancelar</button></td></tr>');
    $('#sh-'+emp).hide();
  }

  function cancelEdit(emp){
      $('#ed-'+emp).hide();
      $('#sh-'+emp).show();
  }

  function sendEdit(emp){
      $.ajax({
          url: "/add-empleado",
          type: "post",
          data: {edit:"true",emp:emp,nm:$("#nm-"+emp).val(),pu:$("#pu-"+emp).val(),us:$("#us-"+emp).val()},
          dataType: "html",
          }).done(function(msg){
            if(msg){
                swal({
              title: "Correcto",
              text: "Se actualizo el empleado",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='/recursos-humanos';
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
  }

  
  

  $(function () {
    $('#example1').DataTable()
  })

  $(".dropdown-menu li").click(function(){
    if(this.id=='del-emp'){
        swal({
        title: '¿Estás seguro?',
        text: "El usuario será eliminado",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajax({
            url: "/del-empleado",
            type: "post",
            data: {idemp:$(this).data('id');},
            dataType: "html",
            }).done(function(msg){
              console.log(msg);
              if(msg){
                  swal({
                    title: "Eliminado",
                    text: "El usuario ha sido eliminado",
                    type: "success",
                  })
                  .then(willDelete => {
                    if (willDelete) {
                      window.location='/recursos-humanos';
                    }
                  });
                }
              
            }).fail(function (jqXHR, textStatus) {
                
            });
         }
      })
    }
      
   });

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

   $("#add-emp").submit(function( event ) {
    var formData = new FormData(this);
    console.log(formData);
      $.ajax({
      url: "/add-empleado",
      type: "post",
      data: formData,
      dataType: "html",
      cache:false,
      contentType: false,
      processData: false,
      }).done(function(msg){
        if(msg){
            swal({
          title: "Correcto",
          text: "Se agrego el empleado",
          type: "success",
        })
        .then(willDelete => {
          if (willDelete) {
            window.location='/recursos-humanos';
          }
        });
        }
      }).fail(function (jqXHR, textStatus) {
          
      });  
    event.preventDefault();  
  });
</script>
</body>
</html>
