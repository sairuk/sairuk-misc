<?php

if (isset($_GET['type'])) { $type = $_GET['type']; } else { $type = "TV"; }

try
{
	//create or open the database
	$database = new SQLiteDatabase(DB, 0666, $error);
}
catch(Exception $e) { die($error);	}

function index() {
	global $database;
	$types = lookup_types();
			echo "<table border=0><tr>";
			foreach( $types as $type ) {
				$lquery = "SELECT title FROM watched WHERE type='$type'";
				if(!$database->queryExec($lquery, $error)) { die($error); }
				if($lresult = $database->query($lquery, SQLITE_BOTH, $error))
				{
					echo "<td>";
					echo "<table border=0><th>$type</th>";
					while($row = $lresult->fetch())
			  		{
			  			echo ('<tr><td>'.$row['title'].'</td></tr> ');
			  		}
			  		echo "</table>";
			  		echo "</td>";
				}	
			
		}
			echo "</td></tr></table>";
}

function watchnzb() {
	global $type;
	$types = lookup_types();
	foreach ( $types as $type ) {
		$feeds = lookup_rss($type);
		$watched = lookup_watched($type);
		
		foreach ( $watched as $item ) {
			$i_title = preg_replace('/[^\w\s]/','',$item);
			echo "<b>$i_title</b><br />";
			foreach ( $feeds as $feed ) {
				$siteid = lookup_siteid_by_url($feed);
				$site = lookup_site($siteid[0]);
				echo "&nbsp;&#149;&nbsp;$type in $feed<br />";
				parse_xml($feed,$item,$siteid[0],$site['url']);
			}
			echo "<p />";
		}
	}
}

function lookup_types() {
	global $database;
	$query = "SELECT type FROM watched GROUP BY type";
	if(!$database->queryExec($query, $error)) { die($error); }
	if($result = $database->query($query, SQLITE_BOTH, $error)) {	
		while($row = $result->fetch())
  		{
  			$types[] = $row['type'];
  		}
	}
	return $types;
}

function lookup_watched($type) {
 global $database, $type;
 	 
	// create watched items array and type
		$query = "SELECT title FROM watched WHERE type='$type'";
		if(!$database->queryExec($query, $error)) { die($error); }
			if($result = $database->query($query, SQLITE_BOTH, $error))
		{
			while($row = $result->fetch())
	  		{
	  			$watched[] = $row['title'];
	  		}
		}
	return $watched;
}

function lookup_rss($type) {
global $database;
// create rss feeds array to check
	$query = "SELECT url FROM feeds WHERE type='$type'";
	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		while($row = $result->fetch())
  		{
  			$feeds[] = $row['url'];
  		}
	}
	return $feeds;
}

function lookup_siteid_by_type($type) {
global $database;
// create rss feeds array to check
	$query = "SELECT siteid FROM feeds WHERE type='$type'";
	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		while($row = $result->fetch())
  		{
  			$siteid[] = $row['siteid'];
  		}
	}
	return $siteid;
}

function lookup_siteid_by_url($url) {
global $database;
// create rss feeds array to check
	$query = "SELECT siteid FROM feeds WHERE url='$url'";
	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		while($row = $result->fetch())
  		{
  			$siteid[] = $row['siteid'];
  		}
	}
	return $siteid;
}

function lookup_site($siteid) {
 global $database;
	// setup site data (action/login/user/pass/ref)
		$query = "SELECT * FROM sites WHERE ROWID='$siteid'";
		if(!$database->queryExec($query, $error)) { die($error); }
			if($result = $database->query($query, SQLITE_BOTH, $error))
		{
			return $result->fetch();
		}	
}

function insert_db($title, $season, $episode, $nzbid, $guid) {
	global $database;
	//add data
	$query = 'INSERT INTO downloads ' .
	         'VALUES ("'.$title.'", "'.$season.'", "'.$episode.'", "'.$nzbid.'", "'.$guid.'")';
	$query = sqlite_escape_string($query);
	if(!$database->queryExec($query, $error)) { die($error); }
}

