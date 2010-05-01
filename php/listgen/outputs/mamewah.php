<?php

### MAMEWAH LST/INI output module

# Can take a while to process the larger files (full set in NESHave.txt etc)
ini_set("memory_limit","64M");
ini_set("max_execution_time","240");

global $modname, $outfile;

$modname = 'MameWah &lt;1.67 Filtered Lists';
$outfile = $name;

function writeout_header() {

# setup array for zipping
global $ziplst;
global $newline;

$ziplst = array();
$newline = "\r\n";

}

function writeout_contents($items) {
	/* Processes the filename looking for known matches as listed,
	 * Executes write to predetermined lists as required after processing
	 * all information from the filename
	 *
	 * items	Array of Items from file
	 * outfile	Output filename
	 * 
	 */
	
	global $outfile;
	       
        foreach ($items AS $item) {

			include(DOCROOT."/inputs/good-nointro.php");
			
        	write_lists("0","All Games","all",$outfile,$item,$lang,$trans,$dumpstat);
			if(!empty($dumpstat)) {	write_lists($dumpnum,"$dumpstat","ds",$outfile,$item,$langlist,$translist,$dumpstat); }
			else if(!empty($langlist)) { write_lists($langnum,$langlist,"ll",$outfile,$item,$langlist,$translist,$dumpstat); }			
			else if(!empty($dumptype)) { write_lists($typenum,"$dumptype","dt",$outfile,$item,$langlist,$translist,$dumpstat); }
			else if(!empty($dumpfix))  { write_lists($fixnum,$dumpfix,"df",$outfile,$item,$langlist,$translist,$dumpstat); }
			else if(!empty($translist)) { write_lists($transnum,$translist,"tl",$outfile,$item,$langlist,$translist,$dumpstat); }
			else {  }					
			
        }
		       
}

function write_lists($list,$title,$arrname,$outfile,$item,$lang,$trans,$status) {

	global $ziplst;
	global $zipini;
	
	/* Executes the functions for writing the lst/ini from criteria passed to function
	 * 
	 * list		List Number
	 * title	List Title
	 * arrname	Array used for the zip function
	 * outfile	Output Filename
	 * item		Item to add
	 * lang		Language determined from regex match
	 * trans	Translation information determined from regex match
	 * status	Dump status determined from regex match
	 * 
	 */
	
	write_mwlst($outfile."-".$list.".lst",$item,$lang,$trans,$status);
	write_mwini($outfile."-".$list.".ini",$title);
	
	/* Will build an array of filenames for later processing
	 * added to be used for the zipping process
	 * 
	 */
	array_push($ziplst,$outfile."-".$list.".lst");
	array_push($ziplst,$outfile."-".$list.".ini");
	
}

function writeout_footer() {	

	global $outfile;
	global $ziplst;
	
	mwzipfiles($outfile,$ziplst,"167");
	
	create_link($outfile.".zip");
	unlink($outfile);
}

function write_mwlst($outfile,$item,$lang,$trans,$status) {

	global $newline;
	
	/* Appends to the Mamewah lst file
	 * 
	 * outfile	Output Filename
	 * item		Item to add
	 * lang		Language determined from regex match
	 * trans	Translation information determined from regex match
	 * status	Dump status determined from regex match
	 * 
	 */

	$xmlhndl = @fopen($outfile,"a");

	/* Mamewah Filtered lst Format
	 * 
	 * Filename (No Extension)
	 * Filename (No Extension)
	 * Unknown/Blank
	 * Language
	 * Unknown/Blank
	 * Unknown/Blank
	 * Unknown/Blank
	 * Translation Information
	 * Dump Status
	 * Unknown/Blank
	 * Unknown/Blank
	 * Unknown/Blank
	 * Unknown/Blank
	 * 
	 */

	fwrite($xmlhndl , $item.$newline);
	fwrite($xmlhndl , $item.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $lang.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $trans.$newline);
	fwrite($xmlhndl , $status.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	
	@fclose($xmlhndl);
	
}

function write_mwini($outfile,$name) {

	global $csIDstr;
	global $newline;
	
	/* Writes the Mamewah ini file for the lst
	 * 
	 * outfile	Output Filename
	 * name		List Title
	 * 
	 * 
	 */

	$xmlhndl = @fopen($outfile,"w");

	/*
	 * ### sfc-11.ini ###
	 * 
	 * list_title Hacks
	 * 
	 * ### Games List Settings ###
	 * cycle_list 1
	 * list_type normal
	 * display_clone_info 0
	 * max_favorites 0
	 * 
	 * ### Settings used by MAMEWAH ###
	 * current_game 1
	 * 
	 */
	
	cleanSessionID($outfile);	
	fwrite($xmlhndl , "### ".$csIDstr." ###".$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , "list_title ".$name.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , "### Games List Settings ###".$newline);
	fwrite($xmlhndl , "cycle_list 1".$newline);
	fwrite($xmlhndl , "list_type normal".$newline);
	fwrite($xmlhndl , "display_clone_info 0".$newline);
	fwrite($xmlhndl , "max_favorites 0".$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , "### Settings used by MAMEWAH ###".$newline);
	fwrite($xmlhndl , "current_game 1".$newline);
	
	@fclose($xmlhndl);
				   
}


?>
