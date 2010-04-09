<?php

### Google output module

global $modname, $outfile;

$modname = 'Google Search';
$outfile = "$name.html";

function writeout_header()
{

	global $name;
	global $xmlhndl;

	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<title>Google Search Links for ".$name."</title>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>Google Search Links for ".$name."</h3>"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
	foreach ($items AS $item)
	{
		$title = $item['value'];
		$item = preg_replace('/\s/','+',$item);
		fwrite($xmlhndl , "<a href=".chr(34)."http://www.google.com.au/search?q=".$item['value'].chr(34)." target=".chr(34)._blank.chr(34).">".$title."</a></a><br />"."\n");
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
