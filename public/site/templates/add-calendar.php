<?php 

if(isset($input->post->edit)){
	$pos = strpos($input->post->id, "/");
	if ($pos === false) {
    	$pa = wire('pages')->get($input->post->id);
	} else {
		$newid=explode("/", $input->post->id);
	    $pa = wire('pages')->get($newid[1]);
	}
	$pa->of(false);
	$pa->ini = $input->post->ini;
	$pa->fin = $input->post->fin;
	$pa->bc = $input->post->bc;
	$pa->bg = $input->post->bg;

	$pa->save();
	echo true;	
}else{
	$pa = new Page();
	$pa->setOutputFormatting(false);
	$pa->template = 'event'; 
	$pa->parent = wire('pages')->get($input->post->user);
	$pa->title = $input->post->title;
	$pa->ini = $input->post->ini;
	$pa->fin = $input->post->fin;
	$pa->odt = $input->post->id;
	$pa->bc = $input->post->bc;
	$pa->bg = $input->post->bg;

	$pa->save();
	echo true;
}

