<?php

/*
 * General Function, used to process all files
 * once file is identified
 * 
 */
function genFunction($inType,$skiplines,$fTypeTitle) {
	
	global $fixfile, $name, $outfile, $ext, $xmlhndl, $csIDstr, $sessionID;
	
    $i = "0";
	cleanSessionID($outfile);
	$name = $csIDstr;
	
    if (file_exists($fixfile) && is_readable ($fixfile)) {

    	$outfile = $sessionID .'/'. $outfile;
    	
    	print $fTypeTitle."<br />";
    	
    	# File write header, open file for writing
		@unlink($outfile);
		$xmlhndl = @fopen($outfile,"w");
        writeout_header();

        $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ( $lines as $line ) {
			$i++;
		$xmlhndl = @fopen($outfile,"a");			
        	# Custom Items Start Here
        	switch ($inType) {
        		# Cowering's Goodtools Have/Miss Text Format
				case goodtxt:
					if ( $i > $skiplines ) {
	          			build_itemArray($line,"Current");
					} 
          		break;
        		# CLRMame Pro XML Format
          		case cmproxml:
					if (( $i > $skiplines ) && ( substr($line,2,4) == "game")) {	
						# Pull out the archive names
						preg_match( "/\"(.*?)\"/", $line, $gamename );
						$line = preg_replace( "/\"/",'',$gamename[0] );
	          			build_itemArray($line,"Current");
					} 
          		break;
          		# MAME XML Formal
				case mamexml:
          			read_mamexml($skiplines);
          		break;
				default:
           		echo "Nothing to do here either jim";
        	}
        	
        }
		
		# File write footer, open file for append
		$xmlhndl = @fopen($outfile,"a");		
        writeout_footer();
     } 

     if (file_exists($fixfile)) {
		unlink($fixfile);
	}
}

function build_itemArray($line,$build) {
	
		$line = chop($line);
		$items = array();
		$items [] = array(
		'type' => '0',
		'condition' => '1',
		'value' => $line,
		'cloneof' => $line,
		'romof' => $line,
		'ext' => $ext,
		'description' => $line,
		'build' => $build
		);
		# File write contents, open file for append		
		writeout_contents($items);
}

/*
 * Processes MAME XML files produced
 * with 'mame.exe -lx' command
 * 
 * REQUIRES AN OBSCENE AMOUNT OF MEMORY FOR A FULL XML
 */
function read_mamexml($skiplines) 
{
	

	if (( $i > $skiplines ) && ( substr($line,1,4) == "mame"))
	{
		preg_match( "/\"(.*?)\"/", $line, $gamename );
		$build = preg_replace( "/\"/",'',$gamename[0] );
	}
					
	if (( $i > $skiplines ) && ( substr($line,2,4) == "game"))
	{
		// Pull out the archive names
		preg_match( "/name\=\"(.*?)\"/", $line, $gamename );
		$game = preg_replace( "/name\=|\"/",'',$gamename[0] );
					
		preg_match( "/cloneof\=\"(.*?)\"/", $line, $gamename );
		$cloneof = preg_replace( "/cloneof\=|\"/",'',$gamename[0] );
					
		preg_match( "/romof\=\"(.*?)\"/", $line, $gamename );
		$romof = preg_replace( "/romof\=|\"/",'',$gamename[0] );
									
	}
					
	if (( $i > $skiplines ) && ( substr($line,3,11) == "description"))
	{
		// Pull out the archive names
		preg_match( "/\>(.*?)\</", $line, $gamename );
		$description = preg_replace( "/\<|\>/",'',$gamename[0] );
	}					
					
	if (isset($build) && isset($game) && isset($description)) {
          build_itemArray($line,$build);
	}
}

/*
 * Process all files after upload
 * Checks type of file then calls genFunction()
 */
function process_upload($tmpfile) {
	
	global $fixfile, $sessionID;
	
    $uploaddir = dirname("index.php") . '/' . $sessionID . '/';

    if (!is_dir($uploaddir)) {
    	mkdir($uploaddir);
    	chmod($uploaddir, 0777);
    }
    
    $uploadfname = basename($_FILES['fixfile']['name']);
    $uploadfile = $uploaddir . $uploadfname;
    if (move_uploaded_file($_FILES['fixfile']['tmp_name'], $uploadfile)) {
        $fixfile = $uploaddir . $uploadfname;
		$i = 0;
        $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ( $lines as $line ) {
            $i++;
			if (($i == "1") && (preg_match('/You are Missing|You Have/i',$line))) {
				# Valid GoodTools File
				genFunction("goodtxt","2","Recognised GoodTools style Miss/Have Text");
				exit;
			}
			if (($i == "2") && (preg_match('/DOCTYPE mame/',$line)))	{
				# Valid MAME XML
				genFunction("mamexml","85","Recognised MAME (XML)");
				exit;
			} 
			if (($i == "7") && (preg_match('/FIXDAT/',$line)))	{
				# Valid CMPRO Fixdat
				genFunction("cmproxml","16","Recognised CMPro Fixdat (XML)");				
				exit;
			} 
			if ($i >= "9") {
				# File Not Recognised
				echo "ERROR: I do not recognise this file format<br />";
				unlink($fixfile);
				exit;
			}
		}
	}
    
}

/*
 * create_link()
 * 
 * Creates a hyperlink to file if it exists
 */
function create_link($zipfile) {

	global $csIDstr;
	
	if (file_exists($zipfile)) {
		cleanSessionID($zipfile);
		$hreftitle = $csIDstr;
		echo (' 
				<tr>
				<td>
					Results: <a href="'.$zipfile.'" target="_blank">'.$hreftitle.'</a><br /> 
				</td>
				 </tr>
			 ');
        }
}

function switchOutput($pstQueue) {
	
	global $fixfile, $name;
	
    $name = substr($fixfile,0,strlen($fixfile)-4);

   	# Outputs
   	switch ($pstQueue) { 
        case filezilla:
          require('outputs/filezilla.php'); 
          break;
        case wget:
          require('outputs/wget.php');
          break;
        case msbat:
          require('outputs/msbat.php');
		  break; 
        case bash:
          require('outputs/bash.php');
          break;
        case google:
          require('outputs/html_google.php');
		  break; 
        case binsearch:
          require('outputs/html_binsearch.php');
		  break; 
        case easynews:
          require('outputs/html_easynews.php');
		  break; 
        case htmlall:
          require('outputs/html_all.php');
		  break; 
        case mamewah:
          require('outputs/mamewah.php');
		  break; 
        case mamewah168:
          require('outputs/mamewah168.php');
		  break;
        case mGalaxy:
          require('outputs/mgalaxy.php');
          break; 
		case xbmc-launcher:
          require('outputs/xbmc-launcher.php');
          break; 
        default:
          echo "Nothing to do here either jim";
    	}

}

function cleanSessionID($string) {
	global $sessionID, $csIDstr;
	$csIDstr = str_replace($sessionID . '/','',$string);
}


/** Returns revision number <--- Borrowed from google ;)  */
function getSCID() {
    $svnid = '$Rev$';
    $scid = substr($svnid, 6);
    return intval(substr($scid, 0, strlen($scid) - 2));
}


?>
