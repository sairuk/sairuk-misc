# Introduction #

Converts CSV input from the Firefox Password Exporter Extension to KeepassX XML format for import

User may pass an optional KeepassX data file which will be included in the final output

**NOTE:** Output is sent to stdout redirect output to file if saving for import


## Requirements ##

Perl, tested on Ubuntu 9.10 Perl 5.10.0

## Usage ##
**Usage:** ff-pwd-exp-to-keepassx.pl exported-firefox-csv optional-keypass-xml
  * **exported-firefox-csv:** CSV file exported from the [Password Exporter](https://addons.mozilla.org/en-US/firefox/addon/2848/) extension using the default options
  * **optional-keypass-xml:** Optional KeepassX XML file to include in output.