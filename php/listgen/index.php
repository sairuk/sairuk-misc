<?php

/*
 * listgen indesx.php
 *  
 *  
 * Enter Description
 */ 

require('functions.php');


# Project information
$projName = "listgen";
$projVer = "v0.6";
$projAuth = "sairuk";


# Global Variables
global $modname, $fixfile, $ext, $name, $outfile, $xmlhndl, $rompath, $sessionID;

# If page is reloaded from form with ext passed
# populate $ext 
if (isset($_POST['rompath']))
{
	# Set $ext to combo data
	$ext = ".".$_POST['ext'];
} else if ($_POST['ext'] == "custom" ) {
	
	# Set $ext to form data
    $ext = ".".$_POST['custext'];
} else {
	# Clear $ext
	$ext = "";
}

# Initialise Session Information
session_start();
$sessionID = session_id();


# If page is reloaded from form with rompath passed
# strip slashes from the path and print path to the 
# screen
if (isset($_POST['rompath']))
{
	$rompath = stripslashes($_POST['rompath']);
	print $rompath;
}

?>
<html>
    <head>
    <title><?php print $projName .' '. $projVer ?></title>
	<link ref="style.css" type="stylsheet/text"></link>
    </head>
    <body>
        <table border="0" width="50%">
            <tr>
                 <td><h3><?php print $projName .' '. $projVer ?></h3>
                        Accepts miss/have txts, cmpro fixdats & mame listxml*, converts to chosen output formats.<br />&nbsp;<br />* listxml Needs a large memcache for php >128mb, limited item support
                 </td>
             </tr>
            <tr>
                <td>
					<table border="0">
						<tr>
							<td colspan="2">
								<form enctype="multipart/form-data" action="index.php" method="post">
								<input type="file" name="fixfile" size="50%" title="Select input file"/><br />
							</td>
							<td align="right" valign="top">
									 <select name="ext" title="Select used extenstion">
										 <option value="7z">7z</option>
										 <option value="rar">rar</option>
										 <option value="zip" selected="selected">zip</option>
										 <option value="custom">custom</option>
									 </select><input type="text" name="custext" size="4" title="Enter Custom Extension"/>
							</td>
						<tr>
							<td>
									 <select name="queue" title="Select output format">
										 <option>Copy Scripts</option>									 
										 <option value="msbat">- MSDOS batch</option>
										 <option value="bash">- Bash Script</option>
										 <option>&nbsp;</option>	
										 <option>Emulator Frontends</option>
										 <option value="mamewah">- MameWah &lt;1.67 Filtered Lists</option>
										 <option value="mamewah168">- MameWah 1.68 Filtered Lists</option>
										 <option value="mGalaxy">- mGalaxy Database</option>
										 <option value="xbmc-launcher">- XBMC Launcher Rom List</option>
										 <option>&nbsp;</option>	
										 <option>File Transfer Queues</option>
										 <option value="filezilla" selected="selected">- FileZilla Filter</option>
										 <option value="wget">- wget queue</option>
										 <option>&nbsp;</option>	
										 <option>HTML Listings</option>
										 <option value="htmlall">- All</option>
										 <option value="binsearch">- binsearch.info</option>
										 <option value="easynews">- EasyNews Search</option>
										 <option value="google">- Google Search</option>
										 <option>&nbsp;</option>	
									 </select>
							</td>
							<td>
									 Path:(ROMs)<input type="text" name="rompath" title="Required for XBMC-Launcher only." />
							</td>
							<td align="right">
									<input type="submit" name="datrun" value="Process"/>
								</form>
							</td>
						</tr>
					</table>
                </td>
				</tr>
		<tr>
			<td colspan="3">
				<a href="/listgen">Reload Page</a>
			</td>
		</tr>
		</table>
	</body>
</html>

<?php

# Process File Upload
if (isset($_FILES['fixfile']['name'])) 
{
    $fixfile = $_FILES['fixfile']['name'];

	# Setup Output Module
	switchOutput($_POST['queue']);   
    
    $tmpfile = $_FILES['fixfile']['tmp_name'];
    process_upload($tmpfile);
}

?>
