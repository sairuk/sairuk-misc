<?php

require('functions.php');
session_start();

global $modname;
global $fixfile;
global $ext;
global $name;
global $outfile;
global $xmlhndl;
global $rompath;

if (isset($_POST['rompath']))
{
	$rompath = stripslashes($_POST['rompath']);
	echo $rompath;
}

?>
<html>
    <head>
    <title>File List Convert</title>
	<style>
	body 
	{
		background: #FFFFFF;
		color: #000000;
	}
	td 
	{
		font-size:12px;
		font-family: arial;
	}
	select
	{
		color: white;
		background: #5C5858;		
	}
	input
	{
		font-weight: bold;
	}
	
	</style>
    </head>
    <body>
        <table border="0" width="50%">
            <tr>
                 <td><h3>listgen - v0.3</h3>
                        Accepts miss/have txts, cmpro fixdats & mame listxml*, converts to chosen output formats.<br />
                        &nbsp;<br />
						* listxml Needs a large memcache for php >128mb, limited item support
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
							</td>
								</form>
							</td>
						</tr>
					</table>
					
                </td>
            </tr>
	<tr><td colspan="3"><a href="/listgen">Reload Page</a></td></tr>
        </table>
    </body>
</html>

<?php

# Set Extension Variable
$ext = ".".$_POST['ext'];

# Process File Upload
if (isset($_FILES['fixfile']['name'])) 
{
	
    $fixfile = $_FILES['fixfile']['name'];
    $tmpfile = $_FILES['fixfile']['tmp_name'];
    process_upload($tmpfile);
	#$fixfile = session_id() . '_' .basename($_FILES['fixfile']['name']);
	#$fixfile = basename($_FILES['fixfile']['name']);
}

# Custom Extension Processing
if ($_POST['ext'] == "custom" )
{

    $ext = ".".$_POST['custext'];
}

if (isset($fixfile)) {

    $name = substr($fixfile,0,strlen($fixfile)-4);

   # Outputs
   switch ($_POST['queue']) { 
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

/*
    # Inputs
    switch ($_POST['dattype']) {
        case cmpro:
            read_cmproxml(17);
            break;
        case misstxt:
            read_txtlist(2);
            break;
        case stdtxt:
            read_txtlist(0);
            break;
         default:
            echo "Nothing to do here jim";
    }
 */

check_file();

}

?>
