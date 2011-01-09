<?php

# Global Variables
global $modname, $fixfile, $ext, $name, $outfile, $xmlhndl, $rompath, $sessionID, $maxviewbytes;

# If page is reloaded from form with ext passed populate $ext 
if (isset($_POST['rompath'])) { $ext = ".".$_POST['ext']; #Set $ext to combo data
} else if ($_POST['ext'] == "custom" ) { $ext = ".".$_POST['custext']; #Set $ext to form data
} else { $ext = ""; } #Clear $ext 

# Initialise Session Information
session_start();$sessionID = session_id();


# If page is reloaded from form with rompath passed
# strip slashes from the path and print path to the 
# screen
if (isset($_POST['rompath'])) { $rompath = stripslashes($_POST['rompath']); }

/*
 * switchOutput
 * 
 * adds in output format data
 */
function switchOutput($pstQueue) {
	
	global $fixfile, $name, $modname, $outurl;
	
    $name = substr($fixfile,0,strlen($fixfile)-4);

    # For Debugging
    #$pstQueue = "test";
    
   	# Outputs
   	switch ($pstQueue) { 
        case filezilla:
          	require(DOCROOT.'/outputs/filezilla.php');break;
        case wget:
          	require(DOCROOT.'/outputs/wget.php');break;
        case msbat:
          	require(DOCROOT.'/outputs/msbat.php');break;
        case CRCmsbat:
          	require(DOCROOT.'/outputs/msbat-crc.php');break;
        case msbatnumbered:
          	require(DOCROOT.'/outputs/msbat-numbered.php');break;
		case bash:
          	require(DOCROOT.'/outputs/bash.php');break;
        case google:
        	$modname = 'Google Search';
          	$outurl = "http://www.google.com.au/search?q=";
          	require(DOCROOT.'/outputs/html_generic.php');break;
        case ebay:
        	$modname = 'Ebay Search';
        	$outurl = "http://shop.ebay.com/?_nkw=";
          	require(DOCROOT.'/outputs/html_generic.php');break;
        case ebayau:
        	$modname = "Ebay Australia Search";
        	$outurl = "http://shop.ebay.com.au/?_nkw=";
          	require(DOCROOT.'/outputs/html_generic.php');break;
        case binsearch:
        	$modname = "binsearch.info";
			$outurl = "http://www.binsearch.info/?q=";
          	require(DOCROOT.'/outputs/html_generic.php'); 
        case easynews:
        	$modname = "EasyNews Global Search";
        	$outurl = "http://members.easynews.com/global4/search.html?gps=";
          	require(DOCROOT.'/outputs/html_generic.php');break;
        case htmlall:
          	require(DOCROOT.'/outputs/html_all.php');break;
        case mamewah:
          	require(DOCROOT.'/outputs/mamewah.php');break;
        case mamewah168:
          	require(DOCROOT.'/outputs/mamewah168.php');break;
        case mGalaxy:
          	require(DOCROOT.'/outputs/mgalaxy.php');break; 
		case xbmclauncher:
          	require(DOCROOT.'/outputs/xbmc-launcher.php');break;
		case catver:
          	require(DOCROOT.'/outputs/catver.php');break;
		case fakefile:
          	require(DOCROOT.'/outputs/fakefiles.php');break;
		case test:
          	require(DOCROOT.'/outputs/test_mamewah168.php');break;
        default:
         	echo "Nothing to do here either jim";
    	}

}

/*
 * Process all files after upload
 * Checks type of file then calls genFunction()
 */
