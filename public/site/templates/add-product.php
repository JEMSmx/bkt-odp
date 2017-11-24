<?php

      $times=array();
      if(isset($input->post->tfab))
        $times[]='Fabricacion/'.$input->post->tfab;
      if(isset($input->post->thab))
        $times[]='Habilitado/'.$input->post->thab;
      if(isset($input->post->tarm))
        $times[]='Armado/'.$input->post->tarm;
      if(isset($input->post->taca))
        $times[]='Acabado/'.$input->post->taca;
      if(isset($input->post->talm))
        $times[]='Almacen/'.$input->post->talm;
      if(isset($input->post->tens))
        $times[]='Ensamblar/'.$input->post->tens;
      if(isset($input->post->thab1))
        $times[]='Habilitar/'.$input->post->thab1;
      if(isset($input->post->tarm1))
        $times[]='Armado/'.$input->post->tarm1;
       if(isset($input->post->temp))
        $times[]='Empacar/'.$input->post->temp;
      if(isset($input->post->temp1))
        $times[]='Empacar/'.$input->post->temp1;
      if(isset($input->post->tenv))
        $times[]='Envolver/'.$input->post->tenv;


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
            $p->template = 'product'; 
            $p->parent = wire('pages')->get('/productos');
            $p->title = $input->post->nombrep;
            $p->linea = $input->post->linea; 
            $p->familia = $input->post->familia;
            $p->categoria = $input->post->categoria;
            $p->modelo = $input->post->modelo;
            $p->tiempos = implode(",", $times);
            $p->save();
            echo true;
           }