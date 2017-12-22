<?php 

$product = wire('pages')->get($input->post->key);
$odp = wire('pages')->get($input->post->odp);
$etapa=$input->post->etapa;
$activities=$odp->children("prid=$product->id, status=$etapa");
if ($activities->count()>0) {
   foreach ($activities as $activity) {
      $pages->delete($activity);
   }
}
  $cant=$input->post->canti;
  $inc=0;
  foreach ($product->children() as $key => $value) {
    $inc++;
    if($value->duration=='00:00') continue;
    if($input->post->etapa=='2' && ($inc==1 || $inc==2)) continue;
    if($input->post->etapa=='3' && ($inc==1 || $inc==2 || $inc==3)) continue; 
    $time=convertDec($value->duration);
    if($time>2){
      $nwTime=$time/2;
      for($y=0;$y<$cant;$y++){
        for($x=0;$x<ceil($nwTime);$x++){
          $ch = new Page();
          $ch->setOutputFormatting(false);
          $ch->template = 'activities'; 
          $ch->parent = wire('pages')->get($input->post->odp);
          $ch->prid = $input->post->key;
          $ch->cant = 1;
          $ch->state = 0;
          $ch->etapa = $input->post->etapa;
          $ch->title=$value->title.'-'.($y+1).'-P'.($x+1);
          if($x==(ceil($nwTime)-1))
            $ch->duration=revertDec(fmod($time,2));
          else
            $ch->duration='02:00';
            
            $ch->save();
        }
      }
    }else{
      $time=convertDec($value->duration)*$cant;
      if($time>2){
          $invTime=convertDec($value->duration);
          $actHour=floor(2/$invTime);

          $nwTime=floor($cant/$actHour);
          if(fmod($cant,$actHour)>0) $nwTime++;
            for($x=0;$x<($nwTime);$x++){
              $ch = new Page();
              $ch->setOutputFormatting(false);
              $ch->template = 'activities'; 
              $ch->parent = wire('pages')->get($input->post->odp);
              $ch->title=$value->title.'-'.($x+1);
              $ch->prid = $input->post->key;
              $ch->state = 0;
              $ch->etapa = $input->post->etapa;
              if($x==($nwTime-1) && fmod($cant,$actHour)>0){
                $ch->cant=fmod($cant,$actHour);
                $ch->duration=mulhours($value->duration,fmod($cant,$actHour));
              }
              else{
                $ch->cant=$actHour;
                $ch->duration=mulhours($value->duration,$actHour);
              }
                $ch->save();
            }
      }else{
        $ch = new Page();
        $ch->setOutputFormatting(false);
        $ch->template = 'activities'; 
        $ch->parent = wire('pages')->get($input->post->odp);
        $ch->title=$value->title;
        $ch->duration=$value->duration;
        $ch->prid = $input->post->key;
        $ch->cant = $input->post->canti;
        $ch->state = 0;
        $ch->etapa = $input->post->etapa;
        $ch->save();
      }

    }
    
  }


  echo 'true';
                