function process_upload($tmpfile) {
	
	global $fixfile, $sessionID;
    $uploaddir = UPLOADPATH .'/'. $sessionID .'/' ;

    # Make the users upload path if it doesnt exist
    if (!is_dir($uploaddir)) {mkdir($uploaddir);chmod($uploaddir, 0777);}
    
    # Set upload information and move uploaded file
    $uploadfname = basename($_FILES['fixfile']['name']);
    $uploadfile = $uploaddir . $uploadfname;
    if (move_uploaded_file($_FILES['fixfile']['tmp_name'], $uploadfile)) {
        $fixfile = $uploaddir . $uploadfname;
        
			# Read in 4 lines from file to establish type
			$handle = @fopen($fixfile, "r");
			if ($handle) {
				$HDR0 = fread($handle, 512);
				fclose($handle);
			}
			# Check if it is a binary file
    		if (substr_count($HDR0, "\x00") > 0 ) {
				echo "<b>You uploaded a binary file!</b><br /> Please only upload ascii files.";
				exit; 
			}			
			if ( preg_match('/You are Missing|You Have/i',$HDR0) ) { #Valid GoodTools File
				genFunction("goodtxt","2","Recognised GoodTools style Miss/Have Text");exit;
			} elseif ( preg_match('/clrmamepro \(/i',$HDR0 )) { #Valid CMPRO DAT File
				genFunction("cmprodat","2","Recognised CMPro DAT");exit;
			} elseif ( preg_match('/DOCTYPE mame/',$HDR0) )	{ #Valid MAME XML
				if ( ! ini_get('memory_limit') < 256 ) { 
				genFunction("mamexml","85","Recognised MAME XML");
				} else { echo "<b><i> - (Not Support on this Server)</i></b>";break; }
				$exit;
			} elseif ( preg_match('/CREDITS/',$HDR0) ) { #Valid Rommanger
				genFunction("rommanager","9","Recognised Rommanager Dat");exit;
			} elseif ( preg_match('/datafile/',$HDR0) )	{ #Valid CMPRO XML Fixdat
				genFunction("cmproxml","0","Recognised CMPro/RC3 XML");exit;
			} else { #File Not Recognised, treating as generic listing
				genFunction("generic","0","File Not Recognised, treating as generic listing");exit;
			}
 	}
}

/*
 * General Function, used to process all files
 * once file is identified
 * 
 */
