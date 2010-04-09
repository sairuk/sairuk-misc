<?php
/*
 * listgen indesx.php
 *  
 * $Author:$
 * $Id:$
 * $Rev$
 *  
 * Enter Description
 */ 

require('functions.php');


# Project information
$projName = "listgen";
$projVer = "v0.7";
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
    <title><?php print $projName .' '. $projVer . ' (SVN Version: '.getSCID().')'?></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <table border="0" width="50%">
            <tr>
                 <td><img src="listgen.png" border="0"></img>
                        Accepts:
                        <ul type="disc"> 
                        <li>Cowering GoodTools formatted miss/have txts</li>
						<li>CLRMame fixdats (newer XML fixdats)</li>
						<li>Mame ListXML (NOT AVAILABLE, requires >128mb memcache)</li>
						</ul>
                 </td>
             </tr>
            <tr>
                <td>
					<table border="0">
						<tr>
							<td colspan="2">
								<form enctype="multipart/form-data" action="index.php" method="post">
								Select Input File<br />
								<input type="file" name="fixfile" size="50%" title="Select input file"/><br />
							</td>
							<td align="left" valign="top">
							Select Output Format<br />
									 <select name="queue" title="Select output format">
										 <option>Copy Scripts</option>									 
										 <option value="msbat">• MSDOS batch</option>
										 <option value="bash">• Bash Script</option>
										 <option>&nbsp;</option>	
										 <option>Emulator Frontends</option>
										 <option value="mamewah" title="Only supported for Goodtxts">• MameWah &lt;1.67 Filtered Lists</option>
										 <option value="mamewah168" title="Only supported for Goodtxts">• MameWah 1.68 Filtered Lists</option>
										 <option value="mGalaxy" title="Version number must be manually added final output">• mGalaxy Database</option>
										 <option value="xbmc-launcher">• XBMC Launcher Rom List</option>
										 <option>&nbsp;</option>	
										 <option>File Transfer Queues</option>
										 <option value="filezilla">• FileZilla Filter</option>
										 <option value="wget">• wget queue</option>
										 <option>&nbsp;</option>	
										 <option>HTML Listings</option>
										 <option value="htmlall" selected="selected" title="Multiple Search Options in output">• Web Search (Multiple)</option>
										 <option value="binsearch">• binsearch.info</option>
										 <option value="easynews">• EasyNews Search</option>
										 <option value="google">• Google Search</option>
										 <option>&nbsp;</option>	
									 </select>
							</td>
						</tr>
						<tr>
							<td align="left" valign="top">Rom Path: <input type="text" name="rompath" title="Only Supported by XBMC-Launcher only." /></td>
							<td align="left" valign="top">
									Extension:
									 <select name="ext" title="Select used extenstion">
										 <option value="7z">7z</option>
										 <option value="rar">rar</option>
										 <option value="zip" selected="selected">zip</option>
										 <option value="custom">custom</option>
									 </select><input type="text" name="custext" size="4" title="Enter Custom Extension"/>
							</td>

							<td align="right" valign="top">
									<input type="submit" name="datrun" value="Process"/>
								</form>
							</td>
						</tr>
					</table>
                </td>
				</tr>
		<tr>
			<td colspan="3">&nbsp;<br />
				<?php echo " $projName, Version: $projVer (SVN Version: ".getSCID().") written by: $projAuth " ?>&nbsp --- &nbsp;<a href="/listgen">Reload Page</a>
				<hr></hr>
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
