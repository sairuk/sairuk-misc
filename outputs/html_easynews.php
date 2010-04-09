<?php

### EasyNews output module

global $modname, $outfile;

$modname = 'EasyNews Global Search';
$outfile = "$name.html";

function writeout_header()
{

	global $name;
	global $xmlhndl;

	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<head>"."\n");
	fwrite($xmlhndl , "<title>Easynews Global Search Links for ".$name."</title>"."\n");
	fwrite($xmlhndl , "<link rel=".chr(34)."stylesheet".chr(34)." type=".chr(34)."text/css".chr(34)." href=".chr(34)."/style.css".chr(34)." />\n");
	fwrite($xmlhndl , "</head>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>Easynews Global Search Links for ".$name."</h3>"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
	
	foreach ($items AS $item)
	{
		$title = $item['value'];
		$item = preg_replace('/\s/','+',$item);
		fwrite($xmlhndl , "<a href=".chr(34)."http://members.easynews.com/global4/search.html?gps=".$item['value'].chr(34)." target=".chr(34)._blank.chr(34).">".$title."</a></a><br />"."\n");
	}
	
}

function writeout_footer()
{
	global $outfile;
	global $xmlhndl;

	fwrite($xmlhndl , "</body>"."\n");
	fwrite($xmlhndl , "</body>"."\n");
	fwrite($xmlhndl , "</html>"."\n");
    create_link($outfile);
}

?>
