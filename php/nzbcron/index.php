<?php 

/*
 * Checks RSS feeds for NZBs
 * 
 * TODO
 * fix hardcoded type in redo_login
 */

	 
@require("includes/conf.php");
@require("includes/functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>NZBcron</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo INCDIR ?>style.css" />
</head>

<body>

<?php 

@include(INCDIR."header.html");

switch ($_GET['func']) {
	case login:
		redo_login();
	break;
	case create:
		build_db();
	break;
	case watch:
		watchnzb();
	break;
	case admin:
		admin_page();
	break;
	case about:
		@include(INCDIR."/about.html");
	break;
	default:
		index();
}

switch ($argv[1]) {
	case login;
		redo_login();
	break;
	case watch;
		watchnzb();
	break;
}

?>

</body>
</html>
