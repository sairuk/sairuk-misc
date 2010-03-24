<?

require('globals.php');
require('dbconn.php');
require('functions.php');

    $type = $_REQUEST["type"];
    $min = $_GET['min'];
    $max = $_GET['max'];
    $query = $_POST['searchbox'];
    $region = $_GET['region'];

    if ( !isset($min))
    { // Leave $min as is
     $min = 0;
    }
    
    if ( !isset($max) || ( $max > 60 )) 
    { // 60 is always our maximum
         if ( $max < 60 ) {
            $max = 10;
         } else {     
            $max = 60;
        }
    }

    if (isset($_POST['grabCover']))
    {
       grabcover();
    }
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
                 switch ($type) {
                       case textlist:
                            nav_textlist($tblcells);
                            break;
                       case search:
                            nav_textlist($tblcells);
                            break;
                       case numsearch:
                            nav_textlist($tblcells);
                            break;
                       case update:
                            break;
                       default:
                           nav_main($min,$max,$null,$region);
                } 
  ?>
  </td>
  </tr>

  <tr>
   <td><? 
                switch ($type) {
                       case textlist:
                            textlist($tblnm);
                            break;
                       case search:
                            textsearch($query,$min,$max,$tblnm,$artwork);
                            break;
                       case numsearch:
                            numsearch($query,$min,$max,$tblnm,$artwork);
                            break;
                       case newitems:
                            newitems("20",$tblnm,$artwork);
                            break;
                       case update:
                            builddb($dir1,$tblnm);
                            break;
                       default:
                            buildpage($min,$max,$tblnm,$artwork,$region);  
                }
          ?>
   </td>
  </tr>
  <tr>
  <td colspan='.$tblcells.'>
  <? 
                 switch ($type) {
                       case textlist:
                            nav_textlist($tblcells);
                            break;
                       case search:
                            nav_textlist($tblcells);
                            break;
                       case numsearch:
                            nav_textlist($tblcells);
                            break;
                       case update:
                            break;
                       default:
                             nav_main($min,$max,$tblcells,$region);
                } 
  ?>
  </td>
  </tr>
 </table>
</body>
</html>
