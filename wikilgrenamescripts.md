# Introduction #
Rename Scripts are used in directories of files to perform a batch rename function. Final output format from both items will result in a zipped results file for the user to download and use locally.

**MSDOS Batch CRC**

Will generate a compatible batch file for use with windows/msdos which can be run in a directory and rename files named by CRC to the game name. This is useful for renaming no-intro screenshot packs for use with emulator frontends.

_Example from Nintendo Game Boy Advance (20061119\_RC).bat_
```
@echo off
ren "0e556edf.*" "Adventures of Jimmy Neutron Boy Genius, The - Volume 1 (U) (Video).*"
ren "ffbd4da9.*" "All Grown Up - Volume 1 (U) (Video).*"
```


**MSDOS Batch NUM**

Will generate a compatible batch file for use with windows/msdos which can be run in a directory and rename files named by Number to the game name. This is useful when artwork is named by release number and it needs a useful name for use with emulator frontends.

_Example PocketHeaven\_GBA\_Release\_List\_Roms(2819)[CM](CM.md).bat_
```
@echo off
ren "0001.*" "F-Zero (J)(Independent).*"
ren "0002.*" "Super Mario Advance (J)(Independent).*"
```

[Return](wikilginfo.md)