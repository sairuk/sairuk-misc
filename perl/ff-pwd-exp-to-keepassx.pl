#!/usr/bin/perl

# Convert Firefox Password Exporter to KeepassX XML format
my $creation_date = "2010-06-03T23:01:17";
my $lastaccess_date = "2010-06-03T23:01:33";
my $lastmod_date = "2010-06-03T23:01:33";

print "\n";
print "Firefox to KeepassX Converter v0.1beta - Wayne Moulden 2010\n";
print " Converts CSV input from the Firefox Password Exporter\n";
print " Extension to KeepassX XML format for import\n\n";
print " User may pass an optional KeepassX data file which will\n";
print " be included in the final output\n";
print " NOTE: Output is sent to stdout redirect output to file if\n";
print " saving for import\n\n";

if ( @ARGV > 0 ) 
{
	$data_file = $ARGV[0];
	$append_file = $ARGV[1];
} else {
        print " Usage: $0 \<exported-firefox-csv\> \<optional-keypass-xml\>\n";
	print "\n";
        exit(1);
}

open(DAT, $data_file) || die("Could not open file! $data_file");
@raw_data=<DAT>;

print "<!DOCTYPE KEEPASSX_DATABASE>\n";
print "<database>\n";
print " <group>\n";
print "  <title>Imported</title>\n";
print "  <icon>1</icon>\n";

$i = 0;
foreach $line (@raw_data)
{
 $i++;
  if ( $i > 2 ) {
	chomp($line);
	$line =~ s/\"//g;;
	my @values = split(',', $line);
	print "<entry>\n";
	print "  <title>$values[0]</title>\n";
	print "  <username>$values[1]</username>\n";
	print "  <password>$values[2]</password>\n";
	print "  <url>$values[0]</url>\n";
	print "  <comment>Converted with $0</comment>\n";
	print "  <icon>0</icon>\n";
	print "  <creation>$creation_date</creation>\n";
	print "  <lastaccess>$lastaccess_date</lastaccess>\n";
	print "  <lastmod>$lastmod_date</lastmod>\n";
	print "  <expire>Never</expire>\n";
	print " </entry>\n";
  }
}
close(DAT); 

  if ( $append_file ) {
	# Append Keepass exported file contents
	open(DAT, $append_file) || die("Could not open file!");
	@raw_data=<DAT>;
	
	my $total = @{raw_data};

	$i,$x = 0;
	foreach $line (@raw_data)
	{
	$i++;
		if ( ( $i == "1" ) && ( ! $line =~ '/KEEPASS/' ) )
		{
			print "Not a Keepass Export File, will not include\n";
			exit(1);
		}

		if ( $i > 3 ) {
			if ( $x <= $total )  { 
 				print $line;
			}
		$x++;
		}
	}
  } else {

  print "</group>\n";
  print "</database>\n"

  }
