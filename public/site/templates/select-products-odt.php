<?php 


if(isset($input->post->type)){
	$id_pro=$input->post->id_pro;
	echo $id_pro;
	$products=$pages->find("template=product, title=$id_pro");
 echo '<option>Selecciona</option>';
 foreach ($products as $product) { 
    echo '<option data-id="'.$product->id.'" value="'.$product->id.'">'.$product->modelo.'</option>';
 }
 
}else{
	$id_cat=$input->post->id_sub;

 $products=$pages->find("template=product, categoria=$id_cat");
 echo '<option>Selecciona</option>';
 foreach ($products as $product) { 
    echo '<option data-id="'.$product->id.'" value="'.$product->title.'">'.$product->title.'</option>';
 }
}

