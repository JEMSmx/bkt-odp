<?php
      $times=array();
        if(isset($input->post->id_pro)){

            if(isset($input->post->thab))
              $times[]=$input->post->thab;
            if(isset($input->post->tarm))
              $times[]=$input->post->tarm;
            if(isset($input->post->tens))
              $times[]=$input->post->tens;
            if(isset($input->post->tenv))
              $times[]=$input->post->tenv;
            if(isset($input->post->tent))
              $times[]=$input->post->tent;

        $get_pro=file_get_contents('http://bktmobiliario.com/api/product/read.php?id_product='.$input->post->pro_id);
        $pr=json_decode($get_pro, true);
        $md=$pr['products'][0]['modelos'];
        $img_mo="";
        foreach($md as $model){
          if(strtolower($model['nombre'])==strtolower($input->post->modelo)){
            $img_mo=$model['imagen'];
            break;
          }
        }

            $p = wire('pages')->get($input->post->id_pro);
            $p->of(false);
            $p->title = $input->post->nombrep;
            $p->linea = $input->post->linea; 
            $p->familia = $input->post->familia;
            $p->categoria = $input->post->categoria;
            $p->modelo = $input->post->modelo;
            $p->miniatura = $img_mo;
            $p->save();
            $inc=0;
            foreach ($p->children() as $key => $value) {
                if($value->duration!=$times[$inc]){
                  $ch = wire('pages')->get($value->id);
                  $ch->of(false);
                  $ch->duration = $times[$inc];
                  $ch->save();
                }
                $inc++;
            }
            echo true;
        } else{
          //Crear nuevo producto, con sus respectivos tiempos

            if(isset($input->post->thab) && $input->post->checkFab=='on')
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
                    
        $get_pro=file_get_contents('http://bktmobiliario.com/api/product/read.php?id_product='.$input->post->pro_id);
        $pr=json_decode($get_pro, true);
        $md=$pr['products'][0]['modelos'];
        $img_mo="";
        foreach($md as $model){
          if(strtolower($model['nombre'])==strtolower($modelo)){
            $img_mo=$model['imagen'];
            break;
          }
        }
        
       
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
              $p->miniatura = $img_mo;
              $p->save();
              foreach ($times as $key => $value) {
                $data=explode('/', $value);
                $ch = new Page();
                $ch->setOutputFormatting(false);
                $ch->template = 'activities'; 
                $ch->parent = wire('pages')->get($p->id);
                $ch->title = $data[0];
                $ch->duration = $data[1];
                $ch->save();
              }
              echo true;
            }
            
        }