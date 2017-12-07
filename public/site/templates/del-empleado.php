<?php

    $u = $users->get($input->post->iduser);
    if($u->hasRole('empleado')){
        $users->delete($u);
        echo 'true';
    }
    