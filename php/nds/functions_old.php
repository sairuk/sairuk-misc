<?

#array_walk(explode("|",$mtype),preg_ext);

function preg_ext(&$items,$name)
{
 $item = $items."$";
   if (preg_match('/'.$item.'/i',$name));
   {
	   return($name);
   }
 }

function buildpage($location,$title) 
{
    $cellcnt = 1;
    $tblcells = 5;
    $filename = dir($location);

 while(($line = $filename->read()) !== false)
 {
  if ( preg_match('/zip$/i',$line))
   {

   if ( preg_match('/cd2/i',$line))

    {
     #dont do anything atm
    } else {
     $line = preg_replace('/cd1|-cd1/i','',$line);
     $line = substr($line,0,strlen($line)-4);
     $cat = $cat.'|'.$line;
    }

  }

 }

 $array = explode('|',$cat);
 $count = count($array)-1;
 sort($array);
 
 echo	('
	<table>
         <tr>
	  <td>
	   <h4>'.$title.' Games on Server - ('.$count.')</h4>
	  </td>
	 </tr>
	');

 foreach ($array as $key => $val) 
 {
        preg_match('/^[0-9]{4}/',$val,$matches);
        $link = preg_replace('/^[0-9]{4} - /','',$val);

  	# Display Items with CoverArt
  	if ( ord($link) != 0 ) 
  	{
             	
        	echo(' 
            	 <td>
            	    <table border="0">
            	    <tr>
            	        <td><img src=artwork/'.$matches[0].'.jpg title='.$link.'/></td>
            	    </tr>
            	    <tr>
            	        <td>'.$link.'</td>
		           </tr>
		           </table>
            	 </td>
        	');
        	
                if ( $cellcnt == $tblcells ) {
              	    echo(' <tr></tr> ');
              	    $cellcnt = 1;
              	} else {
              	    $cellcnt++;
              	}

  	}
 }

echo(' </table> ');

}
?>
