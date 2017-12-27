<?php

        if(isset($input->post->edit) && $input->post->edit=='true'){
            $p = wire('pages')->get($input->post->id);
            $p->of(false);
            $p->title = $input->post->title;
            $p->cliente = $input->post->cliente; 
            $p->cotizacion = $input->post->cotizacion; 
            $p->fechai = $input->post->fechai; 
            $p->fechaf = $input->post->fechaf; 
            $p->save();
            echo true;
        } else{
            $p = new Page();
            $p->setOutputFormatting(false);
            $p->template = 'work'; 
            $p->parent = wire('pages')->get('/ordenes-de-produccion');
            $p->title = $input->post->title;
            $p->cotizacion = $input->post->cotizacion;
            $p->cliente = $input->post->empresa;
            $p->fechai = $input->post->fechaIni;
            $p->fechaf = $input->post->fechaFin;
            $p->save();
            echo $p->url;
           }