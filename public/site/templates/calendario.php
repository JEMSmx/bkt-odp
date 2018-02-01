<?php include('./_head.php');
 $dateH=isset($input->get->date) ? date($input->get->date):date('Y-m-d');
 $user_cal = $users->get($input->urlSegment1);
if(!$user_cal->id && $input->urlSegment1!=''){ $session->redirect("/"); }  ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $meses=array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
          $semana=inicio_fin_semana($dateH);
          $inis=explode('-', $semana['fechaInicio']);
          $inif=explode('-', $semana['fechaFin']); 
          $adelante=date("Y-m-d",strtotime($dateH."+ 7 days"));
          $atras=date("Y-m-d",strtotime($dateH."- 7 days"));?>
    <div class="col-md-12">
    <h2><a href="/calendario/?date=<?=$atras?>" target="_top"><i class="fa fa-angle-left" aria-hidden="true"></i> </a> Semana <?=date("W",strtotime($dateH))?> <a href="/calendario/?date=<?=$adelante?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a> <small> <?=$inis['2']?> de <?=$meses[intval($inis['1'])]?> al <?=$inif['2']?> de <?=$meses[intval($inif['1'])]?></small></h2>
    </div>
    <section class="content-header" style="position: unset;">
      <h1>
        Calendario<strong><?= ($input->urlSegment1=='') ?  ' General':' '.$user_cal->namefull;?></strong>
        <small>Calendario de actividades desglozadas por día y semana </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Calendario</li>
      </ol>
    </section>

    <?php if($input->urlSegment1==''){ ?> 
        <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php $odps=$pages->find("template=work"); ?>
              <h3><?=$odps->count();?></h3>

              <p>ODP Activas</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php $acts=$pages->find("template=activities, status=published, state<1, assign="); ?>
              <h3><?=$acts->count();?><sup style="font-size: 20px"></sup></h3>
              <p>Tareas por Asignar</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php $acts=$pages->find("template=activities, status=published, state=2"); ?>
              <h3><?=$acts->count();?><sup style="font-size: 20px"></sup></h3>

              <p>Tareas Activas</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <?php      $iniSem=$inis[2]; 
                   $mod_date=$semana['fechaInicio'];
                    $hora='00:00';$ade='00:00';$asi='00:00';
                     for ($i=0; $i < 5 ; $i++) { 
                      $totDis=0; $totCom=0; $totAsi=0;
                      $empleados=$users->find("roles=empleado, status=published"); 
                      foreach($empleados as $empleado){  
                        $totDis+=8;
                        foreach ($empleado->children("odt!=") as $key => $event) {
                          $fechEvento=explode(" ", $event->ini);
                          if($iniSem<10)
                            $inS='0'.$iniSem;
                          else
                            $inS=$iniSem;

                          $hoy=$mod_date;
                          if($hoy==$fechEvento[0]){
                            if($event->odt->cant<=1)
                              $hora=sumarHoras($hora,$event->odt->duration);
                            else
                              $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                            $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                            $fecha_entrada = strtotime($event->fin);
                            if($event->odt->cant<=1)
                              $asi=sumarHoras($asi,$event->odt->duration);
                            else
                              $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                              if(intval($event->odt->state)==3){
                                if($event->odt->cant<=1)
                                  $ade=sumarHoras($ade,$event->odt->duration);
                                else
                                  $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                              }
                          }
                        } 
                        
                      } 
                      $mod_date = strtotime($mod_date."+ 1 days");
                      $iniSem=date("d",$mod_date);
                     }
                      $horTra=$ade;
                      $ade=convertDec($ade); 
                      $asi=convertDec($asi); 
                      $totCom+=$ade;
                      $totAsi+=$asi;
                    $por=($totAsi==0) ? 0:($totCom*100)/$totAsi; ?>
        

        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=round($por,2)?>%</h3>
              <p>Eficiencia semanal</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col 
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php //round(convertDec($horTra),2)?></h3>

              <p>Horas trabajadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            
          </div>
        </div> -->
       



        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- Lunes -->
              <?php $find=date('w',strtotime($dateH))-1;
                    $mod_date=date($semana['fechaInicio']);
                    $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
                     for ($i=0; $i < count($dias) ; $i++) { 
                      $totDis=0; $totCom=0; $totAsi=0;
                      $empleados=$users->find("roles=empleado, status=published"); 
                      foreach($empleados as $empleado){  
                        $totDis+=8;
                        $hora='00:00';$ade='00:00';$asi='00:00';
                        foreach ($empleado->children('odt!=') as $key => $event) {
                          $fechEvento=explode(" ", $event->ini);
                          if($iniSem<10)
                            $inS='0'.$iniSem;
                          else
                            $inS=$iniSem;

                          $hoy=$mod_date;
                          if($hoy==$fechEvento[0]){
                            if($event->odt->cant<=1)
                              $hora=sumarHoras($hora,$event->odt->duration);
                            else
                              $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                            $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                            $fecha_entrada = strtotime($event->fin);
                            if($event->odt->cant<=1)
                              $asi=sumarHoras($asi,$event->odt->duration);
                            else
                              $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                              if(intval($event->odt->state)==3){
                                if($event->odt->cant<=1)
                                  $ade=sumarHoras($ade,$event->odt->duration);
                                else
                                  $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                              }
                          }
                        } 
                        $ade=convertDec($ade); 
                        $asi=convertDec($asi); 
                        $totCom+=$ade;
                        $totAsi+=$asi;
                      }?> 
              <div class="col-md-<?= ($i==$find) ? 4:2 ?>" style="<?= ($i==$find) ? '':'opacity:0.55;filter: grayscale(85%);' ?>">
                <h3><?=$dias[$i].' '.$iniSem?></h3>
                 <?php $por=($totAsi==0) ? 0:($totCom*100)/$totAsi;
                       if($por>20 && $por<80)
                          $co='yellow';
                       else if($por>80)
                          $co='green';
                       else
                          $co='red'; ?>
                <div class="info-box bg-<?=$co?>">
                  <div class="info-box-content" style="margin:0;">
                    <span class="info-box-text">Asignación</span>
                    <span class="info-box-number" style="font-weight: 300;font-size: 14px;"><?=round($totDis,2)?> Horas disponibles</span>
                    <span class="info-box-number" style="font-weight: 300;font-size: 14px;"><?=round($totAsi,2)?> Horas asignadas</span>
                    <span class="info-box-number" style="font-weight: 300;font-size: 14px;"><?=round($totDis-$totAsi,2)?> Horas libres</span>
                    <div class="progress">
                      <div class="progress-bar" style="width: <?=$por?>%"></div>
                    </div>
                    <span class="progress-description">
                      <?=round($por,2)?>% de progreso
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                 <a href="/impresion?date=<?=date($iniSem.'-m-Y')?>" target="_blank"><button type="button" class="btn btn-block btn-primary">Imprimir</button></a><br>
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Trabajadores</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                      <!-- Trabajador -->
                    <?php $empleados=$users->find("roles=empleado, status=published"); 
                          foreach($empleados as $empleado){  
                            $hora='00:00';$ade='00:00'; $pas='00:00'; 
                              foreach ($empleado->children('odt!=') as $key => $event) {
                                      $fechEvento=explode(" ", $event->ini);
                                      if($iniSem<10)
                                        $inS='0'.$iniSem;
                                      else
                                        $inS=$iniSem;

                                      $hoy=$mod_date;
                                      if($hoy==$fechEvento[0]){
                                        if($event->odt->cant<=1)
                                          $hora=sumarHoras($hora,$event->odt->duration);
                                        else
                                          $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                                        $fecha_actual = strtotime(date("Y-m-".$inS." H:i:s",time()));
                                        $fecha_entrada = strtotime($event->fin);
                                        //echo $fecha_actual.'-'.$fecha_entrada.'/';
                                        if($fecha_actual > $fecha_entrada){
                                          
                                          if(intval($event->odt->state)==3){
                                            if($event->odt->cant<=1)
                                              $ade=sumarHoras($ade,$event->odt->duration);
                                            else
                                              $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                                          }else if(intval($event->odt->state)<3){
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
                                          }else if(intval($event->odt->state)==3){
                                            if($event->odt->cant<=1)
                                              $ade=sumarHoras($ade,$event->odt->duration);
                                            else
                                              $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                                          }
                                        }
                                      }
                               } 
                               $ade=convertDec($ade); $pas=convertDec($pas);
                               $hr=$ade-$pas;
                               $eti=($hr>0) ? 'success':'danger';?>
                     

                      <li style="width: 100%">
                        <div style="width: 100%;text-align: left;padding-bottom: 0;display: flex;justify-content: center;align-items: center;margin-bottom: 8px;">
                          <?php if($i==$find){ 
                             $image=$empleado->images->first();
                              if($image){
                                $imgpro = $image->size(160, 160, array('quality' => 80, 'upscaling' => false, 'cropping' => true));
                              } ?>
                          <img class="direct-chat-img" src="<?php if($image) echo $imgpro->url; else echo 'https://www.popvox.com/images/user-avatar-grey.png'?>" alt="<?=$empleado->namefull?>" style="margin-right: 8px;">
                          <?php } ?>
                          <a class="users-list-name" style="font-size: 24px;" href="/calendario/<?=$empleado->name?>"><?=$empleado->namefull?></a>
                        </div>
                        <a href="/calendario/<?=$empleado->name?>" class="btn btn-sm btn-primary pull-center" style="width:100%;">Asignar Tareas</a>
                        <span class="users-list-date" style="color:#333;"><b style="font-size:<?=($i==$find) ? '24':'14';?>px;"><?=round(convertDec($hora),2)?>/8</b> Horas asignadas</span>
                        <span class="users-list-date" style="color:#333;"><b style="font-size:<?=($i==$find) ? '24':'14';?>px;"><?=round($ade,2);?>/<?=round(convertDec($hora),2)?></b> Horas laboradas</span>
                        <hr style="margin: 8px 0 0 0;">
                      </li>
                      <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.box-footer -->
                </div>
              </div>
              <?php  
                      $mod_datew = strtotime($mod_date."+ 1 days");
                      $iniSem=date("d", $mod_datew);
                      $mod_date=date("Y-m-d",$mod_datew);
                       
                       } ?>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <?php }else{ 
      $inputTarea=isset($_SESSION['tarea']) ? $_SESSION['tarea']:''; ?> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-9">
          <div class="box box-primary">
           <div class="box-body no-padding">
             <!-- Zoom Controls -->
             <div class="col-md-6">
             </div>
             <div class="col-md-6" style="display: flex;justify-content: flex-end;padding-top: 8px;">
               <!-- Acercar -->
               <a class="btn btn-app zoom-in" style="padding: 8px; min-width: 0;height: auto;">
                 <i class="fa fa-search-plus"></i>
               </a>
               <!-- Alejar -->
               <a class="btn btn-app zoom-out" style="padding: 8px; min-width: 0;height: auto;">
                 <i class="fa fa-search-minus" ></i>
               </a>
             </div>
             <!-- THE CALENDAR -->
             <div id="calendar"></div>
           </div>
           <!-- /.box-body -->
         </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <!-- Barra derecha de actividades -->
          <div class="col-md-3">
            <!-- Calendarios Container-->
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Calendarios</h3>
              </div>
              <div class="box-body">
                <div class="btn-group" style="width: 100%;">
                  <button type="button" class="btn btn-default" style="max-width:85%;overflow: hidden;">Calendario <?= ($input->urlSegment1=='') ?  'General':' de '.$user_cal->namefull;?></button>
                  <button type="button" class="btn btn-default dropdown-toggle" style="max-width:15%;" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <?php
                  if($input->urlSegment1==''){  
                    $all_users = $users->find("roles=empleado, status=published");
                    foreach ($all_users as $value) { ?>
                      <li><a href="/calendario/<?=$value->name;?>"><?= 'Calendario '.$value->namefull;?></a></li>
                    <?php }
                     }else{ $all_users = $users->find("roles=empleado, name!=$input->urlSegment1, status=published");?>
                     <li><a href="/calendario">Calendario general</a></li>
                    <?php foreach ($all_users as $value) { ?>
                      <li><a href="/calendario/<?=$value->name;?>"><?='Calendario '.$value->namefull;?></a></li>
                    <?php }
                     } ?>
                  </ul>
                </div>
                <!-- /input-group -->
              </div>

            </div>

            <!-- /. box -->
        <?php if($input->urlSegment1!=''){ ?> 
            <div class="box box-solid" id="external-events">
              <div class="box-header with-border">
                <h4 class="box-title">Actividades por asignar</h4>
              </div>
              <div class="box-body">
                <!-- the events -->
               
                  <div id='external-events-listing'>
                  <?php  $eventos=$pages->find("template=work, sort=fechaf");
                          $lim=0;
                        foreach ($eventos as $key => $evento) { 
                          foreach ($evento->children("status=published, state!=3, assign=") as $k => $activity) { 
                            $product = $pages->get($activity->prid);
                                $title_cl=explode('/', $activity->title);
                                $titlecl=trim($title_cl[0]);
                                $ch=$product->children("title=$titlecl, include=all");
                            if($activity->type!='extra-activity'){
                                  if($ch[0]->duration!=$activity->duration)
                                    $durAct=$activity->duration;
                                  else {
                                    $durAct=mulhours($activity->duration, $activity->cant);
                                  }
                                }else
                                  $durAct=mulhours($activity->duration, $activity->cant);
                            $lim++; 
                            $fond=($activity->type=='extra-activity') ? 'black':$user_cal->fondo;
                            $durExt=($activity->type=='extra-activity') ? ' '.$activity->duration:''; ?>
                  <div class="external-event bg-<?=$fond;?>" data-duration="<?=$durAct?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>" data-type="activity"><b><?=$evento->title;?></b><?= '~'.$activity->title.'~'.$product->title.'~'.$activity->cant.$durExt; ?></div>
                  <?php if($lim>6) break;} if($lim>6) break;} ?>      
                  </div>    
              <button type="button" class="btn btn-block btn-primary load-more" data-page="1">Ver más tareas</button>
                  
              <!-- /.box-body -->
            </div>
          </div>

            <div class="box box-solid" id="external-events1">
              <div class="box-header with-border">
                <h4 class="box-title">Tareas EXTRA por asignar</h4>
              </div>
              <div class="box-body">
                <!-- /btn-group -->
                <h4 for="">Agrega una tarea extra aquí</h4>
                <label for="">Cuanto tiempo durará</label>
                <div class="input-group bootstrap-timepicker timepicker" style="margin-bottom: 15px;">
                  <input id="new-event-duration" type="text" class="form-control input-small timepicker" data-minute-step="5">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
                <label for="">En que consiste la tarea</label>
                <div class="input-group">
                  <input id="new-event" type="text" class="form-control" placeholder="Tarea" value="<?=$inputTarea?>">
                  <div class="input-group-btn">
                    <button id="add-new-event" type="button" class="btn btn-success btn-flat">Agregar</button>
                  </div>
                  <!-- /btn-group -->
                </div>
                <!-- the events -->
                <div id='external-events-listing-extra' style="margin-top: 16px;">
                  <?php  $eventos=$pages->find("template=extra-activities");
                        foreach ($eventos as $key => $evento) { 
                          foreach ($evento->children("state!=3, assign=") as $k => $activity) { 
                            $product = $pages->get($activity->prid); ?>
                  <div class="external-event bg-black" data-duration="<?= $activity->duration?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>" data-type="extra-activity"><b><?=$activity->title.' '.$activity->duration?></b></div>
                  <?php } } ?>   
              </div>
            </div>
            
          <?php } ?>
            <!-- /. box -->
          
          <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <?php } ?>
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
    <strong>Copyright &copy; <?=date('Y')?> <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $config->urls->templates ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $config->urls->templates ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $config->urls->templates ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $config->urls->templates ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $config->urls->templates ?>dist/js/adminlte.min.js"></script>
<!-- fullCalendar -->
<script src="<?php echo $config->urls->templates ?>bower_components/moment/moment.js"></script>
<script src="<?php echo $config->urls->templates ?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo $config->urls->templates ?>bower_components/fullcalendar/dist/locale-all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.js"></script>
<script src="<?php echo $config->urls->templates ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Page specific script -->
<script>

  $('.load-more').on('click', function (e) {  
    var num=parseInt($(this).data('page'))+1;
        $(this).data('page', num);
    $.ajax({
      url: "/load-more",
      type: "post",
      data:{page:$(this).data('page'),user:<?=$user_cal->id;?>},
      dataType: "html",
    }).done(function(msg){
      if(msg){
        $('#external-events-listing').html(msg);
      }
    }).fail(function (jqXHR, textStatus) {
      console.log(textStatus);
    });
    e.preventDefault(); 
  });

  $('.timepicker').timepicker({
      showSeconds: false,
      showMeridian: false,
      defaultTime: '00:05 AM'
    });
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {
        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          stick : true,
          title: $.trim($(this).text()),
          id:$(this).data('id'),
          duration:  $.trim($(this).data('duration'))// use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    init_events($('#external-events1 div.external-event'))

    //var scrollTime = moment().format("HH:mm:ss");
   
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      locale: 'es',
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'agendaWeek,agendaDay'
      },
      events    : [

       <?php  if($input->urlSegment1!=''){
                foreach ($user_cal->children('odt!=') as $key => $calEvento) {
                  $id=($calEvento->odt->type=='extra-activity') ? $calEvento->odt->id.'/'.$calEvento->id:$calEvento->id;
                 echo "{ id: '".$id."',
                  title: '".$calEvento->title."',
                  start: '".$calEvento->ini."',
                  end: '".$calEvento->fin."',
                  status: '".$calEvento->odt->state."',
                  type: '".$calEvento->odt->type."',
                  backgroundColor: '".$calEvento->bg."',
                  borderColor: '".$calEvento->bc."' },"; }
                }
                    
                 ?>

      ],
      businessHours: [ 
          {
              dow: [ 1, 2, 3, 4, 5 ], 
              start: '09:00', 
              end: '14:00' 
          },
          {
              dow: [ 1, 2, 3, 4, 5 ], 
              start: '15:00', 
              end: '18:15' 
          },
      ],
      //scrollTime: scrollTime,
      minTime: '09:00',
      maxTime:  '18:15',
      defaultView: 'agendaWeek',
      weekends: false,
      eventDurationEditable: false,
      editable  : true,
      droppable : true, 
      allDaySlot: false,
      slotDuration: '00:05',
      eventConstraint:"businessHours",
      eventDrop: function(event, delta, revertFunc) {
          $.ajax({
              url: "/add-calendar",
              type: "post",
              data: {edit:"true",id:event.id,title:event.title,bg:event.backgroundColor,bc:event.borderColor
,ini:event.start.format(),fin:event.end.format()},
              dataType: "html",
              }).done(function(msg){
            }).fail(function (jqXHR, textStatus) {
                      
            });

      },
      eventClick: function(calEvent, jsEvent, view) {
        if(calEvent.type=='extra-activity'){
           swal({
            title: '<small><a href="/actividades-extra" style="margin-left: 24px;"><span class="label label-primary">Editar evento</span></a>'+
            '<a class="del-event" data-id="'+calEvent.id+'" href="#" style="margin-left: 8px;"><span class="label label-danger">Eliminar evento</span></a><br>Titulo: '+calEvent.title+'<br>'+
            '</small>',
            html:
              '<b>Status</b>'+
              '<select class="form-control change-state">'+
                    '<option value="0" data-key="'+calEvent.title+'" '+
                     (calEvent.status  == 0 ? "selected":"")+
                    '>Pendiente</option>'+
                    '<option value="1" data-key="'+calEvent.title+'" '+
                     (calEvent.status  == 1 ? "selected":"")+
                     '>Pausada</option>'+
                    '<option value="2" data-key="'+calEvent.title+'"'+
                     (calEvent.status  == 2 ? "selected":"")+
                    '>En proceso</option>'+
                    '<option value="3" data-key="'+calEvent.title+'"'+
                     (calEvent.status  == 3 ? "selected":"")+
                     '>Terminada</option>'+
                  '</select><br>'+
              '<b>Hora de inicio: </b>' +calEvent.start.format("h:mm A")+'<br>'+
              '<b>Hora de finalización: </b>' +calEvent.end.format("h:mm A")+'<br>',
              onOpen: function() {
                   $(".change-state").change(function () {
                    var sta=$(this).val();
                    var colors=['#f39c12','#dd4b39','#3c8dbc','#00a65a'];
                      $.ajax({
                        url: "/change-status",
                        type: "post",
                        data: {status:$(this).val(),activity:calEvent.id,activi:$(this).find(':selected').data('key'),color:colors[sta],type:'fast-extra'},
                        dataType: "html",
                        }).done(function(msg){
                          console.log(msg);
                          calEvent.status = sta;
                          calEvent.backgroundColor = colors[sta];
                          calEvent.borderColor = colors[sta];
                          $('#calendar').fullCalendar('updateEvent', calEvent, true);
                          
                        }).fail(function (jqXHR, textStatus) {
                            console.log(textStatus);
                      });
                  })
                   $(".del-event").click(function(){
                    swal({
                    title: '¿Estás seguro?',
                    text: "La actividad sera eliminada del calendario",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                  }).then((result) => {
                    if (result.value) {
                        $.ajax({
                        url: "/del-cal",
                        type: "post",
                        data: {key:$(this).data('id')},
                        dataType: "html",
                        }).done(function(msg){
                          if(msg){
                              swal({
                                title: "Eliminado",
                                text: "La actividad se ha eliminado del calendario",
                                type: "success",
                              })
                              .then(willDelete => {
                                if (willDelete) {
                                  window.location='<?=$page->url.$input->urlSegment1?>';
                                }
                              });
                            }
                          
                        }).fail(function (jqXHR, textStatus) {
                            
                        });
                     }
                  })
               })
              },
            showCloseButton: false,
            showCancelButton: false,
            confirmButtonText: 'Cerrar',
            focusConfirm: false
          })
        }else{
          var title=calEvent.title;
          var tl = title.split("~");
          swal({
            title: '<small><a class="del-event" data-id="'+calEvent.id+'" href="#" style="margin-left: 8px;"><span class="label label-danger">Eliminar Actividad</span></a><br>Folio ODP: '+tl[0]+'<br>'+
            'Producto: '+tl[2]+'<br>'+
            'Actividad: '+tl[1]+'<br>'+
            'Cantidad: '+tl[3]+'<br>'+
            '</small>',
            html:
              '<b>Status</b>'+
              '<select class="form-control change-state">'+
                    '<option value="0" data-key="'+title+'" '+
                     (calEvent.status  == 0 ? "selected":"")+
                    '>Pendiente</option>'+
                    '<option value="1" data-key="'+title+'" '+
                     (calEvent.status  == 1 ? "selected":"")+
                     '>Pausada</option>'+
                    '<option value="2" data-key="'+title+'"'+
                     (calEvent.status  == 2 ? "selected":"")+
                    '>En proceso</option>'+
                    '<option value="3" data-key="'+title+'"'+
                     (calEvent.status  == 3 ? "selected":"")+
                     '>Terminada</option>'+
                  '</select><br>'+
              '<b>Hora de inicio: </b>' +calEvent.start.format("h:mm A")+'<br>'+
              '<b>Hora de finalización: </b>' +calEvent.end.format("h:mm A")+'<br>',
              onOpen: function() {
                   $(".change-state").change(function () {
                    var sta=$(this).val();
                    var colors=['#f39c12','#dd4b39','#3c8dbc','#00a65a'];
                      $.ajax({
                        url: "/change-status",
                        type: "post",
                        data: {status:$(this).val(),activity:calEvent.id,activi:$(this).find(':selected').data('key'),color:colors[sta],type:'fast'},
                        dataType: "html",
                        }).done(function(msg){
                          console.log(msg);
                          calEvent.status = sta;
                          calEvent.backgroundColor = colors[sta];
                          calEvent.borderColor = colors[sta];
                          $('#calendar').fullCalendar('updateEvent', calEvent, true);
                          
                        }).fail(function (jqXHR, textStatus) {
                            console.log(textStatus);
                      });
                  })
                   $(".del-event").click(function(){
                    swal({
                    title: '¿Estás seguro?',
                    text: "La actividad sera eliminada del calendario",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                  }).then((result) => {
                    if (result.value) {
                        $.ajax({
                        url: "/del-cal",
                        type: "post",
                        data: {key:$(this).data('id')},
                        dataType: "html",
                        }).done(function(msg){
                          if(msg){
                              swal({
                                title: "Eliminado",
                                text: "La actividad se ha eliminado del calendario",
                                type: "success",
                              })
                              .then(willDelete => {
                                if (willDelete) {
                                  window.location='<?=$page->url.$input->urlSegment1?>';
                                }
                              });
                            }
                          
                        }).fail(function (jqXHR, textStatus) {
                            
                        });
                     }
                  })
               })
              },
            showCloseButton: false,
            showCancelButton: false,
            confirmButtonText: 'Cerrar',
            focusConfirm: false
          })
        }
          

          return false;
        
          
      },
      drop: function (date, allDay) { // this function is called when something is dropped
        // retrieve the dropped element's stored Event Object
        
        var originalEventObject = $(this).data('eventObject')
        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)
        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = false
        copiedEventObject.durationEditable = false
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')
        copiedEventObject.type     = $(this).data('type')
        copiedEventObject.id     = $(this).data('id')
        //var dateStart=copiedEventObject.start .format()
       

        var id=$(this).data('eventObject')
        var bg=$(this).css('background-color')
        var bc=$(this).css('border-color')
        var pri = copiedEventObject.start.format('YYYY-MM-DD HH:mm:ss')
        var d = convertHours($(this).data('duration'))
        var fin=copiedEventObject.start.clone().add(d, 'hour').format('YYYY-MM-DD HH:mm:ss')
        copiedEventObject.end = fin


        

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar("getView").calendar.defaultTimedEventDuration = moment.duration($(this).data('duration'))
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
        

        // is the "remove after drop" checkbox checked?
        //if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        //}
       
          addCalendar(id.title,pri+'',fin+'',bg,bc,$(this).data('status'),$(this).data('duration'),$(this).data('id'),$(this).data('type'))
        

      }
      <?php if($input->urlSegment1!=''){ ?> ,
      eventDragStop: function( event, jsEvent, ui, view) {
                if(isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
                  //if (!confirm("¿Estas seguro que quieres regresar el evento?")) {
                      //return false;
                  //}else{
                      $('#calendar').fullCalendar('removeEvents', event.id);
                     
                      $.ajax({
                        url: "/asignar-emp",
                        type: "post",
                        data: {activity:event.id,user:<?=$user_cal->id;?>,edit:'delete',type:event.type},
                        dataType: "html",
                      }).done(function(msg){
                          $.ajax({
                            url: "/update-events",
                            type: "post",
                            data: {user:<?=$user_cal->id;?>,title:event.title,id:event.id,type:event.type},
                            dataType: "html",
                            }).done(function(msg){
                              if(msg){
                                $('#external-events-listing').html(msg);
                              }
                          }).fail(function (jqXHR, textStatus) {
                          });
                      }).fail(function (jqXHR, textStatus) {
                      });
                  //}
                   
                }
            }
        <?php } ?>
    })
    
    var isEventOverDiv = function(x, y) {

            var external_events = $('#external-events');
            var offset = external_events.offset();

            offset.right = external_events.width() + offset.left;
            offset.bottom = external_events.height() + offset.top;
           
            // Compare
            if (x >= offset.left && y >= offset.top && x <= offset.right && y <= offset.bottom) { 
              return true; 
            }else{
               return false;
            }
           

        }
  
    function convertHours(time)
    {
        var hms = time.split(":");
        return (parseInt(hms[0]) + (parseInt(hms[1])/60))
    }

    function addCalendar(id,pri,fin,bg,bc,status,dura,activity,type){
      $.ajax({
        url: "/add-calendar",
        type: "post",
        data: {id:activity,title:id,bg:bg,bc:bc,ini:pri,fin:fin,status:status,dura:dura,user:<?=$user_cal->id;?>,type:type},
        dataType: "html",
      }).done(function(msg){
          $.ajax({
            url: "/asignar-emp",
            type: "post",
            data: {activity:activity,user:<?=$user_cal->id;?>},
            dataType: "html",
          }).done(function(msg){
          }).fail(function (jqXHR, textStatus) {
          });
      }).fail(function (jqXHR, textStatus) {
      });
      
    }


    /* ADDING EVENTS */
    var currColor = '#111' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      var dur = $('#new-event-duration').val()
      if (val.length == 0) {
        return
      }


      $.ajax({
        url: "/add-extra-activity",
        type: "post",
        data: {title:val,duration:dur},
        dataType: "html",
      }).done(function(msg){
          //Create events
           var event = $('<div />')
          event.css({
            'background-color': currColor,
            'border-color'    : currColor,
            'color'           : '#fff'
          }).addClass('external-event')
          event.html(val+' '+dur)
          event.attr("data-duration", dur)
          event.attr("data-status", "0")
          event.attr("data-type", "extra-activity")
          event.attr("data-id", msg)
          $('#external-events-listing-extra').prepend(event)

          //Add draggable funtionality
          init_events(event)

          //Remove event from text input
          $('#new-event').val('')
        
      }).fail(function (jqXHR, textStatus) {
      });
     

    })
  })

  $('.zoom-out').click(function (e) {
    var min=$('#calendar').fullCalendar('option','slotDuration').split(':')
     if(parseInt(min[1])==60) return;
    if(parseInt(min[1])<60)
      var actual=parseInt(min[1])+5
    $('#calendar').fullCalendar('option','slotDuration','00:'+actual);
  })

  $('.zoom-in').click(function (e) {
    var min=$('#calendar').fullCalendar('option','slotDuration').split(':')
    if(parseInt(min[1])==5) return;
    if(parseInt(min[1])>5)
      var actual=parseInt(min[1])-5
    if(parseInt(min[1])>5)
      $('#calendar').fullCalendar('option','slotDuration','00:'+actual);
    else
      $('#calendar').fullCalendar('option','slotDuration','00:0'+actual);
  })

  $("#new-event").focusout(function() {
      $.ajax({
        url: "/input-persistent",
        type: "post",
        data: {input:$("#new-event").val()},
        dataType: "html",
      }).done(function(msg){
        console.log(msg);
      }).fail(function (jqXHR, textStatus) {
      });
     
  })

 
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>