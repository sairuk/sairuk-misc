<?php

/*
 * General Function, used to process all files
 * once file is identified
 * 
 */
function genFunction($inType,$skipLines,$fTypeTitle) {
	
	global $fixfile;
	global $name;
	global $outfile;
	global $ext;
	global $xmlhndl;
	
    $i = "0";
	$name = preg_replace('/' . session_id() . '_/','',$outfile);
	
    if (file_exists($fixfile) && is_readable ($fixfile)) {

    	print $fTypeTitle."<br />";
    	
    	# File write header, open file for writing
		@unlink($outfile);
		$xmlhndl = @fopen($outfile,"w");
        writeout_header();

         $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ( $lines as $line ) {
			$i++;
			
        	# Custom Items Start Here
        	switch ($inType) {
				case goodtxt:
          		read_txtlist($skipLines); 
          		break;
				case cmproxml:
          		read_cmproxml($skipLines); 
          		break;
				case mamexml:
          		read_mamexml($skipLines); 
          		break;
				default:
           		echo "Nothing to do here either jim";
        	}
        	
		# File write contents, open file for append
		$xmlhndl = @fopen($outfile,"a");
		writeout_contents($items);
        	
        }
		
		# File write footer, open file for append
		$xmlhndl = @fopen($outfile,"a");		
        writeout_footer();
     } 

     if (file_exists($fixfile)) {
		unlink($fixfile);
	}
}

/*
 * Processes basic text file lists
 * any list is perfectly fine
 */
function read_txtlist($skipLines) {

    if ( $i > $skiplines ) 
		{
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
		'build' => 'Current'
		);

	}
}

/*
 * Processes CLRMAME XML fixdat files
 */
function read_cmproxml($skiplines) 
{
						
	if (( $i > $skiplines ) && ( substr($line,2,4) == "game"))
	{
                    
	# Pull out the archive names
	preg_match( "/\"(.*?)\"/", $line, $gamename );
	$line = preg_replace( "/\"/",'',$gamename[0] );
                           
		 # Process items here
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
		'build' => 'Current'
		);
	
	}

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
		// Process items here
		$line = chop($game);
		$items = array();
		$items [] = array(
		'type' => '0',
		'condition' => '1',
		'value' => $line,
		'cloneof' => $cloneof,
		'romof' => $romof,
		'ext' => $ext,
		'description' => $description,
		'build' => $build
		);
	}
}

/*
 * Process all files after upload
 * Checks type of file then calls genFunction()
 */
function process_upload($tmpfile) {

	global $fixfile;

    $uploaddir = '/var/www/listgen/';
	$uploadfname = basename($_FILES['fixfile']['name']);
    $uploadfile = $uploaddir . $uploadfname;
    if (move_uploaded_file($_FILES['fixfile']['tmp_name'], $uploadfile)) {
        $fixfile = $uploadfname;
		$i = 0;
        $lines = file($fixfile);
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
				genFunction("cmproxml","16","Recognised CMPro Fixdat (XML");				
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

	if (file_exists($zipfile)) {
		$hreftitle = preg_replace('/' . session_id() . '_/','',$zipfile);
		echo (' 
				<tr>
				<td>
					Results: <a href="'.$zipfile.'" target="_blank">'.$hreftitle.'</a><br /> 
				</td>
				 </tr>
			 ');
        }
}

?>
