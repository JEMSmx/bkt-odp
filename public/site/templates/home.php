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
            <a href="/ordenes-de-produccion" class="small-box-footer">Más info<i class="fa fa-arrow-circle-right"></i></a>
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
           <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
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
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      El fracaso es una gran oportunidad para empezar otra vez con más inteligencia
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?=date('Y')?> <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
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
    $('#calendar').fullCalendar({
      locale: 'es',
      header    : {
        left  : 'prev,next',
        center: 'title',
        right : ''
      },
      events    : [

          <?php   
                   $inis='2017-01-01';
                    $mod_date=date($inis);
                    $iniSem=$inis[2]; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
                     for ($i=0; $i < 730 ; $i++) { 
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
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
