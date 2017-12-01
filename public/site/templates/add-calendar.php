<?php 


$p = $users->get($input->post->user);

$calendar=$p->calendario;

  $p->of(false);
  $p->calendario=$calendar.$input->post->id.'%'.$input->post->id.'%'.$input->post->ini.'%'.$input->post->fin.'%'.$input->post->bg.'%'.$input->post->bc.'$';
  $p->save();
  echo true;
