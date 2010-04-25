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

require_once('functions.php');

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
                        <li>Cowering GoodTools (extendeed)</li>
						<li>CLRMame/RC3 XML (extendeed)</li>
						<li>CLRMame legacy DAT format (limited)</li>
						<li>RomCenter legcay DAT format (extendeed)</li>
						<li>Mame ListXML <?php  if ( ini_get('memory_limit') < 128 ) { echo "<b><i> - (Not Support on this Server)</i></b>"; } ?></li>
						<li>Unknown files are treated as generic (useful for basic lists)</li>
						</ul>
						<i>Success for larger processing runs is dependant on server settings.</i>
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
										 <option>HTML Listings</option>
										 <option value="htmlall" selected="selected" title="Multiple Search Options in output">• Web Search (Multiple)</option>
										 <option value="binsearch">• binsearch.info</option>
										 <option value="easynews">• EasyNews Search</option>
										 <option value="ebayau">• eBay Australia Search</option>
										 <option value="ebay">• eBay Search</option>
										 <option value="google">• Google Search</option>
										 <option>&nbsp;</option>	
										 <option>File Transfer Queues</option>
										 <option value="filezilla">• FileZilla Filter</option>
										 <option value="wget">• wget queue</option>
										 <option>&nbsp;</option>		
										 <option>Copy Scripts</option>									 
										 <option value="msbat">• MSDOS batch</option>
										 <option value="bash">• Bash Script</option>
										 <option>&nbsp;</option>
										 <option>Rename Scripts</option>		
										 <option value="CRCmsbat" title="Rename files from CRC.EXT to a useful name">• MSDOS batch CRC</option>
										 <option value="msbatnumbered" title="Rename files from NUMBER.EXT to a useful name">• MSDOS batch NUM</option>
										 <option>&nbsp;</option>
										 <option>Emulator Frontends</option>
										 <option value="mamewah" title="Best support for Goodtxts">• MameWah &lt;1.67 Filtered Lists</option>
										 <option value="mamewah168" title="Best support for Goodtxts">• MameWah 1.68 Filtered Lists</option>
										 <option value="mGalaxy" title="Version number must be manually added to final output">• mGalaxy Database</option>
										 <option value="xbmclauncher">• XBMC Launcher Rom List</option>
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
				<?php echo " $projName, Version: $projVer (SVN Version: ".getSCID().") written by: $projAuth " ?>
				&nbsp; --- &nbsp;<a href="http://code.google.com/p/sairuk-misc/wiki/wikilginfo">Wiki Page</a>
				&nbsp; --- &nbsp;<a href="http://code.google.com/p/sairuk-misc/">Google Code</a>
				&nbsp; --- &nbsp;<a href="/listgen">Reload Page</a>
				<hr></hr>
			</td>
		</tr>
		</table>
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