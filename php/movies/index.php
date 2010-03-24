<?

# Configuration Options
#
# Left Set
 $dir1 = "current";
 $title1 = "Current";
#
# Right Set
 $dir2 = "new";
 $title2 = "Upcoming";
#
# Not Currently Used
#
# Media Types
 $mtype = "avi|mpg|mp4|mov|ogg|ogm|mkv";
#
# Stacked Types
 $stype = "cd|CD0|CD|disc|d";
#

?>

<html>
<head>
<title>Movies</title>
<style>
 body
 {
  font-family:arial,helvetica,sans;
 }
 a
 {
  font-size: 10pt;
  text-decoration: none;
 }
 a:hover
 {
  color: black;
 }
 table
 {
  width: 500px;
  align: center;
 }
 td
 {
  width: 250px;
  vertical-align: top;
 }
</style>
</head>
<body>
 <table border="0">
  <tr>
   <td><? buildpage($dir1,$title1); ?></td>
   <td><? buildpage($dir2,$title2); ?></td>
  </tr>
 </table>
</body>
</html>

<?

function buildpage($location,$title) {

$filename = dir($location);

while(($line = $filename->read()) !== false)
{
if ( preg_match('/avi$|mpg$|mp4$|mov$|ogg$|ogm$|mkv$/i',$line)) 
  {

   if ( preg_match('/cd2/i',$line))

    {
     #dont do anything atm
    } else {
     $line = preg_replace('/cd1|-cd1/i','',$line);
     $line = substr($line,0,strlen($line)-4);
     $cat = $cat.'|'.$line;
    }

  }

}

$array = explode('|',$cat);
$count = count($array)-1;

sort($array);

echo ('<table>
	<tr><td><h4>'.$title.' Movies on Server - ('.$count.')</h4></td></tr>
');

foreach ($array as $key => $val) {
	$link = preg_replace('/\s/','+',$val);
	#removes additional space at begginning of title
	$val = preg_replace('/^ /','',$val);

# Prints a valid IMDB link in HTML
if ( ord($link) != 0 ) {
    	echo(' <tr>
            <td>
		<a href="http://www.imdb.com/find?s=all&q='.$link.'&x=0&y=0" title="Search IMDB" target="_blank">'.$val.'</a>
            </td>
          </tr>
        ');
	}
}

echo ('
	</table>
	');
}

function preg_walk(&$items)
{
 if (preg_match('/'.$items.'$/i',$line))
 {
  return;
 }
}

?>
