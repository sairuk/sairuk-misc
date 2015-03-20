# Introduction #

Emulator frontends outputs are used to generate compatible information for use with frontends where previously it was limited to a basic directory scan or manual input. This is now be a batch operation with additional information added automatically when detected (Country/Region, Year, Producer, etc)

**Mamewah Filtered Lists**

Mamewah filtered lists are used by the frontend to provide additional list types for a particular platform. In listgen the Mamewah filtered list options provide output which provides lists based on region, status and type.

_This output module only supports Cowering Goodtool formatting_

It is a large topic so additional information on [Mamewah Filtered Lists](wikilgmamewah.md) is available.

**mGalaxy Database**

Generates a compatible xml file for use with the mGalaxy Frontend. A decent enough frontend. Default filename for use with mGalaxy is mg\_mamedb.xml

**Notes:**
  * The intention for this feature is for use with mame -lx output but it will work as well with any input
  * The user will need to input the value for "mame build" into the xml manually once the file is created. 

&lt;mame build=""&gt;



_Example from mg\_mamedb.xml_
```
<?xml version="1.0"?>
<mame build="">
<game name="cliffhgr" cloneof="cliffhgr">
	<description>cliffhgr</description>
</game>
<game name="cobra" cloneof="cobra">
	<description>cobra</description>
</game>
<game name="crszone" cloneof="crszone">
	<description>crszone</description>
</game>
```


**XBMC Launcher Rom List**

Generates a compatible xml file for use with the xbmc-launcher plugin saving the user from manually adding roms. It will automatically add "romname.png" so you may configure the plugin and populate a directory with images to support the roms. The resulting xml must be installed into the plugin data directory under userdata.

_Example from xbmc-launcher\_roms.xml_
```
<roms>
<rom>
<name>Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown</name>
	<filename>Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown</filename>
<thumb>Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown.png</thumb>
</rom>
<rom>
<name>Arcade Minor Emus - DEMUL (v0.5.5) - beachspi</name>
	<filename>Arcade Minor Emus - DEMUL (v0.5.5) - beachspi</filename>
<thumb>Arcade Minor Emus - DEMUL (v0.5.5) - beachspi.png</thumb>
</rom>
<rom>
```

[Return](wikilginfo.md)