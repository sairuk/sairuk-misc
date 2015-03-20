# Introduction #

File Transfer Queue outputs provide a means to batch get items from ftp or http protocols.

**Filezilla Filter**

Builds a filezilla filter xml file. This is then places in the filezilla data folder _replacing the existing one_ and will be active next time you launch filezilla. Filezilla filters will display only files which match the patterns requested. In this case the patterns we add are the required filenames.

_Backup your existing filters.xml before using this option_

Filter options are accessed through the _View->Filename Filters_ menu.

**Notes:**
  * Filters will remain active until turned off in the options.

_Example from filters.xml_
```
?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<FileZilla3>
    <Filters>
        <Filter>
          <Name>filters.xml</Name>
          <ApplyToFiles>1</ApplyToFiles>
          <ApplyToDirs>0</ApplyToDirs>
          <MatchType>None</MatchType>
          <MatchCase>0</MatchCase>
          <Conditions>
<Condition>
<Type>0</Type>
<Condition>1</Condition>
<Value>Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown</Value>
</Condition>
```


**wget Queue**

A wget queue is a text listing of items you wish to download from a site. To use this output you would initiate wget with the -B or --base=URL option followed by -i "output.wget"

_Example usage:_
```
wget -B "http://www.google.com/" -i "fix_Arcade - NonMAME ROMs (v0.136_XML).wget"
```

_Example from fix\_Arcade - NonMAME ROMs (v0.136\_XML).wget_
```
Arcade Minor Emus - DEMUL (v0.5.5) - bdrdown
Arcade Minor Emus - DEMUL (v0.5.5) - beachspi
Arcade Minor Emus - DEMUL (v0.5.5) - cfield
Arcade Minor Emus - DEMUL (v0.5.5) - confmiss
Arcade Minor Emus - DEMUL (v0.5.5) - ggxxsla
Arcade Minor Emus - DEMUL (v0.5.5) - initdexp
Arcade Minor Emus - DEMUL (v0.5.5) - jingystm
Arcade Minor Emus - DEMUL (v0.5.5) - karous
```

[Return](wikilginfo.md)