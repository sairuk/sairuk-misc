<?php

require('globals.php');
require('dbconn.php');

function builddb($dir1,$tblnm)
{
    $filename = dir($dir1) or die("Could not read files in $dir1");
    echo "Attempting to empty all data from: $tblnm<br />";
    mysql_query("TRUNCATE TABLE $tblnm") or die("Empty Failed, will not continue: " . mysql_error());
    echo "Success!<br />";

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

 foreach ($array as $key => $val)
 {
        //split release number
        preg_match('/^[0-9]{4}|^[x].../',$val,$number);
        //split region/languages
        preg_match('/\(.*\)$/',$val,$region);
        $region_nospc = preg_replace('/\(|\)/','',$region[0]);
        $reg = explode(' ',$region_nospc);
        //clean title
        $link = preg_replace('/^[0-9]{4} - |^[x]... - /','',$val);
        $link = preg_replace('/ \(.*$/','',$link);

        if ( ord($link) != 0 )
        {

        //Add to DB
        mysql_query("INSERT INTO ". $tblnm ." (Number,Title,Region,Language) VALUES ('" . $number[0] ."','" . $link ."','" . $reg[0] ."','" . $reg[1] ."')");
    echo "Added: $number[0]  - $link <br />";
        }
 }
exit;
}

builddb($dir1,$tblnm);

?>

