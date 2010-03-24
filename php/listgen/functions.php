<?php

### Goodsets, cmpro & textbox lines

function read_txtlist($skiplines) 
{

	global $fixfile;
	global $name;
	global $outfile;
	global $ext;
	global $xmlhndl;

    $i = "0";
	$name = preg_replace('/' . session_id() . '_/','',$outfile);
    
    if (file_exists($fixfile) && is_readable ($fixfile)) 
    {
		
		echo "Recognised GoodTools style Miss/Have Text<br />";

		# File write header, open file for writing
		@unlink($outfile);
		$xmlhndl = @fopen($outfile,"w");
        writeout_header();
		
        $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ( $lines as $line )
        {
            $i++;
		    if ( $i > $skiplines ) 
            {
                // Process items here
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

				# File write footer, open file for append
				$xmlhndl = @fopen($outfile,"a");
                writeout_contents($items);
            }
        }
		
		# File write footer, open file for append
		$xmlhndl = @fopen($outfile,"a");		
        writeout_footer();
     } 
	if (file_exists($fixfile)) 
	{
		unlink($fixfile);
	}
}

function read_cmproxml($skiplines) 
{
	
	global $fixfile;
	global $name;
	global $outfile;
	global $ext;
	global $xmlhndl;
	
    $i = "0";
    #$name = preg_replace('/' . session_id() . '_/','',$outfile);
	
    if (file_exists($fixfile) && is_readable ($fixfile)) 
    {
 
				echo "Recognised CMPro Fixdat (XML)<br />";

				
				# File write header, open file for writing
				@unlink($outfile);
				$xmlhndl = @fopen($outfile,"w");
				writeout_header();
                                
                $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ( $lines as $line )
                {
                    $i++;
					
                    if (( $i > $skiplines ) && ( substr($line,2,4) == "game"))
                    {
                    
                            // Pull out the archive names
                            preg_match( "/\"(.*?)\"/", $line, $gamename );
                            $line = preg_replace( "/\"/",'',$gamename[0] );
                           
                        // Process items here
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

						# File write footer, open file for append
						$xmlhndl = @fopen($outfile,"a");
						writeout_contents($items);
						
                    }
                }
			# File write footer, open file for append
			$xmlhndl = @fopen($outfile,"a");		
			writeout_footer();

     } 
	if (file_exists($fixfile)) 
	{
		unlink($fixfile);
	}
}

function read_mamexml($skiplines) 
{
	
	global $fixfile;
	global $name;
	global $outfile;
	global $ext;
	global $xmlhndl;
	
    $i = "0";
    $name = preg_replace('/' . session_id() . '_/','',$outfile);
	
    if (file_exists($fixfile) && is_readable ($fixfile)) 
    {
 
				echo "Recognised MAME (XML)<br />";
				
				# File write header, open file for writing
				@unlink($outfile);
				$xmlhndl = @fopen($outfile,"w");
				writeout_header();
										
                $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ( $lines as $line )
                {
                    $i++;
					#echo substr($line,3,11)."\n";

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
                          

						# File write footer, open file for append
						$xmlhndl = @fopen($outfile,"a");
						writeout_contents($items);
						unset($game, $description);
					}
                }
				# File write footer, open file for append
				$xmlhndl = @fopen($outfile,"a");		
				writeout_footer();
     } 
	if (file_exists($fixfile)) 
	{
		unlink($fixfile);
	}
}

function read_textbox() {
}

function process_upload($tmpfile) {

	global $fixfile;
	global $tmpfile;

    $uploaddir = '/var/www/listgen/';
	# $uploadfname = session_id() . '_' .basename($_FILES['fixfile']['name']);
	$uploadfname = basename($_FILES['fixfile']['name']);
    $uploadfile = $uploaddir . $uploadfname;
    if (move_uploaded_file($_FILES['fixfile']['tmp_name'], $uploadfile)) {
        $fixfile = $uploadfname;
	return($fixfile);
    }
}

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

function check_file() {

	global $fixfile;
	global $name;
	global $outfile;
	global $ext;

	if (file_exists($fixfile) && is_readable ($fixfile)) {
		$i = 0;
        $lines = file($fixfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ( $lines as $line ) {
            $i++;
			if (($i == "1") && (preg_match('/You are Missing|You Have/i',$line))) {
				# Valid GoodTools File
				read_txtlist(2);
				exit;
			}
			if (($i == "2") && (preg_match('/DOCTYPE mame/',$line)))	{
				# Valid MAME XML
				read_mamexml(85);						
				exit;
			} 
			if (($i == "7") && (preg_match('/FIXDAT/',$line)))	{
				# Valid CMPRO Fixdat
				read_cmproxml(16);						
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


?>
