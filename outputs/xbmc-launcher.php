<?php

### XBMC-Launcher output module
#
# Builds roms list for XBMC-Launcher, needs to be manually added to launchers.xml

global $modname, $outfile;

$modname = 'XBMC-Launcher';
$outfile = "xbmc-launcher_roms.xml";   
		
function writeout_header()
{

	global $xmlhndl;
    fwrite($xmlhndl , '<roms>'."\n");

}

function writeout_contents($items) 
{

	global $rompath;
	global $xmlhndl;

   
        foreach ($items AS $item)
        {

            fwrite($xmlhndl ,'<rom>'."\n");						
            fwrite($xmlhndl ,'<name>'.$item['description'].'</name>'."\n");
            fwrite($xmlhndl ,'	<filename>'.$rompath.$item['value'].$item['ext'].'</filename>'."\n");
            fwrite($xmlhndl ,'<thumb>'.$item['value'].'.png</thumb>'."\n");
            fwrite($xmlhndl ,'</rom>'."\n");	
        }

}

function writeout_footer()
{

	global $outfile;
	global $xmlhndl;

    fwrite($xmlhndl ,'</roms>'."\n");
    create_link($outfile);
    

}

?>
