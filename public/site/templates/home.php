<?php include('./_head.php');
      $dateH=isset($input->get->date) ? date($input->get->date):date('Y-m-d');
      $meses=array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $semana=inicio_fin_semana($dateH);
      $inis=explode('-', $semana['fechaInicio']);
      $inif=explode('-', $semana['fechaFin']);  ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('./_lat.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
    <h2></h2>
  </div>
    <section class="content-header">
      <h1>
        <strong>Vista General</strong>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
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
           <?php      
        $iniSem=$inis[2]; 
        $mod_date=$semana['fechaInicio'];
        $numberTe=0;
        for ($i=0; $i < 5 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            foreach ($empleado->children('odt!=') as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
                  if(intval($event->odt->state)<3){
                    if($event->odt->assign!="")
                      $numberTe++;
                  }
                }
              } 
            } 
            $mod_datew = strtotime($mod_date."+ 1 days");
            $iniSem=date("d", $mod_datew);
            $mod_date=date("Y-m-d",$mod_datew);
          } ?>
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$numberTe?><sup style="font-size: 20px"></sup></h3>
              <p>Tareas Asignadas</p>
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
        <?php      
        $iniSem=$inis[2]; 
        $mod_date=$semana['fechaInicio'];
        $numberT=0;
        for ($i=0; $i < 5 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            foreach ($empleado->children('odt!=') as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
                  if(intval($event->odt->state)==3){
                    $numberT++;
                  }
                }
              } 
            } 
            $mod_datew = strtotime($mod_date."+ 1 days");
            $iniSem=date("d", $mod_datew);
            $mod_date=date("Y-m-d",$mod_datew);
          } ?>

        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$numberT?></h3>
              <p>Tareas terminadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            
          </div>
        </div>
        <div id="zoom-in">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
        <div id="zoom-out" style="display: none">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body no-padding">
               <div class="col-md-6" style="padding-top: 8px;">
                  <div class="btn-group" style="top: 8px;padding-left:1px;"><button type="button" class="fc-prev-button btn btn-default" style="padding: 3.7px 8.4px;font-size: 14px;"><span class="glyphicon glyphicon-chevron-left" ></span></button><button type="button" class="fc-next-button btn btn-default" style="padding: 3.7px 8.4px;font-size: 14px;"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                </div>
                <div class="col-md-6" style="display: flex;justify-content: flex-end;padding-top: 16px;">
               <!-- Acercar -->
               <a id="zoomOut" class="btn btn-app zoom-in" style="padding: 4px;min-width: 34px;height: 28px;">
                 <i class="fa fa-search-plus" style="font-size: 16px;"></i>
               </a>
             </div>
                <!-- THE CALENDAR -->
                <div class="col-md-6" id="calendar0"></div>
                <div class="col-md-6" id="calendar1"></div>
                <div class="col-md-6" id="calendar2"></div>
                <div class="col-md-6" id="calendar3"></div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /. box -->
          </div>
        </div>
        
        <!-- /.col -->
        <!-- Barra derecha de actividades -->
         </div> 
      <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include('./_main-footer.php'); ?>

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
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
<!-- page script -->
<script type="text/javascript">
  

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

    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
        var today = moment().day();
    $('#calendar').fullCalendar({
      firstDay: today,
      themeSystem: 'bootstrap3',
      customButtons: {
        zoomOut: {
            bootstrapGlyphicon: 'glyphicon-zoom-out',
            click: function() {
                $("#zoom-out").show();
                $("#zoom-in").toggle();
                $("#calendar0").fullCalendar('render');
                $("#calendar1").fullCalendar('render');
                $("#calendar2").fullCalendar('render');
                $("#calendar3").fullCalendar('render');
            }
        },
        zoomIn: {
            bootstrapGlyphicon: 'glyphicon-zoom-in',
            click: function() {
                $("#zoom-in").show();
                $("#calendar").fullCalendar('render');
            }
        }
    },
    
      locale: 'es',
      header    : {
        left  : 'prev,next',
        center: 'title',
        right : 'zoomOut'
      },
      events    : [
    <?php   
        $inis='2017-01-01';
        $mod_date=date($inis);
        $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
        for ($i=0; $i < 1200 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0; $por=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            $hora='00:00';$ade='00:00';$asi='00:00';
            foreach ($empleado->children("odt!=") as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
               if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                $hora=sumarHoras($hora,$event->odt->duration);
                else
                  $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                $fecha_entrada = strtotime($event->fin);
                if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                  $asi=sumarHoras($asi,$event->odt->duration);
                  else
                    $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                  if(intval($event->odt->state)==3){
                   if($event->odt->cant<=1 || $event->odt->duration=='2:00')
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

            }
            $por=($totAsi==0) ? 0:($totAsi*100)/$totDis;

            if($por>20 && $por<80)
              $co='orange';
            else if($por>80)
              $co='green';
            else if($por==0)
              $co='black';
            else
              $co='red';
            $weekDay = date('w', strtotime($mod_date));
            if($weekDay==0 || $weekDay==6){
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }else{
              if($por==0)
                $title='Sin asignar';
              else
                $title=round($totAsi,2)."/".round($totDis,2)." Horas asignadas";
              echo "{ id: '".$mod_date."',
              title: '".$title."',
              porcentaje: '".round($por,2)."',
              start: '".$mod_date."',
              url:'/calendario/?date=".$mod_date."',
              backgroundColor: '".$co."',
              borderColor: '".$co."' },";
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }

          }?> 
      ],
      defaultView: 'month',
      eventDurationEditable: false,
      weekends: false,
      editable  : false,
      droppable : false, 
      allDaySlot: false,
      eventAfterRender: function(event, element, view) {
        var alt=15
        if(event.porcentaje>15){
          if(event.porcentaje>100)
            alt=100;
          else
            alt=event.porcentaje;
        }
        $(element).css('height', alt+'px');
      }
    })
  })

