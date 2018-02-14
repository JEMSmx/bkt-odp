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
        <li><a href="/calendario"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="/productos"><i class="fa fa-dashboard"></i>Productos</a></li>
        <li class="active">Modificar producto</li>
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
              <select name="linea" id="linea" class="form-control" disabled>
                <option>BKT Mobiliario Urbano</option>
                <option>MMCite</option>
                <option>Otra opción</option>
              </select>
            </div>
            <!--  Familia del producto-->
            <div class="form-group">
              <label>Familia</label>
              <select name="familia" id="familia" class="form-control" disabled>
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
              <select name="categoria" id="subcategoria" class="form-control" disabled>
                <?php foreach ($obj_cat->categories->{$page->familia."/"}->subcategories as $subcategory) { ?>
                    <option <?php if($page->categoria==$subcategory->nombre){ echo 'selected'; $idcat=$subcategory->id;}; ?>><?= $subcategory->nombre; ?></option>
                <?php } ?>
              </select>
            </div>
            <!--  Nombre del Producto -->
            <?php $products_in_category=file_get_contents('http://bktmobiliario.com/api/product/read.php?id='.$idcat);
                         $obj_pro_in_cat = json_decode($products_in_category); ?>
            <div class="form-group">
              <label>Producto</label>
              <select class="form-control" id="nombrep" name="nombrep" disabled>
                <?php foreach ($obj_pro_in_cat->products as $product) { ?>
                    <option data-id="<?=$product->id?>" <?php if($page->title==$product->nombre){ echo 'selected'; $idpr=$product->id;}; ?>><?= $product->nombre; ?></option>
                <?php } ?>
              </select>
            </div>
            <!--  Modelo del producto-->
            <?php $models=file_get_contents('http://bktmobiliario.com/api/product/read.php?id_product='.$idpr);
                         $obj_model = json_decode($models); ?>
            <div class="form-group">
              <label>Modelo</label>
              <select class="form-control" id="modelo" name="modelo" disabled>
                <?php foreach ($obj_model->products[0]->modelos as $model) { ?>
                    <option data-id="<?=$idpr?>" <?php if($page->modelo==$model->nombre){ echo 'selected';}; ?>><?= $model->nombre; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- Tiempos de fabricación -->
          <?php $times=$page->children(); ?>
          <div class="col-md-3">
            <h3>Fabricación <small id="fabtime"></small><i id="iconfab" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <hr>
            <div id="colapsable-container-fab">
              <!--  Linea del producto-->
              <div class="form-group">
                <label>Habilitar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker fabricacion" id="thab" name="thab" value="<?=$times[0]->duration?>" data-minute-step="5">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
              <!--  Familia del producto-->
              <div class="form-group">
                <label>Armar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker fabricacion" id="tarm" name="tarm" value="<?=$times[1]->duration?>" data-minute-step="5">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
            </div>
          </div>
           <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Ensamblar <small id="enstime"></small><i id="icontens" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <hr>
            <!--  Linea del producto-->
            <div class="form-group" id="colapsable-container-ens">
              <label>Ensamblar</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control input-small timepicker ensamblar" id="tens" name="tens" value="<?=$times[2]->duration?>" data-minute-step="5">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
          </div>
          <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Empacar <small id="emptime"></small> <i id="iconEmp" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <hr>
            <div id="colapsable-container-emp">
              <!--  Familia del producto-->
              <div class="form-group">
                <label>Envolver</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker empacar" id="tenv" name="tenv" value="<?=$times[3]->duration?>" data-minute-step="5">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
              <!--  Linea del producto-->
              <div class="form-group">
                <label>Entarimar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker empacar" id="tent" name="tent" value="<?=$times[4]->duration?>" data-minute-step="5">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
            </div>
           </div>
         </form>
          </div>
        </div>
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- Main Footer -->
  <?php include('./_main-footer.php'); ?>
</div>
<!-- ./wrapper -->


<!-- REQUIRED JS SCRIPTS -->
<?php include('./_foot.php'); ?>
<script type="text/javascript">
    $('.timepicker').timepicker({
      showSeconds: false,
      showMeridian: false,
      defaultTime: '00:00 AM'
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
          console.log(msg);
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
   $("#subcategoria").change(function() {
    $('*').css('cursor', 'wait');
    $("#nombrep").prop('disabled', false);
        $.ajax({
          url: "/select-products",
          type: "post",
          data: {id_sub:$("#subcategoria").find(':selected').data('id')},
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
          url: "/select-products",
          type: "post",
          data: {id_pro:$("#nombrep").find(':selected').data('id'),type:'model'},
          dataType: "html",
        }).done(function(msg){
          console.log(msg);
          if(msg){
            $('*').css('cursor', '');
            $('#modelo').html(msg);
            $('#form-product').append('<input type="hidden" value='+$("#nombrep").find(':selected').data('id')+' name="pro_id">');
          }
        }).fail(function (jqXHR, textStatus) {
            
        });        
    });

   $("#modelo").change(function() {
         $('#form-product').append('<input type="hidden" value='+$("#modelo").find(':selected').data('id')+' name="pro_id_res">');   
    })

   $('.fabricacion').change(function(){
      var thab=$( "#thab" ).val();
      var tarm=$( "#tarm" ).val();
      $( "#fabtime" ).text(sumarHoras(thab,tarm)+' hrs');
      if(thab!='00:00' && tarm!='00:00'){
        $( "#iconfab").show();
      }else if(thab=='00:00' || tarm=='00:00'){
        $( "#iconfab").hide();
      }
  })
  $('.ensamblar').change(function(){
      var tens=$( "#tens" ).val();
      $( "#enstime" ).text(tens+' hrs');
      if(tens!='00:00'){
        $( "#icontens").show();
      }else if(tens=='00:00'){
        $( "#icontens").hide();
      }
  });
  $('.empacar').change(function(){
      var tenv=$( "#tenv" ).val();
      var tent=$( "#tent" ).val();
      $( "#emptime" ).text(sumarHoras(tenv,tent) +' hrs');
      if(tenv!='00:00' && tent!='00:00'){
        $( "#iconEmp").show();
      }else if(tent=='00:00' || tent=='00:00'){
        $( "#iconEmp").hide();
      }
  });

  $('#checkFab').change(function() {
      $( "#colapsable-container-fab" ).toggle();
    });
  $('#checkEns').change(function() {
      $( "#colapsable-container-ens" ).toggle();
    });
  $('#checkEmp').change(function() {
      $( "#colapsable-container-emp" ).toggle();
    });


  function sumarHoras(h1,h2){
    var hora1 = (h1).split(":"),
    hora2 = (h2).split(":"),
    t1 = new Date(),
    t2 = new Date();
 
    t1.setHours(hora1[0], hora1[1]);
    t2.setHours(hora2[0], hora2[1]);
     
     t1.setHours(t1.getHours() + t2.getHours(), t1.getMinutes() + t2.getMinutes());
    //Aquí hago la resta
    return (t1.getHours()+':'+t1.getMinutes());
  }

</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>


