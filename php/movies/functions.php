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

 $filename = dir($location);

 while(($line = $filename->read()) !== false)
 {
  if ( preg_match('/avi$|mpg$|mp4$|mov$|mkv$|/i',$line))
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
	   <h4>'.$title.' Movies on Server - ('.$count.')</h4>
	  </td>
	 </tr>
	');

 foreach ($array as $key => $val) 
 {
        $link = preg_replace('/\s/','+',$val);

        #removes additional space at begginning of title
        $val = preg_replace('/^ /','',$val);

  	# Prints a valid IMDB link in HTML
  	if ( ord($link) != 0 ) 
  	{
        	echo(' 
		<tr>
            	 <td>
		  <a href="http://www.imdb.com/find?s=all&q='.$link.'&x=0&y=0" title="Search IMDB" target="_blank">'.$val.'</a>
            	 </td>
          	</tr>
        	');
  	}
 }

echo(' </table> ');

}
?>
