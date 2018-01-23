<?php 
  $user_cal = $users->get($input->post->user);
  $cuantos=$input->post->page*6;

                 $eventos=$pages->find("template=work, sort=fechaf");
                          $lim=0;
                        foreach ($eventos as $key => $evento) { 
                          foreach ($evento->children("state!=3, assign=") as $k => $activity) { 
                            $product = $pages->get($activity->prid);
                            $lim++; ?>
                  <div class="external-event bg-<?=$user_cal->fondo;?>" data-duration="<?php if($activity->cant<=1) echo $activity->duration; else echo mulhours($activity->duration, $activity->cant);?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>"><b><?=$evento->title;?></b><?= '~'.$activity->title.'~'.$product->title.'~'.$activity->cant; ?></div>
                  <?php if($lim>$cuantos) break;} if($lim>$cuantos) break;} ?>         
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
                  $id=($calEvento->odt->type=='activity-extra') ? $calEvento->odt->id.'/'.$calEvento->id:$calEvento->id;
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
              dow: [ 1, 2, 3, 4, 5, 6 ], 
              start: '08:00', 
              end: '20:00' 
          }
      ],
      
      minTime: '08:00',
      maxTime:  '20:00',
      defaultView: 'agendaWeek',
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
                //console.log(msg);
            }).fail(function (jqXHR, textStatus) {
                      
            });

      },
      eventClick: function(calEvent, jsEvent, view) {
        if(calEvent.type=='activity-extra'){
           swal({
            title: '<small>Titulo: '+calEvent.title+'<br>'+
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
            title: '<small>Folio ODP: '+tl[0]+'<br>'+
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


  
  })

</script>