<?php

# User settings
define("UAGENT","Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008092416 Firefox/3.0.3"); // user agent
define("SAVE","/usr/torrentflux/uploads/"); // save path

# REGEXs
define("BLKEXT","tbn$|jpg$|nfo$"); //Black list of extension you do not want to process locally
define("IDREGEX","/(?<=id=)\d+/"); // match id="NUMBER" used to match downloads
define("SEEPRGX","/^.*(?=s([0-9]+)e([0-9]+))|^.*(?=s([0-9]+).e([0-9]+))|^.*(?=([0-9]+)x([0-9]+))/i");

# Server settings
define("DB","nzbcron.sqlite"); // Database name
define("COOKPATH","cookies/"); // Cookies storage path
define("INCDIR","includes/"); // includes directory
