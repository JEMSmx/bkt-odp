<?php $activity = wire('pages')->get($input->post->key);
  
        $activity->of(false);
        $activity->title=$input->post->title;
        $activity->duration=$input->post->duration;
        $activity->save();
        $activity->of(true);
        echo 'true';