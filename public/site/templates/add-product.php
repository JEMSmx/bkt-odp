<?php

        if(isset($input->post->id_pro)){
          $times=array();

            if(isset($input->post->tarm))
              $times[]='Habilitar/'.$input->post->thab;
            else
              $times[]='Habilitar/00:00';
              
            if(isset($input->post->tarm))
              $times[]='Armar/'.$input->post->tarm;
            else
              $times[]='Armar/00:00';
            
              
            if(isset($input->post->tens))
              $times[]='Ensamblar/'.$input->post->tens;
            else
              $times[]='Ensamblar/00:00';

            if(isset($input->post->tenv))
              $times[]='Envolver/'.$input->post->tenv;
            else
              $times[]='Envolver/00:00';
              
            if(isset($input->post->tent))
              $times[]='Entarimar/'.$input->post->tent;
            else
              $times[]='Entarimar/00:00';

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

            $times=array();

            if(isset($input->post->tarm) && $input->post->checkFab=='on')
              $times[]='Habilitar/'.$input->post->thab;
            else
              $times[]='Habilitar/00:00';
              
            if(isset($input->post->tarm) && $input->post->checkFab=='on')
              $times[]='Armar/'.$input->post->tarm;
            else
              $times[]='Armar/00:00';
            
              
            if(isset($input->post->tens) && $input->post->checkEns=='on')
              $times[]='Ensamblar/'.$input->post->tens;
            else
              $times[]='Ensamblar/00:00';

            if(isset($input->post->tenv) && $input->post->checkEmp=='on')
              $times[]='Envolver/'.$input->post->tenv;
            else
              $times[]='Envolver/00:00';
              
            if(isset($input->post->tent) && $input->post->checkEmp=='on')
              $times[]='Entarimar/'.$input->post->tent;
            else
              $times[]='Entarimar/00:00';

            $title=$input->post->nombrep;
            $modelo=$input->post->modelo;
            $products=$pages->find("template=product, title=$title, modelo=$modelo"); 
            if($products->count()>0){
              echo false;
            }else{
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
            
           }