<? 
require_once('config.php');
require('functions.php'); 
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
