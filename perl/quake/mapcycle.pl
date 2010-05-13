#!/usr/bin/perl
#
#
# Random QUAKEWORLD MapCycle.txt Generator
#
# Reads BSP files from id1/maps
# Usage: mapcycle.pl modname numrounds
#  Add *.pak file maps to pak.txt store file 
#  with script in server root dir.
#
# Known Issues
# .Will read "." & ".." as files under linux
#
use List::Util 'shuffle';

my $MAPDIR = $ARGV[0];
my $NUMROUNDS = $ARGV[1];
my $PAKLST = "pak.txt";

if ( !defined($MAPDIR) || !defined($NUMROUNDS) ) {
 print "Random QuakeWorld mapcycle.cfg Builder\n";
 print "Copyright (C) 2008 sairuk\n";
 print "\n";
 print "Usage: perl $0 <Mod Directory> <Number of Rounds>\n";
 print "\n";

 exit;
}
# Open $MAPDIR/mapcycle.cfg for Writing
open(MCYC, '>'.$MAPDIR.'/mapcycle.cfg');

# Read Maps in $MAPDIR/maps/
opendir(Q1M,$MAPDIR."/maps/") || die("Cannot open $MAPDIR");
@maps = grep { /\.bsp$/ } readdir(Q1M);

# Read Map from pak.lst (for maps in pak files)
open(Q1P,$PAKLST) || die("Cannot open $PAKLST");
@pak = grep(s/[\r\n]//g,<Q1P>);

# Join lists
push(@maps,@pak);

# Randomise the Maplist
@maps = shuffle(@maps);

# Reserves Map 0 for final line
$sMAP = $maps[0];
$sMAP =~ s/\.bsp//g;

# Starting Map for Read
$c=0; $d=$c+1;

until ($c == $NUMROUNDS ) {
 $maps[$c] =~ s/\.bsp//g;
 $maps[$d] =~ s/\.bsp//g;
 print MCYC "localinfo ".$maps[$c]." ".$maps[$d]."\n";
 $c++; $d++;
 }

# MapCycle.txt Footer
print MCYC "localinfo ".$maps[$c]." ".$sMAP."\n";
print MCYC "map ".$sMAP."\n";
closedir(Q1M);
close (MCYC);
