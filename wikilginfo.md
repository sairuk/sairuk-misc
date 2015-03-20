# Introduction #

listgen will convert file list inputs into a number of output formats. This is intended for use with [Cowering Goodtools](http://www.allgoodthings.us/), [CLRMamePro](http://mamedev.emulab.it/clrmamepro/), [RomCenter](http://www.romcenter.com/) and generic listing input.

# Details #

## Supported Inputs ##
  * Cowering GoodTools (extendeed)
  * CLRMame/RC3 XML (extendeed)
  * CLRMame legacy DAT format (limited)
  * RomCenter legcay DAT format (extendeed)
  * Mame ListXML - (Not Support on this Server)
  * Unknown files are treated as generic (useful for basic lists)

## Supported Outputs ##
  * [HTML Listings](wikilghtmloutput.md)
    * Web Search Multiple
    * binsearch.info
    * Easynews Search
    * Ebay Australia Search
    * Ebay Search
    * Google Search
  * [File Transfer Queues](wikilgfilequeues.md)
    * Filezilla Filters File
    * WGET queue file
  * [Copy Scripts](wikilgcopyscripts.md)
    * Bash Shell Scripts
    * Batch Files
  * [Rename Scripts](wikilgrenamescripts.md)
    * CRC32.EXT to game name
    * NUM.EXT to game name
  * [Emulator Frontend Configs](wikilgemufrontends.md)
    * [Mamewah 1.67 Lists](wikilgmamewah.md) _(and prior)_
    * [Mamewah 1.68 Lists](wikilgmamewah.md)
    * mGalaxy XML List
    * XBMC Launcher XML List


All outputs can be obtained from each of the inputs unless specified in the tool tip of the item.