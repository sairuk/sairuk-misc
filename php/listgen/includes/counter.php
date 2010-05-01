<?php

$countfile = DOCROOT . "/counter.log";

if ( file_exists($countfile)) {
	$count = file($countfile);
	$count[0]++;
	$fp = fopen($countfile, "w");
	fputs($fp , "$count[0]");
	fclose($fp);
} else {
	touch($countfile);
}
