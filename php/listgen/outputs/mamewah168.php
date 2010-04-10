<?php

### MAMEWAH LST/INI output module

# Can take a while to process the larger files (full set in NESHave.txt etc)
ini_set("memory_limit","64M");
ini_set("max_execution_time","240");

global $modname, $outfile;

$modname = 'MameWah 1.68 Filtered Lists';
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

			unset($japlist,$mulist,$eurlist,$usalist,$protolist,$betalist,$pdlist,$unlist,$hacklist,$misclist,$vgdlist,$trenglist,$trothlist);
						
			/* Rom Types
			 * 
			 * [!]		Verified Good Dump
			 * [b		Bad Dump
			 * [f		Fixed
			 * [h		Hacked
			 * (Hack)	Hacked
			 * [o		Overdump
			 * [a		Alternate Dump
			 * (Unl)	Unlicensed
			 * (PD)		Public Domain
			 * (Beta)	Beta
			 * [T		Translation
			 * [t		Trained
			 * (Proto	Prototypes
			 * 
			 */
			
			$item = $item['value'];
			
			if (preg_match('/\[!\]/',$item)) {
				$status = "Verified Good Dump";
				$vgdlist = "1";
			}

			if (preg_match('/\[b/',$item)) {
				$status = "Bad Dump";
				$misclist = "1";
			}
			
			if (preg_match('/\[t/',$item)) {
				$status = "Trained";
				$misclist = "1";
			}
			
			if (preg_match('/\[f/',$item)) {
				$status = "Fixed";
				$misclist = "1";
			}

			if (preg_match('/\[h/',$item)) {
				$status = "Hacked";
				$hacklist = "1";
			}
						
			if (preg_match('/\Hack/',$item)) {
				$status = "Hacked";
				$hacklist = "1";
			}		

			if (preg_match('/\[o/',$item)) {
				 $status = "Overdump";
				 $misclist = "1";
			}

			if (preg_match('/\[a/',$item)) {
				 $status = "Alternate Dump";
				 $misclist = "1";
			}		

			if (preg_match('/\(Unl/',$item)) {
				 $status = "Unlicensed";
				 $unlist = "1";
			}

			if (preg_match('/\(PD/',$item)) {
				 $status = "Public Domain";
				 $pdlist = "1";
			}			 

			if (preg_match('/\Beta/i',$item)) {
				 $status = "Beta";
				 $prelist = "1";
			}	
		
			if (preg_match('/\(Proto/',$item)) {
				 $status = "Prototype";
				 $prelist = "1";
			}

			if (preg_match('/\(Alpha/',$item)) {
				 $status = "Alpha";
				 $prelist = "1";
			}
			
			/* Region/Language
			 *  
			 * (G)		German
			 * (U)		USA
			 * (S)		Spanish
			 * (B)		Non-USA
			 * (E)		Europe
			 * (F)		France
			 * (A)		Australia
			 * (UE)		English
			 * (J)		Japan
			 * (W)		World
			 * (JUE)	World
			 * 
			*/

			# English Lang Codes

			if (preg_match('/\(U\)/',$item)) {
				 $lang = "USA";
				 $usalist = "1";
			}
			
			if (preg_match('/\(E\)/',$item)) {
				 $lang = "Europe";
				 $eurlist = "1";
			}

			if (preg_match('/\\(UE\\)/',$item)) {
				 $lang = "Multi-Region (English)";
				 $mulist = "1";
			}

			if (preg_match('/\(JU/',$item)) {
				 $lang = "Multi-Region (English)";
				 $mulist = "1";
			}

			if (preg_match('/\(W\)/',$item)) {
				 $lang = "World";
				 $mulist = "1";
			}

			if (preg_match('/\(A\)/',$item)) {
				 $lang = "Australia";
				 $mulist = "1";	
			}

			# Non-English Lang Codes

			if (preg_match('/\(J\)/',$item)) {
				 $lang = "Japan";
				 $japlist = "1";
			}

			if (preg_match('/\(S\)/',$item)) {
				 $lang = "Spanish";
				 $misclist = "1";
			}
						
			if (preg_match('/\(B\)/',$item)) {
				 $lang = "Brazil";
				 $misclist = "1";
			}

			if (preg_match('/\(F\)/',$item)) {
				 $lang = "France";
				 $eurlist = "1";
			}

			if (preg_match('/\(G\)/',$item)) {
				 $lang = "German";
				 $eurlist = "1";
			}

			/*	Translations
			 * 
			 */

			if (preg_match('/\[T-/',$item)) {
				 $trans = "Translation Other (Old Version)";
				 unset($trenglist);
				 $trothlist = "1";
			}
			
			if (preg_match('/\[T+/',$item)) {
				 $trans = "Translation Other (Latest Version)";
				 unset($trenglist);
				 $trothlist = "1";
			}

			if (preg_match('/\[T-Eng/i',$item)) {
				 $trans = "Translation English (Old Version)";
				 $trenglist = "1";
			}
			
			if (preg_match('/\[T+Eng/i',$item)) {
				 $trans = "Translation English (Latest Version)";
				 $trenglist = "1";
			}
	

			/* Standard Mamewah Lists
			 *  0	All Games
			 *  1	Verified Good Dumps
			 *  2	USA
			 * 	3	Japan
			 *  4	Europe
			 *  5	Multi-Region (English)
			 *  6	Unlicensed
			 *  7	Public Domain
			 *  8	Pre-ReleaseW
			 *  9	Miscellaneous
			 * 10	Hacks
			 * 
			 */	
			
			write_lists("0","All Games","all",$outfile,$item,$lang,$trans,$status);
			
			if(!empty($vgdlist)) 
			{ 
				write_lists("1","Verified Good Dumps","vgd",$outfile,$item,$lang,$trans,$status);
			}
			
			if(!empty($usalist)) 
			{ 
				write_lists("2","USA","usa",$outfile,$item,$lang,$trans,$status);
			}

			if(!empty($japlist)) 
			{ 
				write_lists("3","Japan","jap",$outfile,$item,$lang,$trans,$status);				
			}

			if(!empty($eurlist)) 
			{ 
				write_lists("4","Europe","eur",$outfile,$item,$lang,$trans,$status);
			}
			
			if(!empty($mulist)) 
			{ 
				write_lists("5","Multi-Region (English)","mu",$outfile,$item,$lang,$trans,$status);				
			}
					
			if(!empty($unlist)) 
			{ 
				write_lists("6","Unlicensed","un",$outfile,$item,$lang,$trans,$status);
			}

			if(!empty($pdlist)) 
			{ 
				write_lists("7","Public Domain","pd",$outfile,$item,$lang,$trans,$status);
			}

			if(!empty($prelist)) 
			{ 
				write_lists("8","Pre-Release","pre",$outfile,$item,$lang,$trans,$status);
			}

			if(!empty($misclist))  
			{ 
				write_lists("9","Miscellaneous","misc",$outfile,$item,$lang,$trans,$status);
			}
						
			if(!empty($hacklist)) 
			{ 
				write_lists("10","Hacks","hack",$outfile,$item,$lang,$trans,$status);
			}

			if(!empty($trenglist)) 
			{ 
				write_lists("11","Translations (English)","treng",$outfile,$item,$lang,$trans,$status);		
			}		
			
			if(!empty($trothlist)) 
			{ 
				write_lists("12","Translations (Other)","troth",$outfile,$item,$lang,$trans,$status);				
			}
			
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
	
	/* Will build an array of filename for later processing
	 * added to be used for the zipping process
	 * 
	 */
	array_push($ziplst,$outfile."-".$list.".lst");
	array_push($ziplst,$outfile."-".$list.".ini");
	
}

