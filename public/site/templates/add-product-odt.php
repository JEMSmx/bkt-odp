<?php 


$k = wire('pages')->get($input->post->key);
$cant=1;
$tiempos=$k->id.'/'.$cant.'$';


$p = wire('pages')->get($input->post->odt);
$res=$p->datos;
if (strpos($res, $input->post->key) !== false) {
    $arraynew=array();
    $datos=explode('$', $res);
    foreach ($datos as $key => $value) {
        $getid=explode("/", $value);
        if($getid[0]==$input->post->key){
           $arraynew[]=$getid[0].'/'.($getid[1]+$cant).'$';
           break;
        }else{
          $arraynew[]=$value;
        }
    }
    $res=implode('$', $arraynew);
    $p->of(false);
    $p->datos = $res;
    $p->save();
    echo true;
}else{
  $p->of(false);
  $p->datos = $res.$tiempos;
  $p->save();
  echo true;
}



