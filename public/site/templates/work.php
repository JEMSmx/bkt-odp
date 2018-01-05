<?php include('./_head.php'); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orden de produccion: <strong><?= $page->title; ?></strong>
        <small>Lista con todas las ordenes de produccion</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Ordenes de produccion</li>
        <li class="active"><?= $page->title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="row">
                  <div class="col-md-6" style="height: 34px;display:flex;align-items:  center;">
                    <h3 class="box-title">Tabla con el desgloce de actividades de la orden de trabajo <strong><?= $page->title; ?></strong></h3>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" id="control-act">
                    <option value="products">Tabla con productos de la ODP</option>
                    <option value="activities">Tabla con desgloce de actividades</option>
                  </select>
                  </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body" id="activities" style="display:none">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Proceso</th>
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
                          foreach ($page->children() as $key => $value) { 
                            $product = $pages->get($value->prid);?>
                              
                    <tr>
                      <td><?= $product->title ?></td>
                      <td><?= $value->title; ?></td>
                      <td><?php if($value->cant==1){ 
                                echo $value->duration; 
                              }else{
                                $title_cl=explode('/', $value->title);
                                $titlecl=trim($title_cl[0]);
                                $ch=$product->children("title=$titlecl");
                                echo $ch[0]->duration;
                              } ?></td>
                      <td><?= $value->cant ?></td>
                      <td><?php if($value->cant<=1) echo $value->duration; else echo mulhours($value->duration, $value->cant);?></td>
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
                          <?php //$all_users = $users->find("roles=empleado, name!=$asig"); 
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
                      <td><span class="badge bg-<?=$color[$value->state];?>"><?=$porcen[$value->state]; ?>%</span></td>
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
                    </tr>
                    <?php  }  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Producto</th>
                    <th>Proceso</th>
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
                <?php  $categories=array('', 'Vegetacion urbana', 'Señalizacion', 'Ciclismo urbano', 'Mobiliario urbano');
                       $etps=array('', 'Fabricación', 'Ensamblar', 'Empacar');
                       $products = array(); $cants = array(); $etapas = array();
                        foreach($page->children("sort=cant") as $value) {
                          $products[$value->prid.$value->etapa] = $pages->get($value->prid); 
                          $cants[$value->prid.$value->etapa] = $value->cant; 
                          $etapas[$value->prid.$value->etapa] = $value->etapa; 
                        }  ?>
              <div class="box-body" id="products">
                  <table id="example5" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Producto</th>
                        <th>Etapa</th>
                        <th>Qty</th>
                        <th>Modelo</th>
                        <th>Categoria</th>
                        <th>Familia</th>
                        <th>Linea</th>
                        <th>Agregar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Producto -->
                    <?php foreach ($products as $key => $value) { ?>
                      <tr id="sh-<?=$value->id.$etapas[$key] ?>">
                        <td><?=$value->title?></td>
                        <td><?=$etps[$etapas[$key]];?></td>
                        <td><?=$cants[$key];?></td>
                        <td><?=$value->modelo?></td>
                        <td><?= $value->categoria ?></td>
                        <td><?= $categories[$value->familia] ?></td>
                        <td><?=$value->linea?></td>
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-primary btn-xs edit">Editar</button></td>
                      </tr>

                      <tr id="ed-<?=$value->id.$etapas[$key]?>" style="display:none;">
                        <td><?=$value->title?></td>
                        <td><?=$etps[$etapas[$key]];?></td>
                        <td>
                          <div class="form-group">
                            <input type="number" class="form-control" id="cant-<?=$value->id?>" name="cant" value="<?=$cants[$key];?>" min="1" style="width: 60px;">
                          </div>
                        </td>
                        <th><?=$value->modelo?></th>
                        <td><?= $value->categoria ?></td>
                        <input type="hidden" name="et-<?=$value->id?>" value="<?=$etapas[$key];?>">
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-success btn-xs update">Actualizar</button></td>
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-danger btn-xs delete">Eliminar</button></td>
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-primary btn-xs cancel">Cancelar</button></td>
                      </tr>
                    <?php } ?>
                      
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Producto</th>
                        <th>Etapa</th>
                        <th>Qty</th>
                        <th>Modelo</th>
                        <th>Categoria</th>
                        <th>Familia</th>
                        <th>Linea</th>
                        <th>Agregar</th>
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
    
    <section class="content container-fluid">

      <!-- ------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Agrega productos a la ODP de la siguiente lista</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Familia</th>
                    <th>Categoria</th>
                    <th>Cantidad</th>
                    <th>Etapa</th>
                    <th>Agregar</th>
                    <th>Modificar</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Producto -->
                  <?php 
                         $products=$pages->find("template=product, sort=-published"); 
                      foreach ($products as $product) { ?>
                      <tr>
                        <td><?= $product->title; ?></td>
                        <td><?= $product->modelo; ?></td>
                        <td><?= $categories[$product->familia]; ?></td>
                        <td><?= $product->categoria; ?></td>
                        <td><input class="form-control" type="number" name="cantidad" id="canti-<?= $product->id; ?>" value="1"></td>
                        <td><select name="etapa" id="etapa-<?=$product->id;?>"><option value="1">Fabricación</option><option value="2">Ensamblar</option><option value="3">Empacar</option></select></td>
                        <td><button data-key="<?= $product->id; ?>" type="button" class="btn btn-block btn-success btn-xs add-button">Agregar</button></td>
                        <td><a href="<?=$product->url;?>"><button type="button" class="btn btn-block btn-primary btn-xs">Modificar</button></a></td>
                      </tr>
                   <?php   }
                      ?>
                   
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Familia</th>
                    <th>Categoria</th>
                    <th>Cantidad</th>
                    <th>Etapa</th>
                    <th>Agregar</th>
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
    $('#example1').DataTable();
    $('#example3').DataTable();
    $('#example5').DataTable();
  })

  $("#control-act").change(function () {
      if($("#control-act").val()=='activities'){
          $("#activities").show();
          $("#products").hide();
      }else{
          $("#activities").hide();
          $("#products").show();
      }

  })
  $(".edit").click(function() {
      $("#sh-"+$(this).data('id')+''+$(this).data('etp')).hide();
      $("#ed-"+$(this).data('id')+''+$(this).data('etp')).show();
  })
  $(".cancel").click(function() {
      $("#ed-"+$(this).data('id')+''+$(this).data('etp')).hide();
      $("#sh-"+$(this).data('id')+''+$(this).data('etp')).show();
  })
  $(".delete").click(function() {
    var id=$(this).data('id');
    swal({
      title: '¿Estás seguro?',
      text: "El producto será eliminado de la OPD",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Quiero borrarlo',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
          $.ajax({
          url: "/add-product-odt",
          type: "post",
          data: {key:id,odp:'<?=$page->id?>',edit:'delete',etapa:$(this).data('etp')},
          dataType: "html",
          }).done(function(msg){
            if(msg){
                swal({
              title: "Correcto",
              text: "Se borro el producto",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='<?=$page->url?>';
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
          url: "/add-product-odt",
          type: "post",
          data: {key:id,canti:$("#cant-"+id).val(),odp:'<?=$page->id?>',etapa:$(this).data('etp')},
          dataType: "html",
          }).done(function(msg){
            console.log(msg);
            if(msg){
                swal({
              title: "Correcto",
              text: "Se actualizo el producto",
              type: "success",
            })
            .then(willDelete => {
              if (willDelete) {
                window.location='<?=$page->url?>';
              }
            });
            }
          }).fail(function (jqXHR, textStatus) {
              
          });
  })
  $('.dropdown-menu li').click(function(){
    var key=$(this).data('key');
    var id=$(this).closest("ul").prop("id");
    var find=id.split('/');
    if(find[2]=='status'){
      $.ajax({
        url: "/change-status",
        type: "post",
        data: {status:key,odt:<?=$page->id;?>,activity:$(this).data('activity')},
        dataType: "html",
        }).done(function(msg){
          console.log(msg);
          
            $("#st-"+find[0]).html(msg);
          
        }).fail(function (jqXHR, textStatus) {
            console.log(textStatus);
      });
    }else{
      $.ajax({
        url: "/asignar-emp",
        type: "post",
        data: {asig:key,id:id,odt:<?=$page->id;?>},
        dataType: "html",
        }).done(function(msg){
          if(msg){
              swal({
            title: "Correcto",
            text: "Se actualizo el asignado",
            type: "success",
          })
          .then(willDelete => {
            if (willDelete) {
              window.location='';
            }
          });
          }
        }).fail(function (jqXHR, textStatus) {
            console.log(textStatus);
      });
    }
    
 });
  $('.add-button').on('click', function (e) {  
    $.ajax({
      url: "/add-product-odt",
      type: "post",
      data: {key:$(this).data('key'),canti:$("#canti-"+$(this).data('key')).val(),etapa:$("#etapa-"+$(this).data('key')).val(),odp:"<?=$page->id;?>"},
      dataType: "html",
    }).done(function(msg){
      console.log(msg);
     if(msg){
      swal({
        title: "Correcto",
        text: "Se agrego el producto a la OPD",
        type: "success",
      })
      .then(willDelete => {
        if (willDelete) {
          window.location='';
        }
      });
    }
  }).fail(function (jqXHR, textStatus) {
    console.log(textStatus);
  });
  e.preventDefault(); 
});
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
