<?php

### MSDOS BATCH output module

global $modname, $outfile;

$modname = 'MSDOS batch';
$outfile = "$name.bat";

function writeout_header()
{
	global $xmlhndl;
	fwrite($xmlhndl , "@echo off"."\r\n");
	fwrite($xmlhndl , "md _goodfill"."\r\n");
        
}

function writeout_contents($items) 
{
	global $xmlhndl;
        foreach ($items AS $item)
        {
            fwrite($xmlhndl , "copy ".chr(34).$item['value'].".*".chr(34)." _goodfill"."\r\n");
        }       
}

function writeout_footer()
{
	global $outfile;
    create_link($outfile);
}

?>
