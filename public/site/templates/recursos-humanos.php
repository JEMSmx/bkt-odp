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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
                  <button type="button" class="btn btn-block btn-success" style="max-width: 130px;" id="add-emp">Agregar Trabajador</button>
                </div>
              </div>

              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Puesto</th>
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
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Asignación del día</th>
                    <th>Hoy</th>
                    <th>Semana</th>
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
  function edit(emp,nm,pu,us){
    $('#sh-'+emp).after('<tr id="ed-'+emp+'"><input type="hidden" value="'+emp+'"><td><input class="form-control" type="text" placeholder="Nombre Completo" name="namefull" value="'+nm+'" id="nm-'+emp+'"></td><td><input class="form-control" type="text" placeholder="Puesto" name="puesto" value="'+pu+'" id="pu-'+emp+'"></td><td><input class="form-control" type="text" placeholder="Usuario" name="usuario" value="'+us+'" id="us-'+emp+'"></td><td></td><td><button onclick="sendEdit('+emp+');" type="button" class="btn btn-success">Aceptar</button></td><td><button onclick="cancelEdit('+emp+');" type="button" class="btn btn-danger cancelEdit">Cancelar</button></td></tr>');
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
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
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
            data: {idemp:$(this).data('id')},
            dataType: "html",
            }).done(function(msg){
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
   $("#add-emp").click(function() {
      swal.setDefaults({
          input: 'text',
          confirmButtonText: 'Next &rarr;',
          showCancelButton: true,
          progressSteps: ['1', '2', '3']
        })

      var steps = [
        {
          title: 'Usuario',
          text: 'Ingrese el nombre de usuario',
          inputValidator: function (value) {
            return !value && 'Escriba el nombre de usuario'
          }
        },
        {
          title: 'Nombre',
          text: 'Ingrese el nombre completo',
          inputValidator: function (value) {
            return !value && 'Escriba el nombre completo del empleado'
          }
        },
        {
          title: 'Puesto',
          text: 'Ingrese el puesto del empleado',
          inputValidator: function (value) {
            return !value && 'Escriba el puesto del empleado'
          }
        }
      ]

      swal.queue(steps).then(function (result) {
        swal.resetDefaults()

        if (result.value) {
          $.ajax({
          url: "/add-empleado",
          type: "post",
          data: {data:result.value},
          dataType: "html",
          }).done(function(msg){
              console.log(msg);
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
        }
      })
  });
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     emp experience. -->
</body>
</html>
