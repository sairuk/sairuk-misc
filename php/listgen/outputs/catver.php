<?php

### CATVER output module
#
# Create a CatVer file from input. refer http://www.mameworld.info/catver

global $modname,$sessionID,$regionfile,$statusfile,$typefile;

$modname = 'catver';
$regionfile = UPLOADPATH .'/'. $sessionID .'/'. $name."cat_region.ini";
$statusfile = UPLOADPATH .'/'. $sessionID .'/'. $name."cat_status.ini";
$typefile = UPLOADPATH .'/'. $sessionID .'/'. $name."cat_type.ini";

function writeout_header()
{
	global $regionfile,$statusfile,$typefile,$regionhndl,$statushndl,$typehndl;

	$regionhndl = @fopen($regionfile,"w");
	$statushndl = @fopen($statusfile,"w");
	$typehndl = @fopen($typefile,"w");


	fwrite($regionhndl , ";;; CatVer (rev. 1) / 11-Sep-05 / $name / http://www.mameau.com/listgen ;;\n\n");
	fwrite($regionhndl , "[Category]\n");
        fwrite($statushndl , ";;; CatVer (rev. 1) / 11-Sep-05 / $name / http://www.mameau.com/listgen ;;\n\n");
        fwrite($statushndl , "[Category]\n");
        fwrite($typehndl , ";;; CatVer (rev. 1) / 11-Sep-05 / $name / http://www.mameau.com/listgen ;;\n\n");
        fwrite($typehndl , "[Category]\n");
}

function writeout_contents($items) 
{

	global $regionhndl,$statushndl,$typehndl;
	$catregion = array();
	$catstatus = array();
	$cattype = array();
        
        foreach ($items AS $item)
        {
        	include(DOCROOT."/inputs/good-nointro.php");
			if(!empty($dumpstat)) {	array_push($catstatus, "Status / ".$dumpstat); }
			if(!empty($langlist)) { array_push($catregion, "Region / ".$langlist); }			
			if(!empty($dumptype)) { array_push($cattype, "Type / ".$dumptype); }
			if(!empty($dumpfix))  { array_push($cattype, "Fixed / ".$dumpfix); }
			if(!empty($translist)) { array_push($cattype, "Translation / ".$translist); }

			foreach ( $catstatus as $cat ) {
				fwrite($statushndl , $item."=".$cat."\n");
			}

			foreach ( $catregion as $cat ) {
                                fwrite($regionhndl , $item."=".$cat."\n");
                        }

                        foreach ( $cattype as $cat ) {
                                fwrite($typehndl , $item."=".$cat."\n");
                        }
        }
}

function writeout_footer()
{
	global $regionfile,$statusfile,$typefile;
	create_link($regionfile);
	create_link($statusfile);
	create_link($typefile);
}

?>