$(document).ready(function() {

    var date = new Date();

    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var today = moment().day();
    $('#calendar0').fullCalendar({
      themeSystem: 'bootstrap3',
      fixedWeekCount: false,
      height: 600,
      fixedWeekCount: false,
      locale: 'es',
      header    : {
        left  : '',
        center: 'title',
        right : ''
      },
      events    : [
    <?php   
        $inis='2017-01-01';
        $mod_date=date($inis);
        $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
        for ($i=0; $i < 1200 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0; $por=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            $hora='00:00';$ade='00:00';$asi='00:00';
            foreach ($empleado->children("odt!=") as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
               if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                $hora=sumarHoras($hora,$event->odt->duration);
                else
                  $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                $fecha_entrada = strtotime($event->fin);
                if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                  $asi=sumarHoras($asi,$event->odt->duration);
                  else
                    $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                  if(intval($event->odt->state)==3){
                   if($event->odt->cant<=1 || $event->odt->duration=='2:00')
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

            }
            $por=($totAsi==0) ? 0:($totAsi*100)/$totDis;

            if($por>20 && $por<80)
              $co='orange';
            else if($por>80)
              $co='green';
            else if($por==0)
              $co='black';
            else
              $co='red';
            $weekDay = date('w', strtotime($mod_date));
            if($weekDay==0 || $weekDay==6){
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }else{
              if($por==0)
                $title='Sin asignar';
              else
                $title=round($totAsi,2)."/".round($totDis,2)." Horas asignadas";
              echo "{ id: '".$mod_date."',
              title: '".$title."',
              porcentaje: '".round($por,2)."',
              start: '".$mod_date."',
              url:'/calendario/?date=".$mod_date."',
              backgroundColor: '".$co."',
              borderColor: '".$co."' },";
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }

          }?> 
      ],
      defaultView: 'month',
      eventDurationEditable: false,
      weekends: false,
      editable  : false,
      droppable : false, 
      allDaySlot: false,
      eventAfterRender: function(event, element, view) {
        var alt=15
        if(event.porcentaje>15){
          if(event.porcentaje>100)
            alt=100;
          else
            alt=event.porcentaje;
        }
        $(element).css('height', alt+'px');
      }
    });

    $('#calendar1').fullCalendar({
      themeSystem: 'bootstrap3',
      height: 600,
      defaultDate: moment(y+"-"+(m+2)+"-"+d),
      fixedWeekCount: false,
      locale: 'es',
      header    : {
        left  : '',
        center: 'title',
        right : ''
      },
      events    : [
    <?php   
        $inis='2017-01-01';
        $mod_date=date($inis);
        $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
        for ($i=0; $i < 1200 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0; $por=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            $hora='00:00';$ade='00:00';$asi='00:00';
            foreach ($empleado->children("odt!=") as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
               if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                $hora=sumarHoras($hora,$event->odt->duration);
                else
                  $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                $fecha_entrada = strtotime($event->fin);
                if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                  $asi=sumarHoras($asi,$event->odt->duration);
                  else
                    $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                  if(intval($event->odt->state)==3){
                   if($event->odt->cant<=1 || $event->odt->duration=='2:00')
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

            }
            $por=($totAsi==0) ? 0:($totAsi*100)/$totDis;

            if($por>20 && $por<80)
              $co='orange';
            else if($por>80)
              $co='green';
            else if($por==0)
              $co='black';
            else
              $co='red';
            $weekDay = date('w', strtotime($mod_date));
            if($weekDay==0 || $weekDay==6){
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }else{
              if($por==0)
                $title='Sin asignar';
              else
                $title=round($totAsi,2)."/".round($totDis,2)." Horas asignadas";
              echo "{ id: '".$mod_date."',
              title: '".$title."',
              porcentaje: '".round($por,2)."',
              start: '".$mod_date."',
              url:'/calendario/?date=".$mod_date."',
              backgroundColor: '".$co."',
              borderColor: '".$co."' },";
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }

          }?> 
      ],
      defaultView: 'month',
      eventDurationEditable: false,
      weekends: false,
      editable  : false,
      droppable : false, 
      allDaySlot: false,
      eventAfterRender: function(event, element, view) {
        var alt=15
        if(event.porcentaje>15){
          if(event.porcentaje>100)
            alt=100;
          else
            alt=event.porcentaje;
        }
        $(element).css('height', alt+'px');
      }
    });

  
    $('#calendar2').fullCalendar({
      themeSystem: 'bootstrap3',
      height: 600,
      defaultDate: moment(y+"-"+(m+3)+"-"+d),
      fixedWeekCount: false,
      locale: 'es',
      header    : {
        left  : '',
        center: 'title',
        right : ''
      },
      events    : [
    <?php   
        $inis='2017-01-01';
        $mod_date=date($inis);
        $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
        for ($i=0; $i < 1200 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0; $por=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            $hora='00:00';$ade='00:00';$asi='00:00';
            foreach ($empleado->children("odt!=") as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
               if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                $hora=sumarHoras($hora,$event->odt->duration);
                else
                  $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                $fecha_entrada = strtotime($event->fin);
                if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                  $asi=sumarHoras($asi,$event->odt->duration);
                  else
                    $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                  if(intval($event->odt->state)==3){
                   if($event->odt->cant<=1 || $event->odt->duration=='2:00')
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

            }
            $por=($totAsi==0) ? 0:($totAsi*100)/$totDis;

            if($por>20 && $por<80)
              $co='orange';
            else if($por>80)
              $co='green';
            else if($por==0)
              $co='black';
            else
              $co='red';
            $weekDay = date('w', strtotime($mod_date));
            if($weekDay==0 || $weekDay==6){
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }else{
              if($por==0)
                $title='Sin asignar';
              else
                $title=round($totAsi,2)."/".round($totDis,2)." Horas asignadas";
              echo "{ id: '".$mod_date."',
              title: '".$title."',
              porcentaje: '".round($por,2)."',
              start: '".$mod_date."',
              url:'/calendario/?date=".$mod_date."',
              backgroundColor: '".$co."',
              borderColor: '".$co."' },";
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }

          }?> 
      ],
      defaultView: 'month',
      eventDurationEditable: false,
      weekends: false,
      editable  : false,
      droppable : false, 
      allDaySlot: false,
      eventAfterRender: function(event, element, view) {
        var alt=15
        if(event.porcentaje>15){
          if(event.porcentaje>100)
            alt=100;
          else
            alt=event.porcentaje;
        }
        $(element).css('height', alt+'px');
      }
    });

    $('#calendar3').fullCalendar({
      themeSystem: 'bootstrap3',
      height: 600,
      defaultDate: moment(y+"-"+(m+4)+"-"+d),
      fixedWeekCount: false,
      locale: 'es',
      header    : {
        left  : '',
        center: 'title',
        right : ''
      },
      events    : [
    <?php   
        $inis='2017-01-01';
        $mod_date=date($inis);
        $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
        for ($i=0; $i < 1200 ; $i++) { 
          $totDis=0; $totCom=0; $totAsi=0; $por=0;
          $empleados=$users->find("roles=empleado, status=published"); 
          foreach($empleados as $empleado){  
            $totDis+=8;
            $hora='00:00';$ade='00:00';$asi='00:00';
            foreach ($empleado->children("odt!=") as $key => $event) {
              $fechEvento=explode(" ", $event->ini);
              if($iniSem<10)
                $inS='0'.$iniSem;
              else
                $inS=$iniSem;

              $hoy=$mod_date;
              if($hoy==$fechEvento[0]){
               if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                $hora=sumarHoras($hora,$event->odt->duration);
                else
                  $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                $fecha_entrada = strtotime($event->fin);
                if($event->odt->cant<=1 || $event->odt->duration=='2:00')
                  $asi=sumarHoras($asi,$event->odt->duration);
                  else
                    $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                  if(intval($event->odt->state)==3){
                   if($event->odt->cant<=1 || $event->odt->duration=='2:00')
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

            }
            $por=($totAsi==0) ? 0:($totAsi*100)/$totDis;

            if($por>20 && $por<80)
              $co='orange';
            else if($por>80)
              $co='green';
            else if($por==0)
              $co='black';
            else
              $co='red';
            $weekDay = date('w', strtotime($mod_date));
            if($weekDay==0 || $weekDay==6){
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }else{
              if($por==0)
                $title='Sin asignar';
              else
                $title=round($totAsi,2)."/".round($totDis,2)." Horas asignadas";
              echo "{ id: '".$mod_date."',
              title: '".$title."',
              porcentaje: '".round($por,2)."',
              start: '".$mod_date."',
              url:'/calendario/?date=".$mod_date."',
              backgroundColor: '".$co."',
              borderColor: '".$co."' },";
              $mod_datew = strtotime($mod_date."+ 1 days");
              $iniSem=date("d", $mod_datew);
              $mod_date=date("Y-m-d",$mod_datew);
            }

          }?> 
      ],
      defaultView: 'month',
      eventDurationEditable: false,
      weekends: false,
      editable  : false,
      droppable : false, 
      allDaySlot: false,
      eventAfterRender: function(event, element, view) {
        var alt=15
        if(event.porcentaje>15){
          if(event.porcentaje>100)
            alt=100;
          else
            alt=event.porcentaje;
        }
        $(element).css('height', alt+'px');
      }
    });

    $('#myprevbutton').click(function() {
        $('#calendar0').fullCalendar( 'gotoDate', subThreeMonth('#calendar0') );
       $('#calendar1').fullCalendar( 'gotoDate', subThreeMonth('#calendar1') );
       $('#calendar2').fullCalendar( 'gotoDate', subThreeMonth('#calendar2') );
        $('#calendar3').fullCalendar( 'gotoDate', subThreeMonth('#calendar3') );
    });
    $('#mynextbutton').click(function() {
        $('#calendar0').fullCalendar( 'gotoDate', addThreeMonth('#calendar0') );
       $('#calendar1').fullCalendar( 'gotoDate', addThreeMonth('#calendar1') );
       $('#calendar2').fullCalendar( 'gotoDate', addThreeMonth('#calendar2') );
        $('#calendar3').fullCalendar( 'gotoDate', addThreeMonth('#calendar3') );
    });
    $('#zoomOut').click(function(){
         $('#zoom-out').toggle();
         $("#zoom-in").show();
         $("#calendar").fullCalendar('render');
    });
    
    function addThreeMonth(id){
      var date = $(id).fullCalendar('getDate');
      var new_date = moment(date).add(4, 'M');
      return new_date;
    }
    
    function subThreeMonth(id){
      var date = $(id).fullCalendar('getDate');
      var new_date = moment(date).subtract(4, 'M');
      return new_date;
    }
});
</script>
</body>
</html>