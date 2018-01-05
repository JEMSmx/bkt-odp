<?php

/**
 * Shared functions used by the beginner profile
 *
 * This file is included by the _init.php file, and is here just as an example. 
 * You could place these functions in the _init.php file if you prefer, but keeping
 * them in this separate file is a better practice. 
 *
 */

/**
 * Given a group of pages, render a simple <ul> navigation
 *
 * This is here to demonstrate an example of a simple shared function.
 * Usage is completely optional.
 *
 * @param PageArray $items
 *
 */

function quitaracentos($String){
    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
    $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
    $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
    $String = str_replace(array('í','ì','î','ï'),"i",$String);
    $String = str_replace(array('é','è','ê','ë'),"e",$String);
    $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
    $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","C",$String);
    $String = str_replace("Ý","Y",$String);
    $String = str_replace("ý","y",$String);
    $String = str_replace("&aacute;","a",$String);
    $String = str_replace("&Aacute;","A",$String);
    $String = str_replace("&eacute;","e",$String);
    $String = str_replace("&Eacute;","E",$String);
    $String = str_replace("&iacute;","i",$String);
    $String = str_replace("&Iacute;","I",$String);
    $String = str_replace("&oacute;","o",$String);
    $String = str_replace("&Oacute;","O",$String);
    $String = str_replace("&uacute;","u",$String);
    $String = str_replace("&Uacute;","U",$String);
    return $String;
  }
 
 function mulhours($dateOriginal, $num){
	$timeUnit=$dateOriginal;
	$time=explode(":",$timeUnit);
	$waitingTime=$num*$time[1];
	$minute = sprintf("%02d", ($waitingTime%60));
	$hour = sprintf("%02d", ($waitingTime/60));
	$current_time = floor($hour+($time[0]*$num)).':'.($minute);
	return $current_time;
}

	function parteHora($hora){    
		$horaSplit = explode(":", $hora);

		if( count($horaSplit) < 3 )
		{
			$horaSplit[2] = 0;
		}

		return $horaSplit;
	}
	
	function parteMinuto($hora){    
		$horaSplit = explode(".", $hora);

		if( count($horaSplit) < 2 )
		{
			$horaSplit[1] = 0;
		}

		return $horaSplit;
	}

 function sumarHoras($time1,$time2){
            list($hour1, $min1) = parteHora($time1);
            list($hour2, $min2) = parteHora($time2);

            return date('H:i', mktime( $hour1 + $hour2, $min1 + $min2));
  }  
  
   function restarHoras($time1,$time2){
            list($hour1, $min1) = parteHora($time1);
            list($hour2, $min2) = parteHora($time2);

            return date('H:i', mktime( $hour1 - $hour2, $min1 - $min2));
  }  
  
  

  function convertDec($time){
        $hms = explode(":", $time);
        return (intval($hms[0]) + (intval($hms[1])/60));
    }

  function revertDec($time){
  	    if(($time*60)<60)
        	return ('00:'.($time*60));
        else{
        	$time=$time-1;
        	return ('01:'.($time*60));
        }
    }
    
    function decHour($time){
        list($hour, $min) = parteMinuto($time);
        $minS=$time-$hour;
        $minT=$minS*60;
        if($minT<=9)
        	$minT='0'.$minT;

        if($hour<=9)
            $hr='0'.$hour;
        else
            $hr=$hour;
        return($hr.':'.$minT);
    }



function renderNav(PageArray $items) {

	if(!$items->count()) return;

	echo "<ul class='nav' role='navigation'>";

	// cycle through all the items
	foreach($items as $item) {

		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			echo "<li class='current' aria-current='true'>";
		} else {
			// otherwise just a regular list item
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		if($item->summary) echo "<div class='summary'>$item->summary</div>";

		// close the list item
		echo "</li>";
	}

	echo "</ul>";
}


/**
 * Given a group of pages render a tree of navigation
 *
 * @param Page|PageArray $items Page to start the navigation tree from or pages to render
 * @param int $maxDepth How many levels of navigation below current should it go?
 *
 */
function renderNavTree($items, $maxDepth = 3) {

	// if we've been given just one item, convert it to an array of items
	if($items instanceof Page) $items = array($items);

	// if there aren't any items to output, exit now
	if(!count($items)) return;

	// $out is where we store the markup we are creating in this function
	// start our <ul> markup
	echo "<ul class='nav nav-tree' role='navigation'>";

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class and
		// visually hidden text for screen readers to it
		if($item->id == wire('page')->id) {
			echo "<li class='current' aria-current='true'><span class='visually-hidden'>Current page: </span>";
		} else {
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a>";

		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children 
		if($item->hasChildren() && $maxDepth) {
			renderNavTree($item->children, $maxDepth-1);
		}

		// close the list item
		echo "</li>";
	}

	// end our <ul> markup
	echo "</ul>";
}
