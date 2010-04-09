<?php

### BASH script output module

global $modname, $outfile;

$modname = 'Bash Script';
$outfile = "$name.sh"; 

function writeout_header()
{
	global $xmlhndl;

	fwrite($xmlhndl , "#!/bin/bash"."\n");
	fwrite($xmlhndl , "mkdir _goodfill"."\n");
        
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
        foreach ($items AS $item)
        {
            fwrite($xmlhndl , "cp ".chr(34).$item['value'].".*".chr(34)." ./_goodfill/"."\n");
        }
        
}

function writeout_footer()
{
	global $outfile;
    create_link($outfile);
}

?>
