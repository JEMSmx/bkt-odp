<?php 
  $user_cal = $users->get($input->post->user);
  $cuantos=$input->post->page*6;

                 $eventos=$pages->find("template=work, sort=fechaf");
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
                  <div class="external-event bg-<?=$fond;?>" data-duration="<?=$durAct?>" data-status="<?=$activity->state?>" data-id="<?=$activity->id?>" data-type="activity"><b><?=$evento->title.' / '.$evento->numodt.' / '.$evento->cliente.' '?></b><?= $activity->title.'~'.$product->title.'~'.$activity->cant.$durExt; ?></div>
                  <?php if($lim>$cuantos) break;} if($lim>$cuantos) break;} ?>         
<!-- Page specific script -->
<script type="text/javascript">
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
</script>