<?php 


$ch = new Page();
$ch->setOutputFormatting(false);
$ch->template = 'activities'; 
$ch->parent = wire('pages')->get('/actividades-extra');
$ch->title=$input->post->title;
$ch->duration=$input->post->duration;
$ch->type='extra-activity';
$ch->cant=1;
$ch->prid = 0;
$ch->state = 0;
$ch->etapa = 0;
$ch->save();
        

echo $ch->id;


                