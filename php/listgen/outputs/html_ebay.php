<?php

### Google output module

global $modname, $outfile;

$modname = 'Ebay Search';
$outfile = "$name.html";

function writeout_header()
{

	global $name;
	global $xmlhndl;

	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<head>"."\n");
	fwrite($xmlhndl , "<title>Ebay Search Links for ".$name."</title>"."\n");
	fwrite($xmlhndl , "<link rel=".chr(34)."stylesheet".chr(34)." type=".chr(34)."text/css".chr(34)." href=".chr(34)."/style.css".chr(34)." />\n");
	fwrite($xmlhndl , "</head>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>Ebay Search Links for ".$name."</h3>"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
	foreach ($items AS $item)
	{
		$title = $item['value'];
		// Replace Spaces with +
		$item = preg_replace('/\s/','+',$item);
		// Replace & with %26
		$item = preg_replace('/&/','%26',$item);
		fwrite($xmlhndl , "<a href=".chr(34)."http://shop.ebay.com/?_nkw=".$item['value'].chr(34)." target=".chr(34)._blank.chr(34).">".$title."</a></a><br />"."\n");
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
