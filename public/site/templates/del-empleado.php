<?php

    $u = $users->get($input->post->idemp);
    if($u->hasRole('empleado')){
        $users->delete($u);
        echo 'true';
    }
    