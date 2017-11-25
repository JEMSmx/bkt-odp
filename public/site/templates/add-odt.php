<?php

  $datos=$input->post->data; 


        if(isset($input->post->id_pro)){
            $p = wire('pages')->get($input->post->id_pro);
            $p->of(false);
            $p->title = $input->post->nombrep;
            $p->linea = $input->post->linea; 
            $p->familia = $input->post->familia;
            $p->categoria = $input->post->categoria;
            $p->modelo = $input->post->modelo;
            $p->tiempos = implode(",", $times);
            $p->save();
            echo true;
        } else{
            $p = new Page();
            $p->setOutputFormatting(false);
            $p->template = 'work'; 
            $p->parent = wire('pages')->get('/ordenes-de-trabajo');
            $p->title = $datos[0];
            $p->cliente = $datos[1];
            $p->fechai = $datos[2];
            $p->fechaf = $datos[3];
            $p->save();
            echo true;
           }