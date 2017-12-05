<?php include('./_head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('./_lat.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Agregar producto
        <small>Agrega productos con su timeline para poder crear ODP con ellos</small>
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
            <h3 class="box-title">Nuevo producto</h3>
          </div>
        <form id="form-product">
          <div class="col-md-6" align="right">
            <button type="submit" class="btn btn-success">Agregar Producto</button>
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
              <select class="form-control" id="nombrep" name="nombrep" disabled>
                <option>Selecciona</option>
              </select>
            </div>
            <!--  Modelo del producto-->
             <div class="form-group">
              <label>Modelo</label>
              <select class="form-control" id="modelo" name="modelo" disabled>
                <option>Selecciona</option>
              </select>
            </div>
          </div>
          <!-- Tiempos de fabricación -->
          <div class="col-md-3">
            <h3>Fabricación <small id="fabtime"></small><i id="iconfab" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <div class="checkbox">
              <label>
                <input id="checkFab" name="checkFab" type="checkbox">Activar
              </label>
            </div>
            <hr>
            <div id="colapsable-container-fab" style="display:none;">
              <!--  Linea del producto-->
              <div class="form-group">
                <label>Habilitar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker fabricacion" id="thab" name="thab">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
              <!--  Familia del producto-->
              <div class="form-group">
                <label>Armar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker fabricacion" id="tarm" name="tarm">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
            </div>
          </div>
           <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Ensamblar <small id="enstime"></small><i id="icontens" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <div class="checkbox">
              <label>
                <input id="checkEns" name="checkEns" type="checkbox">Activar
              </label>
            </div>
            <hr>
            <!--  Linea del producto-->
            <div class="form-group" id="colapsable-container-ens" style="display:none;">
              <label>Ensamblar</label>
              <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control input-small timepicker ensamblar" id="tens" name="tens">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
            </div>
          </div>
          <!-- Tiempos de ensamblado -->
          <div class="col-md-3">
            <h3>Empacar <small id="emptime"></small> <i id="iconEmp" class="fa fa-fw fa-check-circle-o text-green" style="display:none"></i></h3>
            <div class="checkbox">
              <label>
                <input id="checkEmp" name="checkEmp" type="checkbox">Activar
              </label>
            </div>
            <hr>
            <div id="colapsable-container-emp" style="display:none;">
              <!--  Familia del producto-->
              <div class="form-group">
                <label>Envolver</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker empacar" id="tenv" name="tenv">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
              <!--  Linea del producto-->
              <div class="form-group">
                <label>Entarimar</label>
                <div class="input-group bootstrap-timepicker timepicker">
                  <input type="text" class="form-control input-small timepicker empacar" id="tent" name="tent">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
              </div>
            </div>
           </div>
            <!-- /!Termina -->
          </div>
         </form>
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
      defaultTime: '00:00 AM'
    });
   $('#form-product').on('submit', function (e) { 
    if($("#familia").val() == 'Selecciona'){
      swal("", "Seleccione la familia", "error");
      $("#familia").focus();
    }else if($("#subcategoria").val() == 'Selecciona'){
      swal("", "Seleccione la categoria", "error");
      $("#subcategoria").focus();
    }else if($("#nombrep").val() == 'Selecciona'){
    	swal("", "Seleccione un producto", "error");
      $("#nombrep").focus();
    }else if($("#modelo").val() == 'Selecciona'){
    	swal("", "Seleccione la categoria", "error");
      $("#modelo").focus();
    }else{
      $.ajax({
          url: "add-product",
          type: "post",
          data: $(this).serialize(),
          dataType: "html",
        }).done(function(msg){
        	if(msg){
        			swal({
					  title: "Agregado",
					  text: "El producto se agrego al catalogo",
					  icon: "success",
					})
					.then(willDelete => {
					  if (willDelete) {
					    //window.location="";
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
          }
        }).fail(function (jqXHR, textStatus) {
            
        });        
    });
   $('.fabricacion').change(function(){
      var thab=$( "#thab" ).val();
      var tarm=$( "#tarm" ).val();
      $( "#fabtime" ).text(sumarHoras(thab,tarm)+' hrs');
      if(thab!='00:00' && tarm!='00:00'){
        $( "#iconfab").show();
      }else if(thab=='00:00' || tarm=='00:00'){
        $( "#iconfab").hide();
      }
  });
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


