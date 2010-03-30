<?php

### MAMEWAH LST/INI output module

global $modname, $outfile;

$modname = 'MameWah &lt;1.67 Filtered Lists';
$outfile = $name;

function writeout_header() {

# setup array for zipping
global $ziplst;
global $zipini;

$ziplst = array();
$zipini = array();

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
	$ziplst["list$arrname.lst"] = $outfile."-".$list.".lst";
	$zipini["list$arrname.ini"] = $outfile."-".$list.".ini";
	
}

function writeout_footer() {	

	global $outfile;
	global $ziplst;
	global $zipini;

	mwzipfiles($outfile,$ziplst);
	mwzipfiles($outfile,$zipini);
	
	create_link($outfile.".zip");
	unlink($outfile);
}

function write_mwlst($outfile,$item,$lang,$trans,$status) {

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

	fwrite($xmlhndl , $item."\n");
	fwrite($xmlhndl , $item."\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , $lang."\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , $trans."\n");
	fwrite($xmlhndl , $status."\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "\n");
	
	@fclose($xmlhndl);
	
}

function write_mwini($outfile,$name) {

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
	
	fwrite($xmlhndl , "### ".$outfile." ###"."\n");
	fwrite($xmlhndl , "\n");
	fwrite($xmlhndl , "list_title ".$name."\n");
	fwrite($xmlhndl ,  "\n");
	fwrite($xmlhndl , "### Games List Settings ###"."\n");
	fwrite($xmlhndl , "cycle_list 1"."\n");
	fwrite($xmlhndl , "list_type normal"."\n");
	fwrite($xmlhndl , "display_clone_info 0"."\n");
	fwrite($xmlhndl , "max_favorites 0"."\n");
	fwrite($xmlhndl ,  "\n");
	fwrite($xmlhndl , "### Settings used by MAMEWAH ###"."\n");
	fwrite($xmlhndl , "current_game 1"."\n");
	
	@fclose($xmlhndl);
				   
}

function mwzipfiles($outfile,$names) {

        /* ZIP Function specifically for MameWah
         *
         * Creates ini/ and files/ directories copies *.lst and *.ini to
         * the appropriate directories
         *
         * Moves Files to ZIP
         *
         */

        $zip = new ZipArchive();
        $filename = "./$outfile.zip";

        if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
                exit("cannot open <$filename>\n");
        }

        $zip->addEmptyDir('ini');
        $zip->addEmptyDir('files');

        foreach ($names AS $name) {


        if ( !preg_match('/zip$/',$name)) {

                if ( preg_match('/ini$/',$name)) {
                        $zip->addFile($thisdir . $name, "ini/".$name);
                        unlink($name);
                }
                if ( preg_match('/lst$/',$name)) {
                        $zip->addFile($thisdir . $name, "files/".$name);
                        unlink($name);
                }

        }


        }

        $zip->close();

}

?>
