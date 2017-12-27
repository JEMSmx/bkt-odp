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
    $data=$input->post->data; 
    $u = new User(); 
    $u->name = $data[0]; 
    $u->pass = '123456';
    $u->puesto = $data[2];
    $u->namefull = $data[1];
    $u->fondo = 'yellow';
    $u->addRole('empleado'); 
    $u->save();
    echo 'true';  
}
    