#!/usr/bin/perl

$maindir="/home/sairuk/tmp/wii/";

opendir(DIR, $maindir) or die "Cannot opendir $maindir because $!\n"; 
@array=readdir(DIR);
$source=$1;
$inc=0;

foreach (@array)
{
 $item = $_;
 if ( $item =~ m/iso$/ ) {
        print "Adding: ".$item."\n";
	system( "wbfs","-p",$source,"add",$item);
        $inc++;
 }

}
