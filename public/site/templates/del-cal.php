<?php 

    $pos = strpos($input->post->key, '/');
      if ($pos !== false) {
        $newid=explode('/', $input->post->key);
        $activity = wire('pages')->get($newid[1]);
      }else{
        $activity = wire('pages')->get($input->post->key);
      }

    $p = wire('pages')->get($activity->odt->id);
    $p->of(false);
    $u=$users->get($input->post->user);
    $p->assign='';
    $p->state=0;
    $p->save();

    $pages->delete($activity);
    echo true;

