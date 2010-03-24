#!/usr/bin/perl

$maindir="$ARGV[0]";

$source="192.168.0.200";
$user="xbox";
$pass="xbox";
$dir="/F/games/";

opendir(DIR, $maindir) or die "Cannot opendir $maindir because $!\n"; 
@array=readdir(DIR);
$inc=0;

foreach (@array)
{
 $item = $_;
 if ( $item =~ m/iso$/ ) {
        print "Adding: ".$item."\n";
	system( "xbiso",$item,"-f","-h",$source,"-u",$user,"-p",$pass,"-i",$dir);
        $inc++;
 } else {
  $subdir="$maindir$item";
  if (-d $subdir) {
  	opendir(SUB,$subdir) or die "Cannot opendir $item because $!\n";
  	@subarray=readdir(SUB);
  	foreach (@subarray) 
  	{
    	$subitem = $_;
    	if ( $subitem =~ m/iso$/ ) {
		$subfile = "$subdir/$subitem";
        	print "Adding: ".$subfile."\n";
	        #system( "xbiso",$item,"-v -f -h",$source,"-u",$user,"-p",$pass,"-i",$dir);
        	$inc++;
        }
  	}
   }
 }

}
