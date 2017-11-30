<?php include('./_head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Modificar Producto
        <small>Modificar productos con su timeline para poder crear ODP con ellos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="box box-primary">
        <div class="box-header with-border row">
          <div class="col-md-6">
            <h3 class="box-title"><?= $page->title; ?></h3>
          </div>
        <form id="form-product">
          <input type="hidden" name="id_pro" value="<?= $page->id; ?>">
          <div class="col-md-6" align="right">
            <button type="submit" class="btn btn-success">Modificar Producto</button>
          </div>
        </div>
        <!-- Formulario de productos -->
        <div class="row" style="padding:16px;">
          <!-- Datos Basicos -->
          <div class="col-md-3">
            <h3 >Datos basicos</h3>
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
                <option value="4" <?php if($page->familia=='4') echo 'selected'; ?>>Mobiliario urbano</option>
                <option value="3" <?php if($page->familia=='3') echo 'selected'; ?>>Ciclismo urbano</option>
                <option value="2" <?php if($page->familia=='2') echo 'selected'; ?>>Señalizacion</option>
                <option value="1" <?php if($page->familia=='1') echo 'selected'; ?>>Vegetación urbana</option>
              </select>
            </div>
            <!--  Categoria del producto-->
             <?php $categories=file_get_contents('http://bktmobiliario.com/api/category/read.php');
                         $obj_cat = json_decode($categories); ?>
            <div class="form-group">
              <label>Categoria</label>
              <select name="categoria" id="subcategoria" class="form-control">
                <?php foreach ($obj_cat->categories->{$page->familia."/"}->subcategories as $subcategory) { ?>
                    <option <?php if($page->categoria==$subcategory->nombre) echo 'selected'; ?>><?= $subcategory->nombre; ?></option>
                <?php } ?>
              </select>
            </div>
            <!--  Nombre del Producto -->
            <div class="form-group">
              <label>Nombre</label>
              <input name="nombrep" id="nombrep" class="form-control" type="text" placeholder="Nombre del producto" value="<?=$page->title;?>">
            </div>
            <!--  Modelo del producto-->
            <div class="form-group">
              <label>Modelo</label>
              <input name="modelo" id="modelo" class="form-control" type="text" placeholder="Modelo del producto" value="<?=$page->modelo;?>">
            </div>
          </div>
          <!-- Tiempos de fabricación -->
          <?php $times=explode(',', $page->tiempos); ?>
          <div class="col-md-3">
            <h3>Fabricación</h3>
            <div class="input-group bootstrap-timepicker timepicker">
              <input name="tfab" id="tfab" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[0]); echo $ti[1];?>">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <hr>
            <!--  Linea del producto-->
            <div class="form-group">
              <label>Habilitado</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="thab" id="thab" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[1]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
            <!--  Familia del producto-->
            <div class="form-group">
              <label>Armado</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="tarm" id="tarm" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[2]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
            <!--  Categoria del producto-->
            <div class="form-group">
              <label>Acabado</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="taca" id="taca" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[3]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
            <!--  Nombre del Producto -->
            <div class="form-group">
              <label>Almacen</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="talm" id="talm" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[4]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
          </div>
          <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Ensamblar</h3>
            <div class="input-group bootstrap-timepicker timepicker">
              <input name="tens" id="tens" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[5]); echo $ti[1];?>">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <hr>
            <!--  Linea del producto-->
            <div class="form-group">
              <label>Habilitado</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="thab1" id="thab1" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[6]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
            <!--  Familia del producto-->
            <div class="form-group">
              <label>Armado</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="tarm1" id="tarm1" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[7]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
          </div>
          <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Empacar</h3>
            <div class="input-group bootstrap-timepicker timepicker">
              <input name="temp" id="temp" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[8]); echo $ti[1];?>">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <hr>
            <!--  Linea del producto-->
            <div class="form-group">
              <label>Empacar</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="temp1" id="temp1" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[9]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
            <!--  Familia del producto-->
            <div class="form-group">
              <label>Envolver</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input name="tenv" id="tenv" type="text" class="form-control input-small timepicker" value="<?php $ti=explode("/",$times[10]); echo $ti[1];?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
         </form>
          </div>
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
</div>
<!-- ./wrapper -->


<!-- REQUIRED JS SCRIPTS -->
<?php include('./_foot.php'); ?>
<script type="text/javascript">
    $('.timepicker').timepicker({
      showSeconds: false,
      showMeridian: false,
      defaultTime: '00:30 AM'
    });
   $('#form-product').on('submit', function (e) { 
    if($("#nombrep").val().length < 3){
    	swal("", "Ingrese el nombre del producto", "error");
    }else if($("#modelo").val().length < 3){
    	swal("", "Ingrese el nombre del modelo", "error");
    }else{
      $.ajax({
          url: "/add-product",
          type: "post",
          data: $(this).serialize(),
          dataType: "html",
        }).done(function(msg){
        	if(msg){
        			swal({
					  title: "Actualizado",
					  text: "El producto se modifico correctamente",
					  icon: "success",
					})
					.then(willDelete => {
					  if (willDelete) {
					    window.location="/productos";
					  }
					});
        	}
        }).fail(function (jqXHR, textStatus) {
            
        });
    }
    e.preventDefault(); 
  });



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
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>


