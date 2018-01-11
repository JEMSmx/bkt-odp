<?php 


$ch = new Page();
$ch->setOutputFormatting(false);
$ch->template = 'activities'; 
$ch->parent = wire('pages')->get($input->post->odp);
$ch->title=$input->post->title;
$ch->duration=$input->post->duration;
$ch->cant=$input->post->cant;
$ch->prid = 0;
$ch->state = 0;
$ch->etapa = 0;
$ch->save();
        

echo 'true';


                