function genFunction($inType,$skiplines,$fTypeTitle) {
	
	global $fixfile, $name, $outfile, $ext, $xmlhndl, $csIDstr, $sessionID;

	# Hash lengths, too lazy to count chars.
	$crclen = strlen("60c2b018");
	$md5len = strlen("7e0d3d20349b75cbfb52f19b206da4d0");
	$sha1len = strlen("58563e3ccb51bd9d8362aa17c23743bb5a593c3b");
	
	$build = "Current";	
    $i = "0";
    
    # Clean up the name of the file
	cleanSessionID($outfile);
	$name = $csIDstr;
	
    if (file_exists($fixfile) && is_readable ($fixfile)) {
    	$outfile = UPLOADPATH .'/'. $sessionID .'/'. $outfile;
    	print $fTypeTitle."<br />";
    	
    	# File write header, open file for writing
		@unlink($outfile);
		$xmlhndl = @fopen($outfile,"w");
        writeout_header();
        # File write content, open file for append
		$xmlhndl = @fopen($outfile,"a");
		
        #$lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$handle = @fopen($fixfile, "r");
		if ($handle) {
			while(!feof($handle)) {
			$line = fgets($handle);
	        $line = trim($line,"\r\n");
	        $i++;
		
        	# Custom Items Start Here
        	switch ($inType) {
        		# Cowering's Goodtools Have/Miss Text Format
				case goodtxt:
				# Get version number of set for $build
				if (preg_match('/ROMS \(V.*\)/',$line)) {
					$stringlen = strrpos($line,")");
					$stringpos = strpos($line,"(")+1;
					$build = substr("$line",$stringpos,$stringlen-$stringpos);
				}
					if ( $i > $skiplines ) {
          			build_itemArray("0","1",$line,"","",$ext,$line,"","","","","","",$build);
					} 
          		break;
        		# CLRMame Pro XML Format, full parse
          		case cmproxml:
          			$myline = ltrim($line);
          			if (( $i > $skiplines )) {
          				# Pull out the game names
          				if (preg_match("/^\<game/",$myline)) {
          				preg_match( "/\"(.*?)\"/", $line, $gamename );
						$gamename = preg_replace( "/\"/",'',$gamename[0] );
						} elseif (preg_match("/^\<description/",$myline)) {
						# Pull out the game descriptions
						preg_match( "/\"(.*?)\"/", $line, $gamedesc );
						$gamedesc = preg_replace( "/\"/",'',$gamedesc[0] );
          				} elseif (preg_match("/^\<manufacturer/",$myline)) {
          				# Pull out the game manufacturer
          				preg_match( "/\"(.*?)\"/", $line, $gamemanu );
						$gamemanu = preg_replace( "/\"/",'',$gamemanu[0] );
          				} elseif (preg_match("/^\<rom/",$myline)) {
                        # Pull out the game rom name, size, crc, md5 and sha1
          				preg_match_all( "/\"(.*?)\"/", $line, $gamerom );
  						$gameromdet = preg_replace( "/\"/",'',$gamerom[0] );
						$gameromname = preg_replace( "/\"/",'',$gameromdet[0] );
  						$gameromsize = preg_replace( "/\"/",'',$gameromdet[1] );
						$gameromcrc = preg_replace( "/\"/",'',$gameromdet[2] );
							if (strlen($gameromdet[3]) > $md5len ) {
								$gamerommd5 = "";
								$gameromsha1 = preg_replace( "/\"/",'',$gameromdet[3] );
							} else {
								$gamerommd5 = preg_replace( "/\"/",'',$gameromdet[3] );
								$gameromsha1 = preg_replace( "/\"/",'',$gameromdet[4] );
							}
          				}
                        # If we match the end of the block, call the build_itemArray function          				
						if (preg_match("/^\<\/game/",$myline)) {
							build_itemArray("0","1",$gamename,"","",$ext,$gamedesc,$gamemanu,$gameromname,$gameromsize,$gameromcrc,$gamerommd5,$gameromsha1,$build);
						}
          			} 
          			break;
        		# CLRMame Pro DAT Format
          		case cmprodat:
          			$myline = ltrim($line);
          			if (( $i > $skiplines ) && (preg_match("/^name/",$myline))) {	
          				# Pull out the archive names
						preg_match( "/\"(.*?)\"/", $line, $gamename );
						$line = preg_replace( "/\"/",'',$gamename[0] );
          				build_itemArray("0","1",$line,$line,$line,$ext,$line,$line,$line,"","","","",$build);
					}
          		break;
        		# Rommanger Dat Format
          		case rommanager:
					if ( $i > $skiplines ) {
						if (preg_match("/^�/",$line)) {
						# �parent name�parent description�game name�game description�rom name�rom crc�rom size�romof name�merge name�
						$line = explode('�',$line);
						build_itemArray("0","1",$line[1],$line[0],$line[7],$ext,$line[4],"",$line[5],$line[7],$line[6],"","",$build);
						}
					}
          		break;
          		# MAME XML Formal
				case mamexml:
          			read_mamexml($skiplines);
          		break;
          		# Generic
				case generic:
          			build_itemArray("1","0",$line,"","",$ext,"","","","","","","",$build);
          		break;
				default:
           		echo "Nothing to do here either jim";
        	}
  
		}
	fclose($handle);
	}
		
		# File write footer, open file for append
		#$xmlhndl = @fopen($outfile,"a");		
        writeout_footer();
    } 

    if (is_file($fixfile)) { 
			unlink($fixfile); 
    }
}

