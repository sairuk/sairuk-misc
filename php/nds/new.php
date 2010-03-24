<?

require('globals.php');
require('dbconn.php');
require('functions.php');

?>

<html>
<head>
<title><? echo $tbltl; ?></title>
<LINK href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
 <table border="0">
  <tr>
    <td colspan="4">
     <?
	nav_main($min,$max,$null);
	newitems(20,nds_games,$artwork); 
	nav_main($min,$max,$null);
     ?>
  </td>
  </tr>
 </table>
</body>
</html>
