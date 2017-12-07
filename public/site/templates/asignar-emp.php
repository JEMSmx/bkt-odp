<?php

$id=explode('/', $input->post->id);

$p = wire('pages')->get($input->post->odt);
$res=explode('$', $p->datos);
$data=array();
$newacts=array();
foreach ($res as $key => $value) {
  if($value=='') continue;
  $acts=explode('/', $value);
  if($acts[0]==$id[0]){
    foreach (explode(',', $acts[2]) as $id_a=>$act) {
        if($id[1]==$id_a){
          $actual=explode('-', $act);
          $newacts[]=$actual[0].'-'.$input->post->asig;
        }else{
          $newacts[]=$act;
        }
    }
    $data[]=$acts[0].'/'.$acts[1].'/'.implode(',', $newacts).'/'.$acts[3];
  }else{
    $data[]=$value;
  }
}


$new_data=implode('$', $data);

    $p->of(false);
    $p->datos = $new_data;
    $p->save();
    echo true;

