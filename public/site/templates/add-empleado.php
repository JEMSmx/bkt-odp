<?php

if(isset($input->post->edit) && $input->post->edit=='true'){
     $u=wire("users")->get($input->post->emp);
     $u->of(false);
     $u->name = $input->post->us;
     $u->puesto = $input->post->pu;
     $u->namefull = $input->post->nm;
     $u->save();
     echo 'true';  

}else{

     $user = wire("users")->get($input->post->name);
     
     if($user->id){
        $new_image = $_FILES["foto"]["tmp_name"];
        $user->of(false);
        $user->status = Page::statusOn;
        $user->pass = '123456';
        $user->puesto = $input->post->puesto; 
        $user->namefull = $input->post->namefull; 
        $user->fondo = 'yellow';
        $user->addRole('empleado'); 
        $user->images->deleteAll();
        $user->images->add($new_image);
        $user->save();
        $user->of(true);
        echo 'true';
     }else{
         $new_image = $_FILES["foto"]["tmp_name"];
        $u = new User(); 
        $u->name = $input->post->name; 
        $u->pass = '123456';
        $u->puesto = $input->post->puesto; 
        $u->namefull = $input->post->namefull; 
        $u->fondo = 'yellow';
        $u->addRole('empleado'); 
        $u->save();
       
        $u->of(false);

        $u->images->add($new_image);

        $u->save();
        
        $u->of(true);

         echo 'true';  
     }

   
}
    