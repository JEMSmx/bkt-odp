<?php 
	if(isset($input->post->edit)){
		$activity=wire('pages')->get($input->post->key);
		$pages->delete($activity);
	}

	echo true;
		
     
                