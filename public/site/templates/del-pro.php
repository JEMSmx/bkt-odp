<?php

    
    $pa = wire('pages')->get($input->post->pro);
    foreach ($pa->children() as $key => $value) {
        $value->of(false);
            $value->status = Page::statusUnpublished;
            $value->save();
            $value->of(true);
    }
        $pa->of(false);
        $pa->status = Page::statusUnpublished;
        $pa->save();
        $pa->of(true);
        echo 'true';
    
    