<?php 
  $user_cal = $users->get($input->post->user);

                 $eventos=$pages->find("template=work");
                        foreach ($eventos as $key => $evento) { 
                          foreach ($evento->children("state!=3, assign=") as $k => $activity) { 
                            $product = $pages->get($activity->prid); ?>
                  <div class="external-event bg-<?=$user_cal->fondo;?>" data-duration="<?=$activity->duration?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>"><b><?=$evento->title;?></b><?= '-'.$activity->title.'-'.$product->title.'-'.$activity->cant; ?></div>
                  <?php } } ?>      
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
                        url: "/update-events",
                        type: "post",
                        data: {user:<?=$user_cal->id;?>,title:event.title,id:event.id},
                        dataType: "html",
                        }).done(function(msg){
                          if(msg){
                            $('#external-events-listing').html(msg);
                            $.ajax({
                              url: "/asignar-emp",
                              type: "post",
                              data: {activity:event.id,user:'delete'},
                              dataType: "html",
                            }).done(function(msg){
                              console.log(msg);
                            }).fail(function (jqXHR, textStatus) {
                            });
                          }
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