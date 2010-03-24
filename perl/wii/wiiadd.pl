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
		system( "wbfs","-p",$source,"add",$subfile);
        	$inc++;
        }
  	}
   }
 }

}
