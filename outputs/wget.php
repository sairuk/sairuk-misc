<?php

### WGET output module
#
# A text list with extension appended, used with wget -i

global $modname, $outfile;

$modname = 'wget queue';
$outfile = "$name.wget";

function writeout_header()
{
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
        foreach ($items AS $item)
        {
            fwrite($xmlhndl , $item['value'].$item['ext']."\n");
        }
        
}

function writeout_footer()
{
	
	global $outfile;
    create_link($outfile);
}

?>
