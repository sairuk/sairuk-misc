<?php

### CATVER output module
#
# Create a CatVer file from input. refer http://www.mameworld.info/catver

global $modname, $outfile;

$modname = 'catver';
$outfile = "$name.ini";

function writeout_header()
{
	global $xmlhndl;
	fwrite($xmlhndl , ";;; CatVer (rev. 1) / 11-Sep-05 / $name / http://www.mameau.com/listgen ;;\n\n");
	fwrite($xmlhndl , "[Category]\n");
}

function writeout_contents($items) 
{

	global $xmlhndl;
	$category = array();
        
        foreach ($items AS $item)
        {
        	include(DOCROOT."/inputs/good-nointro.php");
			if(!empty($dumpstat)) {	array_push($category, "Status / ".$dumpstat); }
			if(!empty($langlist)) { array_push($category, "Region / ".$langlist); }			
			if(!empty($dumptype)) { array_push($category, "Type / ".$dumptype); }
			if(!empty($dumpfix))  { array_push($category, "Fixed / ".$dumpfix); }
			if(!empty($translist)) { array_push($category, "Translation / ".$translist); }

			foreach ( $category as $cat ) {
				fwrite($xmlhndl , $item."=".$cat."\n");
			}

        }
        
}

function writeout_footer()
{
	global $outfile;
    create_link($outfile);
}

?>
