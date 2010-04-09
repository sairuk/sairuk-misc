<?php

### Google output module

global $modname, $outfile;

$modname = 'All Search';
$outfile = "$name.html";

function writeout_header()
{

	global $name;
	global $xmlhndl;

	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<title>Search Links for ".$name."</title>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>Search Links for ".$name."</h3>"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
	foreach ($items AS $item)
	{
		$title = $item['value'];
		$item = preg_replace('/\s/','+',$item);
		fwrite($xmlhndl , $title . " 
			| <a href=".chr(34)."http://www.google.com.au/search?q=".$item['value'].chr(34).">google</a></a>
			| <a href=".chr(34)."http://www.binsearch.info/?q=".$item['value'].chr(34).">binsearch</a></a>
			| <a href=".chr(34)."http://members.easynews.com/global4/search.html?gps=".$item['value'].chr(34)." target=".chr(34)._blank.chr(34).">easynews</a></a>
			<br />\n
		");
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
