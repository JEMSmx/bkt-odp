<?php

    $u = $users->get($input->post->idemp);
    if($u->hasRole('empleado')){
    	
    	foreach ($u->children() as $value) {
    		$value->of(false);
    		$value->status = Page::statusUnpublished;
    		$value->save();
    		$value->of(true);
    	}
    	$u->of(false);
        $u->status = Page::statusUnpublished;
        $u->save();
    	$u->of(true);
        echo 'true';
    }
    