function lookup_db($fname, $title, $season, $episode, $nzbid, $guid, $siteid, $url) {
	global $database, $type;
	$i = 0;	
	// lookup entry
	$query = 'SELECT * FROM downloads ' .
	         'WHERE title = \''.$title.'\' AND season = \''.$season.'\' AND episode = \''.$episode.'\'';
	if(!$database->queryExec($query, $error)) { die($error); }

	if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		while($row = $result->fetch())
  		{
	  		print(	"Already found in database, not downloading again <br />" .
					"<b>Title:</b> {$row['title']} <br />" .
					"<b>Season:</b> {$row['season']} <br />".
					"<b>Episode:</b> {$row['episode']} <br />".
	    			"<b>NZBID:</b> {$row['nzbid']} <br />".
	    			"<b>GUID:</b> {$row['guid']} <br /><p />");
	  				$i++;
 	 	}
	} 
	if ( $i == '0' ) {
	// Download NZB and add new item to database
	
	$sites = lookup_siteid_by_type($type);
	foreach ($sites as $siteid) {
		$site = lookup_site($siteid);
		$cookies=COOKPATH.$siteid."_cookies.txt";
		$astr=$site['astr'];
		$ref=$site['url'];
		$ext=$site['ext'];
		$cookies = $siteid."_cookies.txt";
		$output = shell_exec('wget --load-cookies '.COOKPATH.$siteid.'_cookies.txt -U "'.UAGENT.'" --referer="'.$url.'" "'.$url.$astr.$nzbid.'" --output-document "'.SAVE.$fname.'.'.$ext.'"');
		 }
		if (file_exists(SAVE.$fname.".".$ext)) {
	 		insert_db($title, $season, $episode, $nzbid, $guid);
		}
	} else {
	 return;
	}
}

function parse_xml($file, $str, $siteid, $url) {

	$xml = xml_parser_create();
	$str = "/$str/"; // wrap string in forwardslashes for use in preg statement
	$nzbidreg=IDREGEX; // regex to match nzbid/dlid number from hyperlink
	
	if (!($fp = fopen($file, "r"))) { die("could not open XML input"); }
	while (!feof($fp)) {
	  $data .= fread($fp, 4096);
	}
	fclose($fp);
		
	xml_parse_into_struct($xml, $data, $vals, $index);
	xml_parser_free($xml);
		
	foreach ($vals as $xml_elem) {
			if ($xml_elem['tag'] == "ITEM" && $xml_elem['type'] == "open" ) {
				$parse_level = $xml_elem['level'] + 1;
			}
			
			if ($xml_elem['tag'] == "TITLE" && $xml_elem['level'] == $parse_level ) {
				if (preg_match($str,$xml_elem['value'])) {
				   $title = preg_replace('/\s/','.',$xml_elem['value']);
				} 
			}
				
	        if ($xml_elem['tag'] == "LINK" && $xml_elem['level'] == $parse_level ) {
	        	if (preg_match($nzbidreg,$xml_elem['value'],$matches)) {
	        		$nzbid = $matches[0];
	        	}   
	        }
	        
		    if ($xml_elem['tag'] == "GUID" && $xml_elem['level'] == $parse_level ) {
        		$guid = $xml_elem['value'];
	        }

			if ($xml_elem['tag'] == "ITEM" && $xml_elem['type'] == "close" ) {
			    if (isset($title) && isset($nzbid)) {
			    	$fname = $title; // title is originally the format we want to use for the filename
					// REGEX for matching TITLE/SEASON/EPISODE information
					if (preg_match(SEEPRGX,$title,$matches)) {
						$result = count($matches);
						$title = trim($matches[0],".");
						$season = trim($matches[($result-2)],".");
						$episode = trim($matches[($result-1)],".");
					}
					echo "Matched: $title from $fname with ID: $nzbid</a> and GUID: $guid<br />";					
					lookup_db($fname, $title, $season, $episode, $nzbid, $guid, $siteid, $url);				
					unset($title,$description,$guid);
			    }
				
			}
	}	
}


/*
 * 
 * 
 * ADMIN PAGE FUNCTIONS
 * 
 * 
 */

function build_db() {	
	global $database;

	if (file_exists(DB)) {
		//add download table to database
		$query =
		'CREATE TABLE downloads ' .
		'(title TEXT, season TEXT, episode TEXT, nzbid TEXT, guid TEXT); ' .

		'CREATE TABLE watched ' .
		'(title TEXT, type TEXT); ' .

		'CREATE TABLE feeds ' .
		'(title TEXT, url TEXT, type TEXT, siteid INTEGER); ' .
		
		'CREATE TABLE sites ' .
		'(title TEXT, url TEXT, astr TEXT, lstr TEXT, user TEXT, password TEXT)';

		'CREATE TABLE libpaths ' .
		'(path TEXT, type TEXT)';
		
		if(!$database->queryExec($query, $error)) { die($error); }
		if (file_exists(DB)) {
			echo "Created Successfully!";
		} else {
			echo "Failed!";
		}
	}
}

