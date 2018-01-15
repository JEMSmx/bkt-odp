<?php include('./_head.php'); ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.css">

<body>
<div class="wrapper">

 

  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Productos
        <small>Lista con todos los productos dados de alta</small>
      </h1>
    </section>

    <!-- Main content -->
     <section class="content container-fluid">
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
                  <?php    $categories=array('', 'Vegetacion urbana', 'Señalizacion', 'Ciclismo urbano', 'Mobiliario urbano');
                       $etps=array('', 'Fabricación', 'Ensamblar', 'Empacar');
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
                        <td><a href="<?=$product->url;?>" target="_top"><button type="button" class="btn btn-block btn-primary btn-xs">Modificar</button></a></td>
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
    $.ajax({
      url: "/add-product-odt",
      type: "post",
      data: {key:$(this).data('key'),canti:$("#canti-"+$(this).data('key')).val(),etapa:$("#etapa-"+$(this).data('key')).val(),odp:"<?=$input->get->odp;?>"},
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
          
          window.parent.location.reload();
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
