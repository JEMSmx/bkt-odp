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
        <li><a href="/calendario"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/ordenes-de-produccion">Ordenes de produccion</a></li>
        <li class="active"><?= $page->title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="col-md-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?=$page->title?></h3>
                <p>
                  Cliente: <?=$page->cliente?>
                  <br>
                  ODT: <?=$page->numodt?>
                  <br>
                  Cotización: <?=$page->cotizacion?>
                </p>
                <?php $date1 = new DateTime(date('m/d/Y'));
                      $date2 = new DateTime($page->fechaf);
                      $diff = $date1->diff($date2);
                      $meses=array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                      $fci=explode('/',$page->fechai);
                      $fcf=explode('/',$page->fechaf);?>
                <p>Del: <?=$fci[1].' '.$meses[intval($fci[0])].' '.$fci[2]?><br>Al: <?=$fcf[1].' '.$meses[intval($fcf[0])].' '.$fcf[2]?></p>
                
                <p>Quedan <strong><?=$diff->days?> días</strong> para terminar la ODP</p>
                <?php $work=$page;
                        if($work->children()->count()==0)
                            $porcen=0;
                        else
                        $porcen=($work->children("state=3")->count()*100)/($work->children()->count());

                      ?>  
                <div class="progress progress-sm active">
                  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?=round($porcen);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($porcen);?>%">
                    <span class="sr-only"><?=round($porcen);?>% Complete</span>
                  </div>
                </div>
              </div>
              <div class="icon">
                <i class="fa fa-newspaper-o"></i>
              </div>
            </div>
          </div>
          <!-- Botones -->
          <div class="col-md-6">
            <!-- small box -->
            <div style="min-height: 236px;
                        display: flex;
                        width: 100%;
                        justify-content: center;
                        align-items: flex-end;">
              <div style="width: 100%;">
                <!-- <a data-fancybox data-type="iframe" data-src="/tabla-de-productos?odp=<?=$page->id?>" href="javascript:;"> -->
                  <button data-toggle="modal" data-target="#modal-default" type="button" class="btn btn-block btn-success btn-lg"><i class="fa fa-plus-square"></i> Agregar un Producto</button>
               <!--  </a> -->
                <button style="margin-top: 5px;" type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#modal-info"><i class="fa fa-plus-square-o"></i> Agregar una Actividad</button>
                <div class="btn-group" style="width: 100%; margin-top: 4px;">
                  <button type="button" class="btn dropdown-toggle btn-lg" data-toggle="dropdown" style="width: 100%;background-color: #4191a5;border-color: #4191a5;color: white;">
                    Ver Calendario Técnico
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu" style="width: 100%;">
                    <?php $empleados=$users->find("roles=empleado, status=published"); 
                      foreach($empleados as $empleado){ ?> 
                    <li><a href="/calendario/<?=$empleado->name?>"><?=$empleado->namefull?></a></li>
                    <?php  } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

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
                      <td><?= ($value->prid==0) ?  $value->title:$product->title ?></td>
                      <td><?= ($value->type=='extra-activity') ? 'Actividad extra':$value->title; ?></td>
                      <td><?php $title_cl=explode('/', $value->title);
                                $titlecl=trim($title_cl[0]);
                                $ch=$product->children("title=$titlecl, include=all");
                              if($value->cant==1){ 
                                echo $value->duration; 
                              }else{
                                echo $ch[0]->duration;
                              } ?></td>
                      <td><?= $value->cant ?></td>
                      <td><?php if($value->type=='extra-activity'){echo $value->duration;}else{if($ch[0]->duration==$value->duration) echo mulhours($value->duration, $value->cant); else echo $value->duration;}?></td>
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
                </table>
              </div>
                <?php  $categories=array('', 'Vegetacion urbana', 'Señalizacion', 'Ciclismo urbano', 'Mobiliario urbano');
                       $etps=array('', 'Fabricación', 'Ensamblar', 'Empacar');
                       $products = array(); $cantid = 0; $cants = array(); $etapas = array(); $respri=0; $etas=array();
                       foreach($page->children("sort=cant, prid!=0") as $value) {
                           $etas[$value->title]=$value->title;
                       }
                        foreach($page->children("sort=cant, prid!=0") as $value) {
                          if($respri==$value->prid)
                            $respri=$value->prid;
                          else{
                            $respri=$value->prid;
                            $cantid=0;
                          }
                          $products[$value->prid.$value->etapa] = $pages->get($value->prid); 
                          $pos = strpos($value->title, key($etas));
                          if ($pos !== false) {
                               $cantid+=$value->cant;
                          }
                          $cants[$value->prid.$value->etapa] = $cantid; 
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
                        <th>Asignar</th>
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
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-success btn-xs edit">Asignar</button></td>
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
                        <input type="hidden" name="et-<?=$value->id?>" value="<?=$etapas[$key];?>">
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-success btn-xs update">Actualizar</button></td>
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-danger btn-xs delete">Eliminar</button></td>
                        <td><button data-id="<?=$value->id?>" data-etp="<?=$etapas[$key]?>" type="button" class="btn btn-block btn-primary btn-xs cancel">Cancelar</button></td>
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
    
    <section class="content container-fluid" style="display: none">
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
<form id="add-activity">
  <div class="modal" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Agregar Actividad</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Nombre de la actividad <b style="margin-left: 8px">1/2</b></h4>
          <input class="form-control input-lg" type="text" placeholder="" name="title">
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
  <!-- /.content-wrapper -->
   <div class="modal" id="modal-info1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white;">×</span></button>
          <h3 class="modal-title" style="color: white;">Agregar Actividad</h3>
        </div>
        <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
          <h4>Duración de la actividad <b style="margin-left: 8px">2/2</b></h4>
              <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control input-small timepicker" name="duration">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
        <div class="modal-footer" style="background-color: #566676;">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
           <button type="submit" class="btn btn-success">Terminar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <input type="hidden" name="odp" value="<?=$page->id?>">
  <input type="hidden" name="cant" value="1">
  <input type="hidden" name="type" value="extra-activity"> 
</form>

  <!-- Main Footer -->
  <?php include('./_main-footer.php'); ?>


  <form id="add-product">
  <div class="modal fade in" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #333d47">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h3 class="modal-title" style="color: white;">Agregar Producto a la ODP</h3>
      </div>
      <div class="modal-body" style="background-color: white;text-align:center;padding: 40px;">
        <div class="row">
          <!-- Datos basicos -->
          <input type="hidden" name="odp" value="<?=$page->id?>">
          <div class="col-md-6" style="text-align: left;">
            <!--  Linea del producto-->
            <div class="form-group">
              <label>Linea</label>
              <select name="linea" id="linea" class="form-control">
                <option>BKT Mobiliario Urbano</option>
                <option>MMCite</option>
                <option>Otra opción</option>
              </select>
            </div>
            <!--  Familia del producto-->
            <div class="form-group">
              <label>Familia</label>
              <select name="familia" id="familia" class="form-control">
                <option>Selecciona</option>
                <option value="4">Mobiliario urbano</option>
                <option value="3">Ciclismo urbano</option>
                <option value="2">Señalizacion</option>
                <option value="1">Vegetación urbana</option>
              </select>
            </div>
            <!--  Categoria del producto-->
            <div class="form-group">
              <label>Categoria</label>
              <select name="categoria" id="subcategoria" class="form-control" disabled>
                <option>Selecciona</option>
              </select>
            </div>
            <!--  Nombre del Producto -->
            <div class="form-group">
              <label>Producto</label>
              <select class="form-control" id="nombrep" name="nombrep" disabled="">
                <option>Selecciona</option>
              </select>
            </div>
            <!--  Modelo del producto-->
             <div class="form-group">
              <label>Modelo</label>
              <select class="form-control" id="modelo" name="key" disabled="">
                <option>Selecciona</option>
              </select>
            </div>
          </div>
          <!-- Cantidad y desde que proceso -->
          <div class="col-md-6" style="text-align: left;">
            <div class="form-group">
              <label>Cantidad de productos</label>
              <input class="form-control" type="number" name="canti" placeholder="Numero de productos" value="1">
            </div>
            <div class="form-group">
              <label>Desde que proceso</label>

              <select name="etapa" id="linea" class="form-control">
                <option value="1">Fabricación</option>
                <option value="2">Emsamble</option>
                <option value="3">Empacado</option>
              </select>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #566676;">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Agregar a la ODP</button>
      </div>
    </div>
  </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<?php include('./_foot.php'); ?>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable();
    $('#example3').DataTable();
    $('#example5').DataTable();
  })
  
  $("#familia").change(function() {
    $('*').css('cursor', 'wait');
    $("#subcategoria").prop('disabled', false);
        $.ajax({
          url: "/subcategories",
          type: "post",
          data: {fam:$("#familia").val()},
          dataType: "html",
        }).done(function(msg){
          if(msg){
            $('*').css('cursor', '');
            $('#subcategoria').html(msg);
          }
        }).fail(function (jqXHR, textStatus) {
            
        });        
    });
   $("#subcategoria").change(function() {
    $('*').css('cursor', 'wait');
    $("#nombrep").prop('disabled', false);
        $.ajax({
          url: "/select-products-odt",
          type: "post",
          data: {id_sub:$("#subcategoria").val()},
          dataType: "html",
        }).done(function(msg){
          if(msg){
            $('*').css('cursor', '');
            $('#nombrep').html(msg);
          }
        }).fail(function (jqXHR, textStatus) {
            
        });        
    });
   $("#nombrep").change(function() {
    $('*').css('cursor', 'wait');
    $("#modelo").prop('disabled', false);
        $.ajax({
          url: "/select-products-odt",
          type: "post",
          data: {id_pro:$("#nombrep").val(),type:'model'},
          dataType: "html",
        }).done(function(msg){
          if(msg){
            $('*').css('cursor', '');
            $('#modelo').html(msg);
          }
        }).fail(function (jqXHR, textStatus) {
            
        });        
    });
  $('.timepicker').timepicker({
      showSeconds: false,
      showMeridian: false,
      defaultTime: '00:00 AM'
    });

  $( "#add-activity" ).submit(function( event ) {
    $.ajax({
          url: "/add-activity",
          type: "post",
          data: $(this).serialize(),
          dataType: "html",
          }).done(function(msg){
            $('#modal-info1').modal('toggle');
            if(msg){
                swal({
              title: "Correcto",
              text: "Se ha creado la actividad",
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
    
    event.preventDefault();
  });

  
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
   $(".del-act").click(function() {
    var id=$(this).data('id');
    swal({
      title: '¿Estás seguro?',
      text: "La actividad será eliminada de la OPD",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Quiero borrarla',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
          $.ajax({
          url: "/delete-activity",
          type: "post",
          data: {key:id,odp:'<?=$page->id?>',edit:'delete'},
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
    }
    
 });



$("#add-product").submit(function(e) {
  $.ajax({
      url: "/add-product-odt",
      type: "post",
      data: $(this).serialize(),
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
          parent.location.reload();
        }
      });
    }
  }).fail(function (jqXHR, textStatus) {
    console.log(textStatus);
  });
  e.preventDefault(); 
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
