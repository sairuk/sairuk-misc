<?php

### FAKE FILES output module
#
# Create a set of Fake Files for Testing

global $modname, $outfile;

$modname = 'fakefiles';
$outfile = "$name.tmp";

function writeout_header()
{
	global $xmlhndl;
		fwrite($xmlhndl, "FAKE FILE\n");
}

function writeout_contents($items) 
{
	
	global $rompath;

        foreach ($items AS $item)
        {
        		$fakefile = $rompath.$item['value'].".zip";
        		$xmlhndl = @fopen($fakefile,"w") or die("Could not open $fakefile");
				fwrite($xmlhndl, $item['value']."\n");
				fclose($xmlhndl);
        }
        
}

function writeout_footer()
{
	global $rompath;
	echo "Files Created in $rompath";
}

?>
