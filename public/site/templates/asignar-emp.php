<?php

   

       if(isset($input->post->edit) && $input->post->edit=='delete'){
       	  $activity = wire('pages')->get($input->post->activity);
		  $p = wire('pages')->get($activity->odt->id);
		  $p->of(false);
       	  $u=$users->get($input->post->user);
          $p->assign='';
          $p->state=0;
          $p->save();
          $pages->delete($activity);
    	  echo true;
       }else{
       	  $p = wire('pages')->get($input->post->activity);
    	  $p->of(false);
          $p->assign = $input->post->user;
          $p->save();
    	  echo true;
       }
    
