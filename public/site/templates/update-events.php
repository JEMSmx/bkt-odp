<?php 

	$user_cal = $users->get($input->post->user);

	$p=$user_cal;
		$cal=array();
		foreach (explode("$", $p->calendario) as $key => $value) {
			if($value=='') continue;
		  $work=explode('%', $value);
			if ($work[1]!=$input->post->title) {
			   $cal[]=$value;
			}
		}
		
		$p->of(false);
	  	$p->calendario=implode("$", $cal).'$';
	  	$p->save();


 $eventos=$pages->find("template=work, datos~=$user_cal->id");
                        foreach ($eventos as $key => $evento) { 
                            $arid=array();
                          $datos=explode("$", $evento->datos);
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
                  <div class="external-event bg-<?=$user_cal->fondo;?>" data-duration="<?= date("h:i", strtotime($fabtim[1]) * $cant[1]); ?>"><b><?=$evento->title;?></b><?= '-'.$fabtim[0].'-'.$cant[1].'-'.$process->title; ?></div>
                  <?php } } } ?>  
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

      },
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