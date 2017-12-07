<?php if(!$user->isLoggedin()) $session->redirect("/iniciar-sesion"); 

$user_cal = $users->get($input->urlSegment1);
if(!$user_cal->id && $input->urlSegment1!=''){ $session->redirect("/"); }  ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BKT | ODT Master</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates ?>dist/css/skins/skin-blue.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.3/sweetalert2.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

   <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calendario: <strong>General</strong>
        <small>Calendario de actividades desglozadas por día, semana y mes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Calendario</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ------------------------
        | Your Page Content Here |
        -------------------------->
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
                  <?php  $eventos=$pages->find("template=work, datos~=$user_cal->id");
                        foreach ($eventos as $key => $evento) { 
                          $arid=array();
                          $datos=explode("$", $evento->datos);
                          $datos=array_filter($datos, "strlen");
                          foreach ($datos as $value) {
                             $val=explode('/', $value);
                             $arid[]=$val[0];
                          }
                          $arid=implode(',', $arid);
                          $processes= $pages->getById($arid);
                          foreach ($processes as $key=>$process) {
                              $cant=explode("/", $datos[$key]);
                                $pro=explode(",", $cant[2]);
                              foreach (explode(",", $process->tiempos) as $key=>$value) {
                                $fabtim=explode('/', $value); 
                                 $status=explode('-', $pro[$key]); 
                                  $comEven=$evento->title.'-'.$fabtim[0].'-'.$cant[1].'-'.$process->title;
                                    $user_eventos=$users->find("id=$user_cal->id, calendario~=$comEven");
                                    if($user_eventos->count()>0) continue;
                                 if ($status[1]!=$user_cal->id) continue; ?>
                  <div class="external-event bg-<?=$user_cal->fondo;?>" data-duration="<?= mulhours($fabtim[1],$cant[1]); ?>"><b><?=$evento->title;?></b><?= '-'.$fabtim[0].'-'.$cant[1].'-'.$process->title; ?></div>
                  <?php } } } ?>      
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

<!-- REQUIRED JS SCRIPTS -->

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


    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : [

       <?php  if($input->urlSegment1!=''){
                  $calendar=explode('$', $user_cal->calendario);
                foreach ($calendar as $key => $calEvento) {
                  if($calEvento=='') continue;
                  $calEve=explode('%', $calEvento);
                 echo "{ id: '".$calEve[0]."',
                  title: '".$calEve[1]."',
                  start: '".$calEve[2]."',
                  end: '".$calEve[3]."',
                  backgroundColor: '".$calEve[4]."',
                  borderColor: '".$calEve[5]."' },"; }
                }else{
                  $usersCalendar=$users->find("calendario!=''");
                  foreach ($usersCalendar as $key => $userCalendar) {
                    $calendar=explode('$', $userCalendar->calendario);
                    foreach ($calendar as $key => $calEvento) {
                      if($calEvento=='') continue;
                      $calEve=explode('%', $calEvento);
                     echo "{ id: '".$calEve[0]."',
                      title: '".$calEve[1]."',
                      start: '".$calEve[2]."',
                      end: '".$calEve[3]."',
                      backgroundColor: '".$calEve[4]."',
                      borderColor: '".$calEve[5]."' },"; }
                    }
                  }
                    
                 ?>

      ],
      forceEventDuration: true,
      scrollTime: '08:00:00',
      editable  : true,
      eventDurationEditable: false,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      eventDrop: function(event, delta, revertFunc) {

        if (!confirm("¿Estas seguro de cambiar la hora del evento?")) {
            revertFunc();
        }else{
          $.ajax({
              url: "/add-calendar",
              type: "post",
              data: {edit:"true",id:event.id,title:event.title,bg:event.backgroundColor,bc:event.borderColor
,ini:event.start.format(),fin:event.end.format()},
              dataType: "html",
              }).done(function(msg){
                console.log(msg);
                if(msg){
                    swal({
                  title: "Correcto",
                  text: "Se actualizo el evento",
                  type: "success",
                })
                .then(willDelete => {
                  if (willDelete) {
                    //window.location='';
                  }
                });
                }
            }).fail(function (jqXHR, textStatus) {
                      
            });
        }

      },
      eventResize: function(event, delta, revertFunc) {

        alert(event.title + " end is now " + event.end.format());

        if (!confirm("is this okay?")) {
            revertFunc();
        }

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


        

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar("getView").calendar.defaultTimedEventDuration = moment.duration($(this).data('duration'))
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
        

        // is the "remove after drop" checkbox checked?
        //if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        //}
      
          addCalendar(id.title,pri+'',fin+'',bg,bc)

      }
      <?php if($input->urlSegment1!=''){ ?> ,
      eventDragStop: function( event, jsEvent, ui, view) {
                if(isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
                  if (!confirm("¿Estas seguro que quieres regresar el evento?")) {
                      return false;
                  }else{
                      $('#calendar').fullCalendar('removeEvents', event.id);
                     $.ajax({
                        url: "/update-events",
                        type: "post",
                        data: {user:<?=$user_cal->id;?>,title:event.title},
                        dataType: "html",
                        }).done(function(msg){
                          console.log(msg);
                          //console.log(msg);
                          if(msg){
                            $('#external-events-listing').html(msg);
                          }
                      }).fail(function (jqXHR, textStatus) {
                                
                      });
                  }
                   
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

    function addCalendar(id,pri,fin,bg,bc){
      $.ajax({
              url: "/add-calendar",
              type: "post",
              data: {id:id,title:id,bg:bg,bc:bc,ini:pri,fin:fin,user:<?=$user_cal->id;?>},
              dataType: "html",
              }).done(function(msg){
                //console.log(msg);
                if(msg){
                    swal({
                  title: "Correcto",
                  text: "Se agrego el evento",
                  type: "success",
                })
                .then(willDelete => {
                  if (willDelete) {
                    //window.location='';
                  }
                });
                }
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
