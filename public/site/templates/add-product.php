<?php

      $times=array();

      if(isset($input->post->tarm) && $input->post->checkFab=='on')
        $times[]='Habilitar/'.$input->post->thab;
      if(isset($input->post->tarm) && $input->post->checkFab=='on')
        $times[]='Armar/'.$input->post->tarm;
      
        
      if(isset($input->post->tens) && $input->post->checkEns=='on')
        $times[]='Ensamblar/'.$input->post->tens;

      if(isset($input->post->tenv) && $input->post->checkEmp=='on')
        $times[]='Envolver/'.$input->post->tenv;
      if(isset($input->post->tent) && $input->post->checkEmp=='on')
        $times[]='Entarimar/'.$input->post->tent;


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