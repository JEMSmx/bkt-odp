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
            $p->save();
            echo true;
        } else{
            extract($_POST);
           
            $p = new Page();
            $p->setOutputFormatting(false);
            $p->template = 'work'; 
            $p->parent = wire('pages')->get('/ordenes-de-trabajo');
            $p->title = $datos[0];
            $p->cotizacion = $datos[1];
            $p->cliente = $datos[2];
            $p->fechai = $data[3][0];
            $p->fechaf = $data[4][0];
            $p->datos = '$';
            $p->save();
            echo $p->url;
           }