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
                    <th>Progreso</th>
                    
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
                          foreach ($page->children("type=extra-activity, prid<1") as $key => $value) { ?>
                              
                    <tr>
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
                          <!-- <button type="button" class="btn btn-<?=$clr;?> btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button> -->
                          <!-- <ul class="dropdown-menu" role="menu" id="<?php //$value->id.'/'.$key.'/asignar'; ?>">
                          <?php //$all_users = $users->find("roles=empleado, name!=$asig, status=published"); 
                                //foreach($all_users as $user_sin){ ?>
                            <li data-key="<?php//$user_sin->id;?>"><a href="#"><?php//$user_sin->name;?></a></li>
                            <?php //} ?> 
                            <li class="divider"></li>
                            <?php //if($value->assign!=0){ ?> 
                            <li data-key="0"><a href="#">Sin asignar</a></li>
                            <?php //} ?>
                          </ul> -->
                        </div>
                      </td>
                      <td id="st-<?=$value->id?>">
                        <div class="btn-group">
                          <button type="button" class="btn <?= $colores[$value->state]; ?> btn-xs"><?= $nombres[$value->state]; ?></button>
                          <button type="button" class="btn <?= $colores[$value->state]; ?> btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu" id="<?= $value->id.'/'.$key.'/status'; ?>">
                            <li data-key="0" data-activity="<?=$value->id?>"><a href="#">Pendiente</a></li>
                            <li data-key="2" data-activity="<?=$value->id?>"><a href="#">En Proceso</a></li>
                            <li data-key="3" data-activity="<?=$value->id?>"><a href="#">Terminada</a></li>
                            <li data-key="1" data-activity="<?=$value->id?>"><a href="#">Pausada</li>
                          </ul>
                        </div>
                      </td>
                      <td><button type="button" class="btn btn-block btn-primary btn-xs">Modificar</button></td>
                      <td><button type="button" class="btn btn-block btn-danger btn-xs">Eliminar</button></td>
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
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      El fracaso es una gran oportunidad para empezar otra vez con más inteligencia
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?=date('Y');?> <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
  </footer>


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
  });
  $('.add-button').on('click', function (e) { 
      const {value: country} = swal({
        title: 'Ordenes de Trabajo',
        input: 'select',
        confirmButtonText: 'Seleccionar',
        cancelButtonText: 'Cancelar',
        inputOptions: {
         <?php $works=$pages->find("template=work, sort=-published"); 
                      foreach ($works as $work) { 
                        echo "'".$work->id."': '".$work->title."',"; } ?>  
        },
        inputPlaceholder: 'Selecciona la ODP',
        showCancelButton: true,
        inputValidator: (value) => {
          return new Promise((resolve) => {
            if (value ) {
              swal({
                title: '¿Estas seguro?',
                text: "Se agregara el producto a la ODP",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, agregar',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                      url: "/add-product-odt",
                      type: "post",
                      data: {key:$(this).data('key'), odt:value},
                      dataType: "html",
                    }).done(function(msg){
                      if(msg){
                          swal(
                            'Bien!',
                            'Se agrego el producto a la ODP',
                            'success'
                          )
                      }
                    }).fail(function (jqXHR, textStatus) {
                        
                    });
                }
              })
            } else {
              resolve('Tienes que seleccionar una ODP')
            }
          })
        }
      })
    e.preventDefault(); 
  });
  $('.pro-del').on('click', function (e) { 
    swal({
        title: '¿Estás seguro?',
        text: "El producto será eliminado",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajax({
            url: "/del-pro",
            type: "post",
            data: {pro:$(this).data('pro')},
            dataType: "html",
            }).done(function(msg){
              console.log(msg);
              if(msg){
                  swal({
                    title: "Eliminado",
                    text: "El producto ha sido eliminado",
                    type: "success",
                  })
                  .then(willDelete => {
                    if (willDelete) {
                      window.location='/productos';
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
