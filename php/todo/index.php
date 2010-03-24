<?
########################################################################

# REFER CHANGELOG FOR /WANTED/ site

### DATABASE
$svr = 'localhost';
$db = 'todo';
$username = '';
$password = '';
$indpg = 'index.php';
$tblnm = 'wanted';

### MISC
$tbltl = 'TODO LIST';
$deldays = '3';
$uri = '';
########################################################################

//POST VARIABLES
$atitle = $_POST["atitle"];
$atype = $_POST["atype"];
$acomm = $_POST["acomm"];
$adate = date('c');
$dtitle = $_POST["dtitle"];
$i = 0;


//Connect to DB
$con = mysql_connect($svr,$username,$password);
if(!$con)
{
 die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);

//Main Table Query
$result = mysql_query("SELECT * FROM ". $tblnm ." ORDER BY Title");
$types = mysql_query("SELECT * FROM Types ORDER BY types");



/* 
//Old Multiple Delete Title[s]
if ($dtitle)
{
	array_walk($dtitle, 'wrap_each');
	$delete_ids = implode(",",$dtitle);
	mysql_query("DELETE FROM ". $tblnm ." WHERE Title IN ($delete_ids)");
	$dtitle = '';
	header('Location: '. $indpg );
}
*/

// Newer Mark as Actioned
if ($dtitle)
{
	foreach ( $dtitle as &$key ) {
	  	$delDate = date(c, strtotime("+$deldays day", time()));
		mysql_query("UPDATE ". $tblnm ." SET Actioned='Y',Compdate='$delDate' WHERE Title='$key' ");
		wrtRSSItem($uri,$key,'','COMPLETED','COMPLETED');
	}
	$dtitle = '';
	header('Location: '. $indpg );
}


// Add Title
if ($atitle)
{

	$atitle = str_replace("&","and",$atitle);

	//Add to DB
	mysql_query("INSERT INTO ". $tblnm ." (Title,Comment,Type,Date,Actioned) VALUES ('" . $atitle ."','" . $acomm ."','" . $atype ."','" . $adate ."','N')");

	wrtRSSItem($uri,$atitle,$acomm,$atype,'ADDED');
	
	$atitle = '';
	header('Location: '. $indpg );
}


// HTML Start Here otherwise will break screen refreshing

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
 <meta http-equiv="Content-type" content="text/html;charset=iso-8859-1" /> 
<title><? echo $tbltl; ?></title>
<style type="text/css">
	h2
	{
		font-family: courier;
		font-weight: bold;
		font-size: 20px;
	}
	td
	{
		white-space:nowrap;	
		overflow:hidden;
	}
	thead	 
	{ 
		background: #FAF8CC; 
	}
	thead td 
	{
		font-weight: bold;
		color: #7E354D;
	 
		border-width: 1px;
		border-style: solid;
		border-color: #7E354D;
	}
	tbody td 	 
	{
		font-family: helvetica;
		font-size: 12px; 
		padding-left: 4px;
		padding-right: 4px;
		padding-top: 2px;
	}
	table
	{
		table-layout: Fixed;
	}
	table.tblbrd  
	{
		border-width: 1px;
		border-style: solid;
		border-color: #7E354D;
	}
	td.tblbot
	{
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #7E354D;
	}
	td.del
	{
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #7E354D;
		text-decoration: line-through;
	}
	td.itemtitle
	{
		min-width: 250px;
		width:100%;
	}
	td.itemcomm
	{
		width: 150px;
	}
	td.itemdate
	{
		width: 80px;		
	}
	td.itemsearch
	{
		width: 100px;		
	}
	td.ralign
	{
		text-align: right;
		padding-right: 3px;
	}
	input 	
	{
		background: #FAF8CC;
	}
	input.title
	{
		width: 340px;
		background: #FAF8CC
		padding: 1px;
	}
	select  
	{
		background: #FAF8CC;
	}
	a	
	{
		color: #7E354D;
		text-decoration: none;
	}
	a:hover	
	{
		color: #7E354D;
		text-decoration: underline;
	}
