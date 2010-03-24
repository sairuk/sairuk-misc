<?

function preg_ext(&$items,$name)
{
 $item = $items."$";
   if (preg_match('/'.$item.'/i',$name));
   {
	   return($name);
   }
 }

function buildpage($minresults,$maxresults,$tblnm,$artwork,$region)
{
//Main Table Query
if ( $region == "all" ) {
 $result = mysql_query("SELECT * FROM ". $tblnm ." ORDER BY Title LIMIT ".$minresults." , ".$maxresults."");
} else {
 $result = mysql_query("SELECT * FROM ". $tblnm ." WHERE Region = '".$region."' ORDER BY Title LIMIT ".$minresults." , ".$maxresults."");
}
$title = "Current Games on Server";

rendertable($tblnm,$title,$result,$artwork);

}

function newitems($maxresults,$tblnm,$artwork)
{
//Main Table Query
$result = mysql_query("SELECT * FROM ". $tblnm ." WHERE Number NOT LIKE 'x%' ORDER BY number DESC LIMIT ".$maxresults."");

$title = "New Games on Server";

rendertable($tblnm,$title,$result,$artwork);

}


function rendertable($tblnm,$title,$result,$artwork)
{

  global $cover,$image;

    $cellcnt = 1;
    $tblcells = 5;
#    $arturl = "http://img.rom-freaks.net/";
	$arturl = "http://localhost/";

echo	('
	<table>
         <tr>
	  <td colspan="2"><h2>'.$title.'</h2></td>
   <td colspan="2">
    <form action="index.php?type=search" method="post">
        Title Search: <input type="text" name="searchbox" />
        <input type="submit" name="query" value="Search"/>
    </form>
   </td>
   <td colspan="1">
    <form action="index.php?type=numsearch" method="post">
        Release#: <input type="text" name="searchbox" maxlength="5" size="5"/>
        <input type="submit" name="query" value="Search"/>
    </form>
   </td>
  </tr>
  <tr>
  <td><a href=index.php?type=newitems&region=all>Newest 20 Releases</a></td>
  <td><a href=index.php?type=nds&region=all>All Releases</a></td>
  <td><a href=index.php?type=nds&region=europe>European Releases</a></td>
  <td><a href=index.php?type=nds&region=usa>USA Releases</a></td>
  <td><a href=index.php?type=nds&region=japan>Japanese Releases</a></td>
  <td>&nbsp;</td>
	 </tr>
	');

    while($row = mysql_fetch_array($result))
    {
    
            $image = $artwork.'/'.$row['Number'].'.jpg';
	    $searchtitle = chop(preg_replace('/\ /','+',$row['Title']));
            $cover = "http://www.google.com.au/search?q=".chr(34).$searchtitle.chr(34)."+nds+review";
	    #$cover = "http://search.gamestats.com/products?query=".chr(34).$searchtitle.chr(34)."&platformSearch=Nintendo+DS";
 
	   if (!file_exists($image)) {
             $image = $artwork."/noimage.jpg";
   	     }

             $covdisplay = '<a href='.$cover.' target="_blank"><img src="'.$image.'" title="Check for game information by Google Search" border="0"/></a>';

            // Set Region Flags
            switch ($row['Region']) {
                case USA:
                    $regionimg = 'img/usa.gif';
		    $regionlnk = 'index.php?type=nds&region=usa';
                     break;
                case Japan:
                    $regionimg = 'img/japan.gif';
		    $regionlnk = 'index.php?type=nds&region=japan';
                     break;
                case Korea:
                    $regionimg = 'img/skorean.gif';
		    $regionlnk = 'index.php?type=nds&region=korea';
                     break;
                default:
                    $regionimg = 'img/europe.gif';
		    $regionlnk = 'index.php?type=nds&region=europe';
            }
            
        	echo(' 
            	 <td>
            	    <table class="module" border="0">
            	    <tr>
            	        <td class="covimage" colspan="3">'.$covdisplay.'</td>
            	    </tr>
            	    <tr>
            	        <td class="subtextL"><a href="'.$regionlnk.'"><img src="'.$regionimg.'" title="'.$row['Region'].'" height="20px" border="0"/></a></td>
            	        <td class="subtextR">'.$row['Language'].'</td>
            	        <td class="subtextR">'.$row['Number'].'</td>
		           </tr>
            	    <tr>
            	        <td class="titletext" colspan="3">'.$row['Title'].'</td>
		           </tr>
		           </table>
            	 </td>
        	');
        	
                if ( $cellcnt == $tblcells ) {
              	    echo(' <tr></tr> ');
              	    $cellcnt = 1;
              	} else {
              	    $cellcnt++;
              	}
     }
    echo(' </table> ');
}

function textlist($tblnm)
{

$tblcells = 4;

//Main Table Query
$result = mysql_query("SELECT * FROM ". $tblnm ." ORDER BY Title");
// Select * From nds_games ORDER BY Title Limit 0 , 30

        	echo(' 
            	       <tr>
            	        <td class="textlist1">Title</td>
            	        <td class="textlist2">Release #</td>
            	        <td class="textlist2">Region</td>
            	        <td class="textlist2">Language</td>
            	        </tr>
        	');

    while($row = mysql_fetch_array($result))
    {
        	echo(' 
            	       <tr>
            	        <td class="textlist1">'.$row['Title'].'</td>
            	        <td class="textlist2">'.$row['Number'].'</td>
            	        <td class="textlist2">'.$row['Region'].'</td>
            	        <td class="textlist2">'.$row['Language'].'</td>
            	        </tr>
        	');
      }
}

function nav_main($min,$max,$tblcells,$region)
{
    
    $next = $min+$max;
    $prev = $min-$max;

    echo " <table border=1 width=100%>";
    echo "<a href=index.php?type=nds&region=$region&min=$prev&max=$max><img src=img/header_left.jpg border=0/></a>";
    echo "<a href=index.php?type=textlist><img src=img/header_mid.jpg border=0/></a>";
    echo "<a href=index.php?type=nds&region=$region&min=$next&max=$max><img src=img/header_right.jpg border=0/></a>";
    echo "</table>";
}

function nav_textlist($tblcells)
{
   echo " <a href=index.php?type=nds><img src=img/header_mid.jpg border=0/></a>";
}


function textsearch($query,$minresults,$maxresults,$tblnm,$artwork)
{
    $query = preg_replace('/\s/','%',$query);
    $result = mysql_query("SELECT * FROM ". $tblnm ." WHERE Title LIKE '%$query%' ORDER BY Title LIMIT ".$minresults." , 100");
    
    $title = "Search Results (max 100)";
    rendertable($tblnm,$title,$result,$artwork);

}

function numsearch($query,$minresults,$maxresults,$tblnm,$artwork)
{
    $result = mysql_query("SELECT * FROM ". $tblnm ." WHERE Number LIKE '%$query%'");
    
    $title = "Release# $query";
    rendertable($tblnm,$title,$result,$artwork);

}

function grabcover() 
{
                $content = '';
                $fp = @fopen($cover,"r");
                if(!$fp) {
                        $image = $artwork."/broken.jpg";
                   }
               while(!feof($fp))
               {
                $content .= fread($fp, 2048);
                fclose($fp);
                $fp=fopen("$image","w");
                fwrite($fp,$content);
                fclose($fp);
               $image = $image;
               }

}


?>