function build_itemArray($type = "0",$condition = "1",$value,$cloneof,$romof,$ext,$description,$manufucturer,$rom,$size,$crc32,$md5,$sha1,$build) {
	
		$line = chop($line);
		$items = array();
		$items [] = array(
		'type' => $type,
		'condition' => $condition,
		'value' => $value,
		'cloneof' => $cloneof,
		'romof' => $romof,
		'ext' => $ext,
		'description' => $description,
		'manufacturer' => $manufacturer,
		'rom' => $rom,
		'size' => $size,
		'crc32' => $crc32,
		'md5' => $md5,
		'sha1' => $sha1,
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
 * create_link()
 * 
 * Creates a hyperlink to file if it exists
 */
function create_link($zipfile) {

	global $csIDstr, $maxviewbytes, $sessionID;
	
	if (file_exists($zipfile)) {
		$fsize = filesize($zipfile) . ' bytes';
		
		if ((filesize($zipfile) > $maxviewbytes) || preg_match('/bat$|sh$|xml$/',$zipfile)  ) {
			
			// Clean filename
			$zipinfo = pathinfo($zipfile);
			$zipbase = basename($zipfile,'.'.$zipinfo['extension']);
			
			// zip files
			zipfiles($zipbase,$zipfile);
			exit;
		}
		cleanSessionID($zipfile);
		$hreftitle = basename($csIDstr);
		$resultsfile = UPLOADPATH .'/'. $sessionID .'/'.basename($zipfile);
		chmod($resultsfile, 0755);
		echo (' 
				<tr><td>
					Results: <a href="'.$resultsfile.'">'.$hreftitle.'</a> - '.$fsize.'<br /> 
				</td></tr>
			 ');
        }
}



function cleanSessionID($string) {
	global $sessionID, $csIDstr;
	$csIDstr = str_replace('./_userdata/' . $sessionID . '/','',$string);
}


/** Returns revision number <--- Borrowed from google ;)  */
function getSCID() {
    $svnid = '$Rev$';
    $scid = substr($svnid, 6);
    return intval(substr($scid, 0, strlen($scid) - 2));
}

function zipfiles($outfile,$name) {
	global $csIDstr, $sessionID;
	cleanSessionID($name);

	// Set outfile to correct name, then delete existing file
	$outfile =  UPLOADPATH .'/'. $sessionID .'/'. $outfile . ".zip";
	if (file_exists($outfile)) { unlink($outfile); }
	// Create temporary zip file
	$file = tempnam("tmp", session_id());
	$zip = new ZipArchive();
	
	#echo "FILE:$file<br />OUTFILE:$outfile<br />NAME:$name<br />CLEAN:$csIDstr<p />";
	
	// Zip will open and overwrite the file, rather than try to read it.
	$zip->open($file, ZIPARCHIVE::OVERWRITE);
	$zip->addFile($name, $csIDstr);
	// Close zip
	$zip->close();
	// Copy the file to the correct directory
	copy($file, $outfile);
	if (file_exists($name)) { unlink($name); }
	create_link($outfile);		
}

function mwzipfiles($outfile,$names,$ver) {
	global $csIDstr;
	// Set outfile to correct name, then delete existing file
	$outfile =  $outfile . ".zip";
	if (file_exists($outfile)) { unlink($outfile); }
	// Create temporary zip file
	$file = tempnam("tmp", session_id());
	$zip = new ZipArchive();
	// Zip will open and overwrite the file, rather than try to read it.
	$zip->open($file, ZIPARCHIVE::OVERWRITE);
	// Put files in zip
	foreach ($names AS $name) {
		cleanSessionID($name);
		#$name = UPLOADPATH .'/'. $sessionID .'/'. $name;
		$strdir = substr($csIDstr,0,strrpos($csIDstr,"-"));
	#echo "FILE:$file<br />ZIPDIR:$strdir<br />OUTFILE:$outfile<br />NAME:$name<br />CLEAN:$csIDstr<p />";
		
	if ( preg_match('/ini$/',$name)) {	
		if ( $ver == 168 ) {
			$zipdirs = "config/$strdir/$csIDstr";
		} else if ($ver == 167) {
			$zipdirs = "ini/$csIDstr";
		} else {
			$zipdirs = "$csIDstr";
		}
		
		$zip->addFile($name, $zipdirs);
		} else if ( preg_match('/lst$/',$name)) {
		$zip->addFile($name, "files/".$csIDstr);
		} else {
		$zip->addFile($name, $csIDstr);
		}	
	}
	// Close zip
	$zip->close();
	// Copy the file to the correct directory
	copy($file, $outfile);
	
	// Clean up old files, doesnt work in the foreach loop above
	foreach ($names AS $name) {
		if (file_exists($name)) {
		unlink($name);		
		}
	}

}
?>
