<?php

### MSDOS BATCH output module

global $modname, $outfile;

$modname = 'MSDOS batch';
$outfile = "$name.bat";

function writeout_header()
{
	global $xmlhndl;
	fwrite($xmlhndl , "@echo off"."\r\n");
        
}

function writeout_contents($items) 
{
	global $xmlhndl;
        
        foreach ($items AS $item)
        {
        	$num = preg_replace('/ -.*/','',$item['value']);
			$title = preg_replace('/^\d{4} - /','',$item['value']);
        	$value = preg_replace('/\./','',$title);
			fwrite($xmlhndl , "ren ".chr(34).$num.".*".chr(34)." ".chr(34).$value.".*".chr(34).""."\r\n");
        }
        
}

function writeout_footer()
{
	
	global $outfile;
	
    create_link($outfile);
}

?>
