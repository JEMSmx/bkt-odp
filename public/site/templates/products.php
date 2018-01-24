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
        Productos
        <small>Lista con todos los productos dados de alta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/calendario"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Productos</li>
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
                <h3 class="box-title">Tabla con todos los productos</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Linea</th>
                    <th>Familia</th>
                    <th>Categoria</th>
                    <th>Modificar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php $categories=file_get_contents('https://bktmobiliario.com/api/category/read.php');
                         $obj_cat = json_decode($categories); 
                         $products=$pages->find("template=product, sort=-published"); 
                      foreach ($products as $product) { ?>
                      <tr>
                        <td><?= $product->title; ?></td>
                        <td><?= $product->modelo; ?></td>
                        <td><?= $obj_cat->categories->{$product->familia."/"}->nombre; ?></td>
                        <td><?= $product->categoria; ?></td>
                       <!--  <td><button data-key="<?= $product->id; ?>" type="button" class="btn btn-block btn-success btn-xs add-button">Agregar</button></td> -->
                        <td><a href="<?=$product->url;?>"><button type="button" class="btn btn-block btn-primary btn-xs">Modificar</button></a></td>
                      </tr>
                   <?php   }
                      ?>
                   
                    
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>Linea</th>
                    <th>Familia</th>
                    <th>Categoria</th>
                    <th>Modificar</th>
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
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
