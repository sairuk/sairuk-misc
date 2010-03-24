<?php

### DATABASE
$svr = 'localhost';
$db = 'nds_games';
$username = '';
$password = '';
$indpg = 'index.php';

//Connect to DB
$con = mysql_connect($svr,$username,$password);

if(!$con)
{
 die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);

?>
