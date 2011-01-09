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
require_once('includes/conf.php');
require_once('includes/functions.php');
include('includes/counter.php');

?>
<html>
    <head>
    <title><?php print $projName .' '. $projVer . ' (SVN Version: '.getSCID().')'?></title>
	<link rel="stylesheet" type="text/css" href="includes/style.css" />
    </head>
    <body>
        <table border="0">
            <tr>
                 <td colspan="2"><img src="listgen.png" border="0"></img></td>
            </tr>
            <tr>
            <td width="400px">
                        Accepts: <i>(NOTE: Success for large lists depends on server config.)</i>
                        <ul type="disc"> 
                        <li>Cowering GoodTools (extended)</li>
                        <li>No-Intro (extended)</li>
						<li>CLRMame/RC3 XML (extended)</li>
						<li>CLRMame legacy DAT format (limited)</li>
						<li>RomCenter legacy DAT format (extended)</li>
						<li>Mame ListXML <?php  if ( ini_get('memory_limit') < 256 ) { echo "<b><i> - (Not Supported on this Server)</i></b>"; } ?></li>
						<li>Unknown files are treated as generic (useful for basic lists)</li>
						</ul>
            </td>
            <td>
			<form enctype="multipart/form-data" action="index.php" method="post">
				<fieldset>
				<legend>Process A List</legend>
					<table border="0">
						<tr>
							<td>Input File:</td><td><input type="file" name="fixfile" size="58" title="Select input file"/></td>
						</tr>
						<tr>
							<td align="left" valign="top">
							Output Format:</td><td>
									 <select name="queue" title="Select output format">
										 <optgroup label="HTML Listings">
										 <option value="htmlall" selected="selected" title="Multiple Search Options in output">&#149; Web Search (Multiple)</option>
										 <option value="binsearch">&#149; binsearch.info</option>
										 <option value="easynews">&#149; EasyNews Search</option>
										 <option value="ebayau">&#149; eBay Australia Search</option>
										 <option value="ebay">&#149; eBay Search</option>
										 <option value="google">&#149; Google Search</option>
										 </optgroup>
										 <optgroup label="File Transfer Queues">
										 <option value="filezilla">&#149; FileZilla Filter</option>
										 <option value="wget">&#149; wget queue</option>
										 </optgroup>
										 <optgroup label="Copy Scripts">									 
										 <option value="msbat">&#149; MSDOS batch</option>
										 <option value="bash">&#149; Bash Script</option>
										 </optgroup>
										 <optgroup label="Categories">									 
										 <option value="catver">&#149; CatVer Format</option>
										 </optgroup>
										 <optgroup label="Rename Scripts">	
										 <option value="CRCmsbat" title="Rename files from CRC.EXT to a useful name">&#149; MSDOS batch CRC</option>
										 <option value="msbatnumbered" title="Rename files from NUMBER.EXT to a useful name">&#149; MSDOS batch NUM</option>
										 </optgroup>
										 <optgroup label="Emulator Frontends">
										 <option value="mamewah" title="Best support for Goodtxts">&#149; Wah!Cade Filtered Lists</option>
										 <option value="mamewah168" title="Best support for Goodtxts">&#149; MameWah 1.68 Filtered Lists</option>
										 <option value="mGalaxy" title="Version number must be manually added to final output">&#149; mGalaxy Database</option>
										 <option value="xbmclauncher">&#149; XBMC Launcher Rom List</option>
										 </optgroup>
										 <!-- <optgroup label="Miscellaneous">									 
										 <option value="fakefile">� Create Fake Files</option>
										 </optgroup> -->
									 </select>
									 <input type="submit" name="datrun" value="Process"/>
									 
							</td>
						</tr>
						<tr>
							<td align="left" valign="top">Rom Path: <i>(Optional)</i></td><td><input type="text" size="50" name="rompath" title="Supported in XBMC-Launcher only." /></td>
						</tr>
						<tr>
							<td align="left" valign="top">

									Extension: <i>(Optional)</i>:</td><td>
									 <select name="ext" title="Select used extenstion">
										 <option value="7z">7z</option>
										 <option value="rar">rar</option>
										 <option value="zip" selected="selected">zip</option>
										 <option value="custom">custom</option>
									 </select><input type="text" name="custext" size="4" title="Enter Custom Extension"/>
							</td>
							</tr>
					</table>
 				</fieldset>
			</form>
         	</td>
         	
			</tr>
		
			<tr>
			<td colspan="3">
				&nbsp;<br />
				<?php echo " $projName, Version: $projVer (SVN Version: ".getSCID().") written by: $projAuth " ?>
				&nbsp; --- &nbsp;<a href="http://code.google.com/p/sairuk-misc/wiki/wikilginfo">Wiki Page</a>
				&nbsp; --- &nbsp;<a href="http://code.google.com/p/sairuk-misc/">Google Code</a>
				&nbsp; --- &nbsp;<a href="/listgen">Reload Page</a>
			</td>
			</tr>
		</table>
		<p />
	</body>
</html>

<?php 
# Process File Upload
# kept in index.php to render correctly for the time being
if (isset($_FILES['fixfile']['name'])) 
{
    $fixfile = $_FILES['fixfile']['name'];

	# Setup Output Module
	switchOutput($_POST['queue']);   
    
    $tmpfile = $_FILES['fixfile']['tmp_name'];
    process_upload($tmpfile);
}
?>
