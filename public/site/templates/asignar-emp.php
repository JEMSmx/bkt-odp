<?php

   

       if(isset($input->post->edit) && $input->post->edit=='delete'){
          if($input->post->type=="extra-activity"){
              $newid=explode("/", $input->post->activity);
              $activity = wire('pages')->get($newid[1]);
              $p = wire('pages')->get($newid[0]);
              $p->of(false);
              $u=$users->get($input->post->user);
              $p->assign='';
              $p->state=0;
              $p->save();
              $pages->delete($activity);
              echo true;
          }else{
            $activity = wire('pages')->get($input->post->activity);
              $p = wire('pages')->get($activity->odt->id);
              $p->of(false);
              $u=$users->get($input->post->user);
              $p->assign='';
              $p->state=0;
              $p->save();
              $pages->delete($activity);
              echo true;
          } 
       }else{
        if($input->post->type=="extra-activity"){
          $newid=explode("/", $input->post->activity);
            $p = wire('pages')->get($newid[1]);
            $p->of(false);
            $p->assign = $input->post->user;
            $p->save();
           echo true;
        }else{
          $p = wire('pages')->get($input->post->activity);
          $p->of(false);
          $p->assign = $input->post->user;
          $p->save();
          echo true;
        }
       	  
       }
    
