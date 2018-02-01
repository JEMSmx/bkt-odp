<?php if($input->get->date=='') exit;
      //$emp=$input->get->id; 
      //$user=$users->get($emp);
      $date=date($input->get->date);
      $test = new DateTime($input->get->date);
      function weekyear ($date) { list($day,$month,$year) = explode('-', $date); return strftime("%W", mktime(0,0,0,$month,$day,$year));  } 
      $meses=array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Imprimir Actividad</title>
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="window.print();window.close();">
  <style>
    h1 {
      font-size: 30px;
    }
    h2 {
      font-size: 22px;
    }
    h3{
      font-size: 18px;
    }
    h4{
      font-size: 14px;
    }
    p {
      font-size: 12px;
    }
  </style> 
  <?php $inc1=0; foreach ($users->find("roles=empleado, status=published") as $emp) { 
        $inc1++;
        $d=date_format($test, 'Y-m-d'); 
        $imp=0;
        foreach ($emp->children("ini*=$d, sort=ini, status=published, odt!=") as $key => $value) {
          $hori=explode(" ", $value->ini);
          $horf=explode(" ", $value->fin); 
          if($hori[0]!=$d) continue; 
          $imp++;}

      if ($imp==0) continue; ?> 
  <div class="row" style="max-width: 996px;margin:0 auto;">
    <!-- Fechas -->
    <div class="col-xs-6">
      <h1>Actividades a realizar</h1>
      <h2>Semana <?=weekyear($date)?></h2>
      <h3><?php $hoy=explode("-", $d); echo $hoy[2].' '.$meses[intval($hoy[1])].' '.$hoy[0]; ?></h3>
    </div>
    <!-- Para -->
    <div class="col-xs-6" align="right">
      <h3>
        <strong>Nombre:</strong>
      </h3>
      <h1><?=$emp->namefull;?></h1>
    </div>
    <!-- Actividad -->
    <?php $inc=0;
        foreach ($emp->children("ini*=$d, sort=ini, status=published, odt!=") as $key => $value) {
          $hori=explode(" ", $value->ini);
          $horf=explode(" ", $value->fin); 
          if($hori[0]!=$d) continue; 
          $inc++;?>
    
    <div class="col-xs-12">
      <hr style="border-top: 4px solid #484848;">
      <h3 style="padding: 10px;
    border: solid 4px #484848;">Horario: <?=$hori[1]?> a <?=$horf[1]?></h3>
      <!--  Datos de la actividad  -->
      <section class="col-xs-4" style="min-height: 170px;padding: 16px;border: solid 4px #484848;border-right: none;">
        <?php $product=$pages->get($value->odt->prid); 
        if($value->odt->type!='extra-activity'){ ?> 
          <img src="https://bktmobiliario.com/uploads/<?=$product->miniatura?>" width="50" height="30">
        <?php } ?>
        <h4 style="margin-top:0;"><?= $value->odt->title.' '.$product->title; ?></h4>
        <h4 style="margin-top:0;">Cantidad: <?= $value->odt->cant; ?></h4>
        <p><strong>ODP:</strong> <?=$value->odt->parent()->title?>    <?php if($value->odt->parent()->title!='Actividades extra'){?><strong>ODT:</strong> <?=$value->odt->parent()->numodt?><?php }?></p>
      </section>
      <!-- Observaciones -->
      <section class="col-xs-4" style="min-height: 170px;padding: 16px;border: solid 4px #484848;border-right: none;">
        <h4 style="margin-top:0;">Observaciones:</h4>
      </section>
      <!-- Firmas -->
      <section class="col-xs-4" style="min-height: 170px;padding: 16px;border: solid 4px #484848;text-align: center;">
        <h4 style="margin-top:0;text-align: left;">Firmas:</h4>
        <p style="border-top: dotted 4px #484848;margin-top:25px;"><strong><?=$emp->namefull;?></strong></p>
        <p style="border-top: dotted 4px #484848;margin-top:30px;"><strong>Jefe de producción recibe</strong></p>
      </section>
    
    <?php if($inc==6){
            $inc=3;
            echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
          } ?>
          </div><?php
        } ?>
  </div>
  <?php  echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'; } ?>
</body>
</html>
