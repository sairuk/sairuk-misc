# Introduction #
Randomly builds a mapcycle.cfg for quake(world) servers when executed.

## Requirements ##
  * [PERL](http://www.perl.org/)
  * A Quake(world) server (ie [MVDSV](http://qw-dev.net/projects/show/mvdsv/))
  * PAK.TXT (See below)

## Installation ##
  1. Copy mapcycle.pl to the root directory of the quake(world) server (next to the server executable)
  1. Create or Edit PAK.TXT with all maps included in pak files (see below for an example pak.txt). The pak.txt is required to be in the same directory as mapcycle.pl
  1. Add mapcycle.pl to your server start up script

## Usage ##
**Usage:** mapcycle.pl modname numrounds
  * **modname:** name of data directory where the maps subdirectory is stored (ie id1)
  * **numrounds:** how many rounds/maps to build a mapcycle.cfg for.

**Example:** perl mapcycle.pl id1 3

### Example Directory Structure ###
```
id1/
ktx/
qw/
changes.txt
start_server.bat
start_server.sh
stop_server.bat
mapcycle.pl
pak.txt
mvdsv.exe
README.TXT
mvdsv
```

### Example PAK.TXT ###
```
dm1.bsp
dm2.bsp
dm3.bsp
dm4.bsp
dm5.bsp
dm6.bsp 
```

### Example Server Start Script ###
**Batch File** for MVDSV start up.
```
@echo off
cls
echo "Generating Map Rotation"
perl mapcycle.pl id1 3
echo "Starting Quakeworld Dedicated Server"
START /B mvdsv.exe -minimize >> .\mvdsv.log
```