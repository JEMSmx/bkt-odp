<?php 


$id_cat=$input->post->fam;

 $categories=file_get_contents('http://bktmobiliario.com/api/category/read.php');
 $obj_cat = json_decode($categories); 
 	 echo '<option data-id="0">Selecciona</option>';
 foreach ($obj_cat->categories->{$id_cat."/"}->subcategories as $subcategory) { 
    echo '<option data-id="'.$subcategory->id.'" value="'.$subcategory->nombre.'">'.$subcategory->nombre.'</option>';
 }