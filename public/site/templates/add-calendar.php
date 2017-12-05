<?php 



if(isset($input->post->edit)){
		
		$id_edit=explode("#", $input->post->id);
		$p=$users->get($id_edit[1]);
		$cal=array();
		foreach (explode("$", $p->calendario) as $key => $value) {
			if($value=='') continue;
		  $work=explode('%', $value);
			if ($work[1]==$input->post->title) {
			   $cal[]=$input->post->id.'#'.$p->id.'%'.$input->post->title.'%'.$input->post->ini.'%'.$input->post->fin.'%'.$input->post->bg.'%'.$input->post->bc.'$';
			}else{
			   $cal[]=$value;
			}
		}
		
		$p->of(false);
	  	$p->calendario=implode("$", $cal).'$';
	  	$p->save();
	  	echo true;
}else{
	$p = $users->get($input->post->user);

$calendar=$p->calendario;

  $p->of(false);
  $p->calendario=$calendar.$input->post->id.'#'.$p->id.'%'.$input->post->title.'%'.$input->post->ini.'%'.$input->post->fin.'%'.$input->post->bg.'%'.$input->post->bc.'$';
  $p->save();
  echo true;
}

