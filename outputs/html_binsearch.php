<?php

### Binsearch output module

global $modname, $outfile;

$modname = 'binsearch.info';
$outfile = "$name.html";

function writeout_header()
{
	global $name;
	global $xmlhndl;
	
	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<title>binsearch.info Links for ".$name."</title>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>binsearch.info Links for ".$name."</h3>"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
	      
	foreach ($items AS $item)
	{
		$title = $item['value'];
		$item = preg_replace('/\s/','+',$item);
		fwrite($xmlhndl , "<a href=".chr(34)."http://www.binsearch.info/?q=".$item['value'].chr(34).">".$title."</a></a><br />"."\n");
	}
        
}

function writeout_footer()
{
	global $outfile;
	global $xmlhndl;
	
	fwrite($xmlhndl , "</body>"."\n");
	fwrite($xmlhndl , "</html>"."\n");
    create_link($outfile);
}

?>
