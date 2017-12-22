<?php

    $p = wire('pages')->get($input->post->activity);
    $p->of(false);
    $p->state = $input->post->status;
    $p->save();
    echo true;