function writeout_footer() {	

	global $outfile;
	global $ziplst;

	mwzipfiles($outfile,$ziplst);
	
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

	/* Mamewah 1.68+ Filtered lst Format
	 * 
	 * Filename (Less Extension)
	 * Description
	 * Year
	 * Manufacturer
	 * Unknown
	 * Unknown
	 * Graphics
	 * Orientation
	 * Controls
	 * Status
	 * Colours
	 * Sound
	 * Unknown
	 */

	fwrite($xmlhndl , $item.$newline);
	fwrite($xmlhndl , $item.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $lang.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $status.$newline);
	fwrite($xmlhndl , $trans.$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , $newline);
	
	@fclose($xmlhndl);
	
}

function write_mwini($outfile,$name) {

	global $newline;
	global $csIDstr;
	
	/* Writes the Mamewah 1.68 ini file for the lst
	 * 
	 * outfile	Output Filename
	 * name		List Title
	 * 
	 * 
	 */

	$xmlhndl = @fopen($outfile,"w");

	/*
	 * ### mame-0.ini (mamewah v1.68) ###
	 * list_title                                All Games
	 * 
	 * ### Games List Settings ###
	 * cycle_list                                1
	 * 
	 * ### Execution Settings ###
	 * pre_emulator_app_commandlines   
	 * emulator_commandline  
	 * post_emulator_app_commandlines    
	 * 
	 * ### Settings used by MAMEWAH ###
	 * current_game                              30
	 * 
	 */

	cleanSessionID($outfile);	
	fwrite($xmlhndl , "### ".$csIDstr." (mamewah v1.68) ###".$newline);
	fwrite($xmlhndl , $newline);
	fwrite($xmlhndl , "list_title                                ".$name.$newline);
	fwrite($xmlhndl ,  $newline);
	fwrite($xmlhndl , "### Games List Settings ###".$newline);
	fwrite($xmlhndl , "cycle_list                                1".$newline);
	fwrite($xmlhndl ,  $newline);
	fwrite($xmlhndl , "### Execution Settings ###".$newline);
	fwrite($xmlhndl , "pre_emulator_app_commandlines".$newline);
	fwrite($xmlhndl , "emulator_commandline".$newline);
	fwrite($xmlhndl , "post_emulator_app_commandlines".$newline);
	fwrite($xmlhndl ,  $newline);
	fwrite($xmlhndl , "### Settings used by MAMEWAH ###".$newline);
	fwrite($xmlhndl , "current_game                              1".$newline);
	
	@fclose($xmlhndl);
				   
}

?>
