<?php
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