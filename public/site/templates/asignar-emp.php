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
              $p->view=0;
              $p->completed=0;
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
              $p->view=0;
              $p->completed=0;
              $p->save();
              $pages->delete($activity);
              echo true;
          } 
       }else if(isset($input->post->edit) && $input->post->edit=='work'){
          $data=explode("/", $input->post->id);
              
              $p = wire('pages')->get($data[0]);
              $p->of(false);
              $p->assign = $input->post->asig;
              if($input->post->asig=0)
                $p->view=0;
              else
                $p->view=1;
              $p->save();
             echo true;
          

       }else if(isset($input->post->edit) && $input->post->edit=='product'){
            $data=explode("/", $input->post->pro);
            $pges=wire('pages')->get($input->post->odt);
            $assign=$input->post->asig;
            foreach ($pges->children("prid=$data[0]") as $key => $p) {

              $p->assign = $assign;
              if($assign==0){
                $p->view=0;
                $p->completed=0;
              }
              else
                $p->view=1;
              $p->of(false);
              $p->save();
            

            }
             echo true;

       }else{
        if($input->post->type=="extra-activity"){
          $newid=explode("/", $input->post->activity);
            $p = wire('pages')->get($newid[1]);
            $p->of(false);
            $p->assign = $input->post->user;
             if($input->post->asig=0)
                $p->view=0;
            else
                $p->view=1;
            $p->save();
           echo true;
        }else{
          $p = wire('pages')->get($input->post->activity);
          $p->of(false);
          $p->assign = $input->post->user;
          if($input->post->asig=0)
            $p->view=0;
          else
            $p->view=1;
          $p->save();
          echo true;
        }
       	  
       }
    
