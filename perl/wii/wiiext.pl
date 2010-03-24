#!/usr/bin/perl

$path = '/home/sairuk/tmp/wii/';
$source = $ARGV[0];

$wbfs_file = "wbfs -p $source ls > hdcont.wii 2>&1";
@wbfs_test = `$wbfs_file`;

open(FILE, $path."hdcont.wii");
@array=<FILE>;
$inc=0;

foreach (@array)
{
$item = substr($_,0,6);
 if ( $item !~ m/\s/ ) {
        print "\n"."Extracting: ".$item."\n";
        system( "wbfs","-p",$source,"extract",$item);
        $inc++;
        wait;
        }
}
print "Total Games: ".$inc."\n";

