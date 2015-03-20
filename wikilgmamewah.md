# Introduction #

The Mamewah filtered lists supported by listgen provide an easy way to sort set of files into a number of lists you can use in the frontend provided those files are named in accordance with the Cowering Goodtools naming conventions.

To create a set of filtered lists for use with Mamewah you will use your own Have.txt file as the input. This will customise the results to your specific set of files.

_For example:_
```
The user has a 2600Have.txt file; this contains the results of a completed "Good2600.exe ren" scan. This file should be used as input in the "Select Input File" box of listgen
```

listgen will then scan through the Have.txt matching criteria to create one of the 110 lists available as part of this output module.

**Available Lists**

  * All Games
    * Every item contained in the input file.
  * Verified Good Dumps
    * _Matches "[[!]]"_
  * USA
    * _Matches "(U)"_
  * Japan
    * _Matches "(J)"_
  * Europe
    * _Matches "(E)"_
  * Multi-Region (English)
    * _Matches "(JUE)" and "(W)"_
  * Unlicensed
    * _Matches "(Unl)"_
  * Public Domain
    * _Matches "(PD)"_
  * Pre-Release
  * Miscellaneous
  * Hacks

_Example of 2600Have-7.ini
```
### 2600Have-7.ini (mamewah v1.68) ###

list_title                                Public Domain

### Games List Settings ###
cycle_list                                1

### Execution Settings ###
pre_emulator_app_commandlines
emulator_commandline
post_emulator_app_commandlines

### Settings used by MAMEWAH ###
current_game                              1
```_

Each list created has the ability to hold information about the item. We gather this information from the file naming.

## File Information ##

**Status**

The _Status_ field is used as you would expect.

  * [!] - Verified Good Dump
  * [b - Bad Dump
  * [f - Fixed
  * [h - Hacked
  * (Hack) - Hacked
  * [o - Overdump
  * [a - Alternate Dump
  * (Unl) - Unlicensed
  * (PD) - Public Domain
  * (Beta) - Beta
  * [T - Translation
  * [t - Trained
  * (Proto - Prototypes

_Example of Sega Megadrive-8.lst_
```
36 Great Holes Starring Fred Couples (32X) (E) (Prototype - Dec 13, 1994)
36 Great Holes Starring Fred Couples (32X) (E) (Prototype - Dec 13, 1994)
Europe
Prototype
```

**Region/Language**

The _Unknown_ field is used to hold the region and/or language of the item.

  * (G) - German
  * (U) - USA
  * (S) - Spanish
  * (B) - Non-USA
  * (E) - Europe
  * (F) - France
  * (A) - Australia
  * (UE) - English
  * (J - Japan
  * (W) - World
  * (JUE) - World

_Example of Nintendo NES-1.lst_
```
10-Yard Fight (U) [!]
10-Yard Fight (U) [!]
USA
Verified Good Dump
```

**Translations**

The _Colours_ field is used to hold additional translation information.

  * [T- - Translation Other (Old Version)
  * [T+ - Translation Other (Latest Version)
  * T-Eng - Translation English (Old Version
  * T+Eng - Translation English (Latest Version)

_Example of Nintendo Gameboy Advance-11.lst_
```
Battle Network Rockman EXE 4.5 - Real Operation (J) [T-Eng0.1_Spikeman]
Battle Network Rockman EXE 4.5 - Real Operation (J) [T-Eng0.1_Spikeman]
Japan
Translation English (Old Version)
```

## Installation ##

**Mamewah 1.68+**
  1. The output zip contains both config and a files folder. _Each hold the generated file lists as required._
  1. Extract these folders into your Mamewah directory.

**Mamewah 1.67-**
  1. The output zip contains both ini and a files folder. _Each hold the generated file lists as required._
  1. Extract these folders into your Mamewah directory.

**Wah!cade**
Use the Mamewah 1.67 output format. Please see [Issue 1](http://code.google.com/p/sairuk-misc/issues/detail?id=1) for additional information.

You will need to manually rename the ini/lst files sequentially before installing them into your Wah!cade setup.

_You may rename the directory, ini and lst files to match your configuration._

**Notes:**
  * The format changed for the 1.68 release, therefore there are two mamewah outputs you can choose to generate.

[Return](wikilginfo.md)