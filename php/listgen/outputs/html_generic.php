<?php

### Google output module

global $modname, $outfile;

$outfile = "$name.html";

function writeout_header()
{

	global $name, $modname, $xmlhndl;

	fwrite($xmlhndl , "<html>"."\n");
	fwrite($xmlhndl , "<head>"."\n");
	fwrite($xmlhndl , "<title>$modname for $name</title>"."\n");
	fwrite($xmlhndl , "<style>body{font-size:12px;} thead{font-weight:bold;} td{font-size:11px;padding:5px;min-width:50px} .title{min-width:250px;}</style>\n");
	fwrite($xmlhndl , "</head>"."\n");
	fwrite($xmlhndl , "<body>"."\n");
	fwrite($xmlhndl , "<h3>$modname for $name</h3>"."\n");
	fwrite($xmlhndl , "<table>");
	fwrite($xmlhndl , "<thead>");
	fwrite($xmlhndl , "<tr><td class=title>Name</td><td>Title</td><td>Description</td><td>Manufacturer</td><td>ROM</td><td>CRC32</td><td>MD5</td><td>SHA1</td></tr>");	
	fwrite($xmlhndl , "</thead>");
        
}

function writeout_contents($items) 
{

	global $xmlhndl, $outurl;
        
	foreach ($items AS $item)
	{
		$title = $item['value'];
		// Replace Spaces with +
		$item = preg_replace('/\s/','+',$item);
		// Replace & with %26
		$item = preg_replace('/&/','%26',$item);
		fwrite($xmlhndl , "<tr><td>" . $title . "\n");
		if ( $item['value'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['value'].chr(34)." target=".chr(34)._blank.chr(34).">title</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['description'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['description'].chr(34)." target=".chr(34)._blank.chr(34).">description</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['manufacturer'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['manufacturer'].chr(34)." target=".chr(34)._blank.chr(34).">manufacturer</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['rom'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['rom'].chr(34)." target=".chr(34)._blank.chr(34).">rom</a></a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['crc32'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['crc32'].chr(34)." target=".chr(34)._blank.chr(34).">crc32</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['md5'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['md5'].chr(34)." target=".chr(34)._blank.chr(34).">md5</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		if ( $item['sha1'] ) { fwrite($xmlhndl , "<td><a href=".chr(34).$outurl.$item['sha1'].chr(34)." target=".chr(34)._blank.chr(34).">sha1</a>\n"); } else { fwrite($xmlhndl , "<td>none\n"); }
		fwrite($xmlhndl , "</td></tr>\n");
	}
        
}

function writeout_footer()
{
	global $outfile;
	global $xmlhndl;

	fwrite($xmlhndl , "</table>");
	fwrite($xmlhndl , "</body>"."\n");
	fwrite($xmlhndl , "</html>"."\n");
    create_link($outfile);
}

?>
