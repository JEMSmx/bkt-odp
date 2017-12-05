<?php 


if(isset($input->post->type)){
	$id_pro=$input->post->id_pro;

 $product=file_get_contents('http://bktmobiliario.com/api/product/read.php?id_product='.$id_pro);
 $obj_pro = json_decode($product); 
 echo '<option>Selecciona</option>';
 foreach ($obj_pro->products[0]->modelos as $model) { 
    echo '<option>'.$model->nombre.'</option>';
 }
}else{
	$id_cat=$input->post->id_sub;

 $products_in_category=file_get_contents('http://bktmobiliario.com/api/product/read.php?id='.$id_cat);
 $obj_pro_in_category = json_decode($products_in_category); 
 echo '<option>Selecciona</option>';
 foreach ($obj_pro_in_category->products as $product) { 
    echo '<option data-id="'.$product->id.'">'.$product->nombre.'</option>';
 }
}