</style>
</head>
<body>
	<center>
  		<table class="tblbrd" width="70%" border="0">
   		<tr>
    			<td align="center" width="100%">
     			<form action="<? $indpg; ?>" method="post">
     			<center>
    			<table width="100%" border="0">
    			<tr>
    			<td>
				Title: <input class="title" type="text" name="atitle" title="Input title of task"/>
			</td>
    			<td>
				Comment: <input class="title" type="text" name="acomm" title="Input Comments for this tesk"/>
			</td>
			<td width="100px">
				Type: <select name="atype" title="Select type to Add">

				<?
				//ComboBox
				while($row = mysql_fetch_array($types))
				{
				 if ( $row['types'] == 'House' ) {
				  echo (' <option selected="selected">'.$row['types'].'</option> '."\n");
				  } else {
				  echo (' <option value="'.$row['types'].'">'.$row['types'].'</option> '."\n");
			          }
				}
				?>

			</select>
			</td>
			<td width="50px"><center><input type="submit" value="Add" title="Add"/></center></td>
			<td width="20px"><center><a href="todo.rss"><img src="rss.jpg" height="20px" title="Rss Feed for New Tasks" border="0"/></center></a></td>
			<td width="20px"><center><a href="http://mimic/tflux/"><img src="tflux.png" height="20px" title="TorrentFlux-b4rt" border="0"/></a></center></td>
			</tr>
			</table>
		</form>
    		</td>
   	</tr>
   	<tr>
   	<td colspan="2" align="right">
    		<form action="<? $indpg; ?>" method="post">
			<table border="0" width="100%">
			
				<thead>
				<tr>
					<td class="itemtitle">Task</td>
					<!-- <td class="itemcomm">Comment</td> -->
					<td class="itemdate">Type</td>
					<td class="itemdate">Added</td>
					<td class="itemsearch"><center>Search</center></td>
					<td width="20px"><center>C</center></td>
				</tr>
				</thead>
				
				<tbody>
					<?
					while($row = mysql_fetch_array($result))
					  {
					  	if ( $row['Actioned'] == "Y")
					  	{
						  	$css = 'del';
						  	$candel = 'no';
						  	if ( $adate >= $row['Compdate'] )
							{
								mysql_query("DELETE FROM ". $tblnm ." WHERE Title='".$row['Title']."' ");
							}
					  	} else {
						  	$css = 'tblbot';
						  	$candel = '';
					  	}

					  	if ($row['Comment']) {
					  	 $comment = '*';
					  	} else {
					  	 $comment = '';
					  	 }
			  						  	
					  	echo (' <tr>
							<td class="'.$css.'" title="'.$row['Comment'].'">'.$row['Title'].$comment.'</td>
							<!-- <td class="'.$css.'" title="'.$row['Comment'].'">'.$row['Comment'].'</td> -->
							<td class="'.$css.'">'.$row['Type'].'</td>
							<td class="'.$css.'">'.$row['Date'].'</td>
							<td class="'.$css.'">'.srch_items($row['Title'],$row['Type']).'</td>
							');
						if (!$candel) {
						echo ('
							<td><input type="checkbox" name="dtitle[]" size="60" value="'.$row['Title'].'" title="Select Item"/></td>
					          </tr>
						');
						} else {
						echo ('
							<td><center><abbr title="Completed">Y</abbr></center></td>
					          </tr>
					          ');						
						}
					  }
					?>
				</tbody>

				<tfoot>
					<tr>
						<td colspan="6">
							<table width="100%" border="0">
								<td>&nbsp;</a></td>
								<td class="ralign" width="400px"><i>COMPLETED</i> tasks remain listed for <? echo $deldays ?> days</td>
								<td width="80px" colspan="2"><input type="submit" value="Completed" align="top" title="Mark Completed"/></td>
							</table>
						</td>

					</tr>
				</tfoot>
				
			</table>
		</form>
		</tr>
	</td>
	</tr>
</table>
</center>
</body>
</html>

<?
mysql_close($con);

function wrap_each(&$item)
{
    $item = "'$item'";
}

function srch_items($stitle,$stype)
{
	### QUOTATIONS
	$ebaysrch = '<a href="http://shop.ebay.com.au/?&_nkw=%22'. $stitle .'%22&_sacat=See-All-Categories" title="eBay" target="_blank">e</a>';
	$tnbsrch = '<a href="http://www.thenile.com.au/search.php?&s=%22'. $stitle .'%22" title="The Nile Bookshop" target="_blank">tN</a>';
	
	$stitle = preg_replace('/\s/','+',$stitle);
	### PLUS SYMBOL
	$iphsrch = '<a href="http://iphonexe.com/apps/search.php?query='. $stitle .'&x=0&y=0" title="iPhoneEXE" target="_blank">iP</a>';
	$tvsrch = '<a href="http://www.tvnzb.com/index.php?st=&t='. $stitle .'" title="TvNZB" target="_blank">tv</a>';
	$ensrch = '<a href="http://members.easynews.com/global4/search.html?gps='. $stitle .'" title="EasyNews" target="_blank">E</a>';
	$googsrch = '<a href="http://www.google.com.au/search?q=%22'. $stitle .'%22" title="Google" target="_blank">G</a>';
	$nzbmsrch = '<a href="http://nzbmatrix.com/nzb-search.php?search='. $stitle .'&cat=0" title="NZBMatrix" target="_blank">nM</a>';
	$stmsrch = '<a href="http://store.steampowered.com/search/?term='. $stitle.' title="Steam" target="_blank">St</a>';
	$imdbsrch = '<a href="http://www.imdb.com/find?s=all&q='. $stitle.'&x=0&y=0" title="IMDb" target="_blank">I</a>';
	$vcqsrch = '<a href="http://www.vcdq.com/index.php?genre=5&searchstring='. $stitle .'&x=0&y=0" title="VCD Quality" target="_blank">V</a>';
		
	switch($stype)
	{
		case "Movie":
			$itemsrch = $ensrch.' / '.$nzbmsrch.' / '.$vcqsrch.' / '.$googsrch.' / '.$imdbsrch.' / '.$ebaysrch;
			break;
		case "iPhone":
			$itemsrch = $ensrch.' / '.$googsrch.' / '.$iphsrch;
			break;
		case "Book":
			$itemsrch = $ensrch.' / '.$nzbmsrch.' / '.$googsrch.' / '.$ebaysrch.' / '.$tnbsrch;
			break;
		case "Steam":
			$itemsrch = $stmsrch.' / '.$googsrch;
			break;
		case "TV":
			$itemsrch = $ensrch.' / '.$tvsrch.' / '.$nzbmsrch.' / '.$googsrch.' / '.$imdbsrch.' / '.$ebaysrch;
			break;
		default:
			$itemsrch = $ensrch.' / '.$googsrch.' / '.$ebaysrch;
	}
	return($itemsrch);
}


function addRSSItem($rssFile, $firstItem, $item)
{

	if(!copy($rssFile, 'temp.rss')) die ('Backup Failed');
	$arrFile = file($rssFile);
	if(($fh = fopen($rssFile, 'w')) === 'FALSE') die ('Couldnt open '.$rssFile.' for writing');

/*
// Needs to be written to a new file at some point
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>The title of my RSS 2.0 Feed</title>
<link>http://www.example.com/</link>
<description>This is my rss 2 feed description</description>
<lastBuildDate>Mon, 12 Sep 2005 18:37:00 GMT</lastBuildDate>
<language>en-us</language>
</channel>
</rss>

*/
	$currLine = 0;
	$endLine = count($arrFile);
	while ($currLine <= $endLine) 
	{
		if($currLine == $firstItem) fwrite($fh, $item);
		fwrite($fh, $arrFile[$currLine]);
		$currLine++;
	}
	unlink('temp.rss');
	
}

function wrtRSSItem($uri, $atitle, $acomm, $atype, $status) {

	//Add to RSS Feed
	$rssdate = date('r');

	$rssguid = $uri . '/' . preg_replace('/\s/','+',$atitle);
	$data = "    <item>\n<title>[$status]:[$atype] - $atitle</title>\n".
	  "        <description>$acomm</description>\n".
	  "	   <pubDate>$rssdate</pubDate>\n".
	  "        <link>$uri</link>\n".
	  "        <guid>$rssguid.$status</guid>\n".
	  "    </item>\n";
	
	addRSSItem('/var/www/todo/todo.rss',8,$data);
	
}


?>
