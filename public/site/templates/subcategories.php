<?php 


$id_cat=$input->post->fam;

 $categories=file_get_contents('http://bktmobiliario.com/api/category/read.php');
 $obj_cat = json_decode($categories); 
 foreach ($obj_cat->categories->{$id_cat."/"}->subcategories as $subcategory) { 
    echo '<option>'.$subcategory->nombre.'</option>';
 }