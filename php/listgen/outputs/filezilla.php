<?php

### FILEZILLA filter rules output module
#
# Builds a filezilla filters.xml

global $modname, $outfile, $title;

$modname = 'FileZilla Filter';
$outfile = "filters.xml";
$title = $name;

function writeout_header()
{
	global $name, $xmlhndl, $title;

  # Default Filter Settings
  $applytofiles = "1";           //Apply Filters to Files 
  $applytodirs = "0";           // Apply Filters to Directories
  $matchtype = "None";      // Filter out files that do not match our items
  $matchcase = "0";

    fwrite($xmlhndl ,'<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'."\n");
    fwrite($xmlhndl ,'<FileZilla3>'."\n");
    fwrite($xmlhndl ,'    <Filters>'."\n");
    fwrite($xmlhndl ,'        <Filter>'."\n");
    fwrite($xmlhndl ,'          <Name>'.$title.'</Name>'."\n");
    fwrite($xmlhndl ,'          <ApplyToFiles>'.$applytofiles.'</ApplyToFiles>'."\n");
    fwrite($xmlhndl ,'          <ApplyToDirs>'.$applytodirs.'</ApplyToDirs>'."\n");
    fwrite($xmlhndl ,'          <MatchType>'.$matchtype.'</MatchType>'."\n");
    fwrite($xmlhndl ,'          <MatchCase>'.$matchcase.'</MatchCase>'."\n");
    fwrite($xmlhndl ,'          <Conditions>'."\n");
}

function writeout_contents($items) 
{

	global $xmlhndl;
        
        foreach ($items AS $item)
        {
            fwrite($xmlhndl ,'<Condition>'."\n");
            fwrite($xmlhndl ,'<Type>'.$item['type'].'</Type>'."\n");
            fwrite($xmlhndl ,'<Condition>'.$item['condition'].'</Condition>'."\n");
            fwrite($xmlhndl ,'<Value>'.$item['value'].$item['ext'].'</Value>'."\n");
            fwrite($xmlhndl ,'</Condition>'."\n");
        }
}

function writeout_footer()
{

	global $name;
	global $outfile;
	global $xmlhndl;

    fwrite($xmlhndl ,'          </Conditions>'."\n");
    fwrite($xmlhndl ,'        </Filter>'."\n");
    fwrite($xmlhndl ,'    </Filters>'."\n");
    fwrite($xmlhndl ,'    <Sets Current="0">'."\n");
    fwrite($xmlhndl ,'        <Set>'."\n");
    fwrite($xmlhndl ,'            <Name>'.$name.'</Name>'."\n");
    fwrite($xmlhndl ,'            <Item>'."\n");
    fwrite($xmlhndl ,'                <Local>0</Local>'."\n");
    fwrite($xmlhndl ,'                <Remote>1</Remote>'."\n");
    fwrite($xmlhndl ,'            </Item>'."\n");
    fwrite($xmlhndl ,'        </Set>'."\n");
    fwrite($xmlhndl ,'    </Sets>'."\n");
    fwrite($xmlhndl ,'</FileZilla3>'."\n");

    create_link($outfile);
    

}

?>
