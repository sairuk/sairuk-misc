<?php

### TEST output module

global $modname, $outfile;

$modname = 'TEST';
$outfile = "$name.html";

function writeout_header()
{   
	global $xmlhndl;
	fwrite($xmlhndl , "
	<html>
	<head>
	<style>
	body, td, th { font-size:10px;}
	table, td, th { border-collapse:collapse;border:1px solid black; }
	td { padding:5px; }
	</style>
	</head>
	<body>
	<table>\n
	<tr>
	<th>Name</th>
	<th>Status</th>
	<th>Language</th>
	<th>Translation</th>
	<th>Fix</th>
	<th>Type</th>
	</tr>\n
	");
}

function writeout_contents($items) 
{
	global $xmlhndl;
	foreach ( $items as $item ) {
		include(DOCROOT."/inputs/good-nointro.php");
		fwrite($xmlhndl , "
		<tr>
		<td>$item</td>
		<td>$dumpstat</td>
		<td>$langlist</td>
		<td>$translist</td>
		<td>$dumpfix</td>
		<td>$dumptype</td>
		</tr>\n"
		);
	}
}

function writeout_footer()
{
	global $outfile, $xmlhndl;;
	fwrite($xmlhndl , "</table>\n");
    create_link($outfile);
}

?>
