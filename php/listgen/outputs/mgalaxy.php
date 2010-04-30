<?php

### mGalaxy db output module
#
# Builds a mGalaxy mg_mamedb.xml

global $modname, $outfile;

$modname = 'mGalaxy Database';
$outfile = "mg_mamedb.xml";   
		
function writeout_header()
{

	global $xmlhndl, $wrtonce;
	
	$wrtonce = "0";
    fwrite($xmlhndl ,'<?xml version="1.0"?>'."\n");

}

function writeout_contents($items) 
{	
	global $xmlhndl,$wrtonce;

        foreach ($items AS $item)
        {

	       	if ( $wrtonce == "0" ) {
			  	fwrite($xmlhndl ,'<mame build="'.$item['build'].'">'."\n");
			  	$wrtonce = "1";
			}
        	
			if ($item['cloneof'] != "") {  
				$gameline = '<game name="'.$item['value'].'" cloneof="'.$item['cloneof'].'">';
			} else {
				$gameline = '<game name="'.$item['value'].'">';
			}
			
            fwrite($xmlhndl , $gameline."\n");
            fwrite($xmlhndl ,'	<description>'.$item['description'].'</description>'."\n");
            fwrite($xmlhndl ,'</game>'."\n");
        }

}

function writeout_footer()
{

	global $name;
	global $outfile;
	global $xmlhndl;

    fwrite($xmlhndl ,'</mame>'."\n");
    create_link($outfile);
    

}

?>
