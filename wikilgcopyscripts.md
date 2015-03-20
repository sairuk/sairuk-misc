# Introduction #
Copy Scripts are used in directories of files to perform a batch copy function to a new directory. Final output format from both items will result in a zipped results file for the user to download and use locally.

**Bash Script**

Will generate a shell script for the bash shell which can be run in a rom directory and make a copy of the files the input listed.

_Example from fix\_Arcade - NonMAME ROMs (v0.136\_XML).sh_
```
#!/bin/bash
mkdir _goodfill
cp "Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown.*" ./_goodfill/
cp "Arcade Minor Emus - DEMUL (v0.5.5) - beachspi.*" ./_goodfill/
```


**MSDOS Batch**

Will generate a compatible batch file for use with windows/msdos which can be run in a rom directory and make a copy of the files included in the input.

_Example from fix\_Arcade - NonMAME ROMs (v0.136\_XML).bat_
```
@echo off
md _goodfill
copy "Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown.*" _goodfill
copy "Arcade Minor Emus - DEMUL (v0.5.5) - beachspi.*" _goodfill
```

[Return](wikilginfo.md)