function redo_login() {
	global $type;
	$sites = lookup_siteid_by_type($type);
	foreach ($sites as $siteid) {
		$site = lookup_site($siteid);
		
		$cookies=COOKPATH.$siteid."_cookies.txt";
		$NZBUSER=$site['user'];
		$NZBPASS=$site['password'];
		$lstr=$site['lstr'];
		$ustr=$site['ustr'];
		$pstr=$site['pstr'];
		$uphp=$site['uphp'];
		$ref=$site['url'];
			
		$output = shell_exec('wget --keep-session-cookies --save-cookies '.$cookies.' --post-data  \''.$lstr.$ustr.$NZBUSER.$pstr.$NZBPASS.'\' '.$ref.$uphp);
		echo "<pre>$output</pre>";
	}	
}

function admin_page() {
	global $database;
	echo "<h3>ADMIN PAGE</h3>";
	echo ('
			Edit Items in:<br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=maintwatched">Watch list</a><br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=maintsites">Site list</a><br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=maintfeeds">RSS feed list</a><br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=maintlibpaths">Library Paths</a><p />
			
			Site Admin Actions:<br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=maintdl">Maintain downloads table</a><br />
			&nbsp;&#149;&nbsp;<a href="index.php?func=login">Login to Registered Sites</a><br />
			&nbsp;&#149;&nbsp;<a href="admin.php?func=buildlib">Build Library</a><p />
			
			Setup &amp; Testing:<br />
			&nbsp;&#149;&nbsp;<a href="index.php?func=watch">Run Watched Items</a><p />
			&nbsp;&#149;&nbsp;<a href="index.php?func=create">Create Empty Database</a> *** CAUTION ***<p />
		 ');
}


function maint_dl_table() {
global $database;
// create rss feeds array to check
	if (is_array($_POST['chk'])) {
		foreach ( $_POST['chk'] as $chk ) {
			$query = "DELETE FROM downloads WHERE ROWID = '$chk'";
			if(!$database->queryExec($query, $error)) { die($error); }
		}
	}
	$query = "SELECT ROWID,* FROM downloads";

	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
	
			echo ('	
						<form action="admin.php?func=maintdl" name="maintdl" method="post">
						<table border="0"><tr><th>&nbsp;</th><th>Title</th><th>SE</th><th>EP</th><th>NZBID</th><th>GUID</th></tr> 
					');
				while($row = $result->fetch())
		  		{
		   			echo (' <tr><td><input type="checkbox" name="chk[]" value="'.$row['ROWID'].'" /></td><td>'.$row['title'].'</td><td>'.$row['season'].'</td><td>'.$row['episode'].'</td><td>'.$row['nzbid'].'</td><td>'.$row['guid'].'</td></tr> ');
		  		}
		  		echo (' 
		  			</table><p /><input type="submit" value="Remove" /></form><p /> 
		  			');
  	}
}

function maint_tbl($tbl) {
global $database;
	// Number of columns in current db
	$cols = $database->fetchColumnTypes($tbl, SQLITE_ASSOC);
	$no_cols = count($cols);
	$i = 1;
	if (isset($_POST['update'])) {
		
			if ( $_POST['update'] == "Update" ) {
					$chk = $_POST['chk'];
						while ( $i <= $no_cols ) {
							foreach ($cols as $column => $type ) {
								$value = "'".$_POST[$i]."'";
								$query = "UPDATE $tbl SET $column=$value WHERE ROWID = '$chk'";
								if(!$database->queryExec($query, $error)) { die($error); }
								$i++;
							}	
					}
					$i = 1; // Reset $i;
			} else if ($_POST['update'] == "Add") {
					// Dynamically build up VALUES list
					while ( $i <= $no_cols ) {
						$sql_cols = "$sql_cols,$_POST[$i]";
						$i++;
					} 
					// Trim Extra Comma
					$sql_cols = substr($sql_cols,1,strlen($sql_cols)-1);
					$sql_cols = "('".str_replace(",","','",$sql_cols)."')";
				    $query = "INSERT INTO $tbl VALUES$sql_cols";
					if(!$database->queryExec($query, $error)) { die($error); }	
					$i = 1;	 // Reset $i;
								
			} else if ($_POST['update'] == "Remove") {
					$chk = $_POST['chk'];
					$query = "DELETE FROM $tbl WHERE ROWID = '$chk'";
					if(!$database->queryExec($query, $error)) { die($error); }
			}
	} 
	$query = "SELECT ROWID,* FROM '$tbl'";
	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		
		echo ('	
				<h3>Maintain '. $tbl .' List</h3>				
				<table border="0"><tr>
			');
		foreach ($cols as $column => $type ) {
			echo (' <th>'.ucwords($column).'</th> ');
		}
		echo "<th>&nbsp</th><th>&nbsp</th></tr><tr>";
		// New Items
		$i = 1;
		while ($i <= $no_cols) {
	   		echo (' <td><form action="admin.php?func=maint'.$tbl.'" name="maint'.$tbl.'" method="post"><input type="input" name="'.$i.'" /></td>');
	   		$i++;
  		} 
		echo (' <td><input type="submit" name="update" value="Add" /></td><td>&nbsp;</td></form></td></tr> ');
		// Editable Items		
		$i = 1;
		while($row = $result->fetch())
  		{
  			echo (' <tr><form action="admin.php?func=maint'.$tbl.'" name="maint'.$tbl.'" method="post"> ');
  			while ($i <= $no_cols) {
    				echo (' <td><input type="hidden" name="chk" value="'.$row['ROWID'].'" /><input type="input" name="'.$i.'" value="'.$row[$i].'" /></td>');
   				$i++;
  			}
  			echo (' <td><input type="submit" name="update" value="Update" /></td><td><input type="submit" name="update" value="Remove" /></form></td></tr> ');
  			$i = 1; 
  		}
  		echo ('
	  			</table><p />
	  			</form><p />
   			');
		}
}

function buildlib() {
global $database;
	$tbl = "libpaths";	
	$cols = $database->fetchColumnTypes($tbl, SQLITE_ASSOC);
	$no_cols = count($cols);
	
	$query = "SELECT ROWID,* FROM '$tbl'";
	if(!$database->queryExec($query, $error)) { die($error); }
		if($result = $database->query($query, SQLITE_BOTH, $error))
	{
		echo ('	
				<h3>Maintain '. $tbl .' List</h3>				
				<table border="0"><tr>
			');
		foreach ($cols as $column => $type ) {
			echo (' <th>'.$column.'</th> ');
		}
		// Editable Items		
		$i = 1;
		while($row = $result->fetch())
  		{
  			echo (' <tr>');
  			while ($i <= $no_cols) {
    				echo (' <td>'.$row[$i].'</td>');
   				$i++;
  			}
    		$dirs[] = $row['path'];
  			$i = 1; 
  		}
  		echo ('
	  			</table><p />
	  			<a href="admin?func=buildlib&exec=1">Build Lib</a><br />
   			');
		}
	
	# Recurse Dirs
	if (isset($_GET['exec'])) {
		
		# Clear old library entries
		$query = "DELETE FROM downloads WHERE guid='LIBUILD'";
		if(!$database->queryExec($query, $error)) { die($error); }
		
		foreach ($dirs as $dir) {
			getDirectory($dir);
		}
	}
}

// this function was written by missing-score, modified by sairuk
function getDirectory( $path = '.', $level = 0 ){
	global $database;
	
    $ignore = array( 'cgi-bin', '.', '..' );
    // Directories to ignore when listing output. Many hosts
    // will deny PHP access to the cgi-bin.
    $dh = @opendir( $path );
    // Open the directory to the handle $dh  
    while( false !== ( $file = readdir( $dh ) ) ){
    // Loop through the directory
          if( !in_array( $file, $ignore ) ){
        	// Check that this file is not to be ignored        
            // show the directory tree.            
            if( is_dir( "$path/$file" ) ){
            		echo "<strong>$file</strong><br />";
                	getDirectory( "$path/$file", ($level+1) );
            } else {
	        		if (preg_match('/.{3}$/',$file) && !preg_match('/'.BLKEXT.'/',$file)) {
	        			# TV Shows
				        if (preg_match(SEEPRGX,$file,$matches)) {
							$mresult = count($matches);
							$title = sqlite_escape_string(trim($matches[0],"."));
							$season = trim($matches[($mresult-2)],".");
							$episode = trim($matches[($mresult-1)],".");
	        				echo "&nbsp;&nbsp;$title&nbsp;$season&nbsp;$episode<br />";
					        $query = "INSERT INTO downloads VALUES('$title','$season','$episode','000000','LIBUILD')";
					        if(!$database->queryExec($query, $error)) { die($error); }
				        } else {
						$file = sqlite_escape_string($file);
				        	$query = "INSERT INTO downloads VALUES('$file','00','00','000000','LIBUILD')";
					        if(!$database->queryExec($query, $error)) { die($error); }				        	
				        }
	        		}        
            }
        
        }
    
    }
    
    closedir( $dh );
    // Close the directory handle

}


?>
