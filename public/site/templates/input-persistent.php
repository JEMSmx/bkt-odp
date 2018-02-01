<?php 
      if(isset($input->post->input))
        $_SESSION['tarea']=$input->post->input;


      echo $_SESSION['tarea'];