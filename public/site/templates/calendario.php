<?php include('./_head.php'); 
 $user_cal = $users->get($input->urlSegment1);
if(!$user_cal->id && $input->urlSegment1!=''){ $session->redirect("/"); }  ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calendario: <strong><?= ($input->urlSegment1=='') ?  'General':' de '.$user_cal->namefull;?></strong>
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
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- Lunes -->
              <?php $find=date('w')-1;
                    $iniSem=date('d')-$find; $dias=array('Lunes','Martes','Miercoles','Jueves','Viernes');
                     for ($i=0; $i < count($dias) ; $i++) { 
                      $totDis=0; $totCom=0; $totAsi=0;
                      $empleados=$users->find("roles=empleado"); 
                      foreach($empleados as $empleado){  
                        $totDis+=8;
                        $hora='00:00';$ade='00:00';$asi='00:00';
                        foreach ($empleado->children() as $key => $event) {
                          $fechEvento=explode(" ", $event->ini);
                          if($iniSem<10)
                            $inS='0'.$iniSem;
                          else
                            $inS=$iniSem;

                          $hoy=date('Y-m-'.$inS);
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
              <div class="col-md-<?= ($i==$find) ? 4:2 ?>">
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
                      <?=$por?>% de progreso
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Trabajadores</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                      <!-- Trabajador -->
                    <?php $empleados=$users->find("roles=empleado"); 
                          foreach($empleados as $empleado){  
                            $hora='00:00';$ade='00:00'; $pas='00:00'; 
                              foreach ($empleado->children() as $key => $event) {
                                      $fechEvento=explode(" ", $event->ini);
                                      if($iniSem<10)
                                        $inS='0'.$iniSem;
                                      else
                                        $inS=$iniSem;

                                      $hoy=date('Y-m-'.$inS);
                                      if($hoy==$fechEvento[0]){
                                        if($event->odt->cant<=1)
                                          $hora=sumarHoras($hora,$event->odt->duration);
                                        else
                                          $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                                        $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                                        $fecha_entrada = strtotime($event->fin);
                                        if($fecha_actual > $fecha_entrada){
                                          if(intval($event->odt->state)<3){
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
                                          }
                                        }
                                      }
                               } 
                               $ade=convertDec($ade); $pas=convertDec($pas);
                               $hr=$ade-$pas;
                               $eti=($hr>0) ? 'success':'danger';?>
                      <li style="width: 100%;text-align: left;padding-bottom: 0;">
                       <?php if($i==$find){ 
                             $image=$empleado->images->first();
                              if($image){
                                $imgpro = $image->size(160, 160, array('quality' => 80, 'upscaling' => false, 'cropping' => true));
                              } ?>
                        <img class="direct-chat-img" src="<?php if($image) echo $imgpro->url; else echo 'https://www.popvox.com/images/user-avatar-grey.png'?>" alt="<?=$empleado->namefull?>" style="margin-right: 8px;">
                        <?php } ?>
                        <a class="users-list-name" href="/calendario/<?=$empleado->name?>"><?=$empleado->namefull?></a>
                        <span class="users-list-date"><b><?=round(convertDec($hora),2)?>/8</b> Horas asignadas</span>
                        <span class="label label-<?= ($hr==0) ? 'primary':$eti;?>"><b><?=round($ade,2)?>/<?=round(convertDec($hora),2)?></b> Horas terminadas</span>
                        <a href="/calendario/<?=$empleado->name?>" class="btn btn-sm btn-primary pull-center" style="margin-top: 8px;">Ver calendario</a>
                        <hr style="margin: 8px 0 0 0;">
                      </li>
                      <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.box-footer -->
                </div>
              </div>
              <?php $iniSem++; } ?>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <?php }else{ ?> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-9">
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
          <div class="col-md-3">
            <!-- Calendarios Container-->
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Calendarios</h3>
              </div>
              <div class="box-body">
                <div class="btn-group" style="width: 100%;">
                  <button type="button" class="btn btn-default" style="min-width:90%;">Calendario <?= ($input->urlSegment1=='') ?  'General':' de '.$user_cal->namefull;?></button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <?php
                  if($input->urlSegment1==''){  
                    $all_users = $users->find("roles=empleado");
                    foreach ($all_users as $value) { ?>
                      <li><a href="/calendario/<?=$value->name;?>"><?= 'Calendario de '.$value->namefull;?></a></li>
                    <?php }
                     }else{ $all_users = $users->find("roles=empleado, name!=$input->urlSegment1");?>
                     <li><a href="/calendario">Calendario general</a></li>
                    <?php foreach ($all_users as $value) { ?>
                      <li><a href="/calendario/<?=$value->name;?>"><?='Calendario de '.$value->namefull;?></a></li>
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
                        foreach ($eventos as $key => $evento) { 
                          foreach ($evento->children("state!=3, assign=") as $k => $activity) { 
                            $product = $pages->get($activity->prid); ?>
                  <div class="external-event bg-<?=$user_cal->fondo;?>" data-duration="<?php if($activity->cant<=1) echo $activity->duration; else echo mulhours($activity->duration, $activity->cant);?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>"><b><?=$evento->title;?></b><?= '~'.$activity->title.'~'.$product->title.'~'.$activity->cant; ?></div>
                  <?php } } ?>      
                  </div>    
                  <div class="checkbox">
                    
                </div>
              
              <!-- /.box-body -->
            </div>
          <?php } ?>
            <!-- /. box -->
          </div>
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
<!-- Page specific script -->
<script>
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
                foreach ($user_cal->children() as $key => $calEvento) {
                 echo "{ id: '".$calEvento->id."',
                  title: '".$calEvento->title."',
                  start: '".$calEvento->ini."',
                  end: '".$calEvento->fin."',
                  backgroundColor: '".$calEvento->bg."',
                  borderColor: '".$calEvento->bc."' },"; }
                }
                    
                 ?>

      ],
      businessHours: [ 
          {
              dow: [ 1, 2, 3, 4, 5, 6 ], 
              start: '08:00', 
              end: '20:00' 
          }
      ],
      
      minTime: '08:00',
      maxTime:  '22:00',
      defaultView: 'agendaWeek',
      eventDurationEditable: false,
      editable  : true,
      droppable : true, 
      allDaySlot: false,
      eventConstraint:"businessHours",
      eventDrop: function(event, delta, revertFunc) {
          $.ajax({
              url: "/add-calendar",
              type: "post",
              data: {edit:"true",id:event.id,title:event.title,bg:event.backgroundColor,bc:event.borderColor
,ini:event.start.format(),fin:event.end.format()},
              dataType: "html",
              }).done(function(msg){
                console.log(msg);
            }).fail(function (jqXHR, textStatus) {
                      
            });

      },
      eventClick: function(calEvent, jsEvent, view) {
          var title=calEvent.title;
          var tl = title.split("~");
          swal({
            title: '<small>Folio ODP: '+tl[0]+'<br>'+
            'Producto: '+tl[2]+'<br>'+
            'Actividad: '+tl[1]+'<br>'+
            'Cantidad: '+tl[3]+'<br>'+
            '</small><br>',
            html:
              '<b>Hora de inicio: </b>' +calEvent.start.format("h:mm A")+'<br>'+
              '<b>Hora de finalización: </b>' +calEvent.end.format("h:mm A")+'<br>',
            showCloseButton: false,
            showCancelButton: false,
            confirmButtonText: 'Cerrar',
            focusConfirm: false
          })

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
      
          addCalendar(id.title,pri+'',fin+'',bg,bc,$(this).data('status'),$(this).data('duration'),$(this).data('id'))

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
                        data: {activity:event.id,user:<?=$user_cal->id;?>,edit:'delete'},
                        dataType: "html",
                      }).done(function(msg){
                          $.ajax({
                            url: "/update-events",
                            type: "post",
                            data: {user:<?=$user_cal->id;?>,title:event.title,id:event.id},
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

    function addCalendar(id,pri,fin,bg,bc,status,dura,activity){
      $.ajax({
        url: "/add-calendar",
        type: "post",
        data: {id:activity,title:id,bg:bg,bc:bc,ini:pri,fin:fin,status:status,dura:dura,user:<?=$user_cal->id;?>},
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
    var currColor = '#3c8dbc' //Red by default
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
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
