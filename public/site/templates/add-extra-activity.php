<?php 


$ch = new Page();
$ch->setOutputFormatting(false);
$ch->template = 'activities'; 
$ch->parent = wire('pages')->get(1643);
$ch->title=$input->post->title;
$ch->duration=$input->post->duration;
$ch->type='activity-extra';
$ch->cant=1;
$ch->prid = 0;
$ch->state = 0;
$ch->etapa = 0;
$ch->save();
        

echo $ch->id;


                