<?php 

@require("includes/conf.php");
@require("includes/functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>NZBcron - ADMIN</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo INCDIR ?>style.css" />
</head>

<body>

<?php 

@include(INCDIR."header.html");

switch ($_GET['func']) {
	case maintdl:
		maint_dl_table();
	break;
	case maintwatched:
		maint_tbl("watched");
	break;
	case maintfeeds:
		maint_tbl("feeds");
	break;
	case maintsites:
		maint_tbl("sites");
	break;
	case maintlibpaths:
		maint_tbl("libpaths");
	break;
	case buildlib:
		buildlib("libpaths");
	break;
	default:
		echo " ";
}


?>

</body>
</html>
