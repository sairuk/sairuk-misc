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
## $items['build'] is passed to this as the CRC
	global $xmlhndl;
        
        foreach ($items AS $item)
        {
        	$value = preg_replace('/\./','',$item['value']);
            fwrite($xmlhndl , "ren ".chr(34).$item['crc32'].".*".chr(34)." ".chr(34).$value.".*".chr(34).""."\r\n");
        }
        
}

function writeout_footer()
{
	
	global $outfile;
	
    create_link($outfile);
}

?>
