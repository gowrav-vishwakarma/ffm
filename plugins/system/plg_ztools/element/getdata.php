<?php
/*
# ------------------------------------------------------------------------
# ZTTools plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2011 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

set_time_limit(0);
defined("DS") or define("DS", DIRECTORY_SEPARATOR);

$_options 	= array();
$_type 		= $_REQUEST['type'];
$_value 	= explode(",", $_REQUEST['value']);
$_path		= $_GET['path'];

switch($_REQUEST['type'])
{
	default:{
		$filename		= $_path."/cache/".$_type.".txt";
		if(!is_file($filename)){$handl = fopen($filename, "a"); fwrite($handl, "none");}
		
		//first, obtain the data initially present in the text file
		$ini_handle 	= fopen($filename, "r+");
		$ini_contents 	= fread($ini_handle, filesize($filename));

		if($ini_contents == "none" || isset($_REQUEST['reload']))
		{
			$options = array();
			$options[] = "<option value=' '>[None]</option>";
			$options = array_merge($options, getFilesAndFolder("Media", "/media/"));
			$options = array_merge($options, getFilesAndFolder("Template", "/templates/"));
			$options = array_merge($options, getFilesAndFolder("Components", "/components/"));
			$options = array_merge($options, getFilesAndFolder("Module", "/modules/"));
			$options = array_merge($options, getFilesAndFolder("Plugin", "/plugins/"));

			$ini_handle 	= fopen($filename, "w+");
			$writestring 	= implode("\n", $options);
			
			if(fwrite($ini_handle, $writestring) === false)
			{
				echo "Cannot write to text file. <br />";
			}
			$ini_contents = $writestring;
		}
		$options = explode("\n", $ini_contents);
		fclose($ini_handle);

		$str = '<select size="15" id="'.$_REQUEST['name'].'" name="'.$_REQUEST['control_name'].'['.$_REQUEST['name'].'][]" style="height:200px" cols="50" multiple="multiple" class="inputbox">';
		
		foreach($options as $opt)
		{
			preg_match("/value=\'(.*)\'/", $opt, $value);
			if(in_array($value[1], $_value))
			$str .= str_replace("<option ", "<option selected='selected' ", $opt);
			else
			$str .= $opt;
		}
		$str .= "</select>";
		echo $str;
		break;
	}
}

function getFilesAndFolder($name, $root)
{
	global $_options;
	recusiveFolder($_REQUEST['path'].$root, true, $name);
	return $_options;
}

function recusiveFolder($folder, $first=false, $name = "")
{
	global $_options;
	global $_type;
	
	$excluse = array(".", "..", ".svn", ".csv", ".git");
	
	if($first)
	{
		$_options = array();
		$_options[] = "<option value='{$folder}' style='font-weight:bold'>{$name}</option>";
		clearstatcache();
	}
	
	if($handle = opendir($folder)){
		while($file = readdir($handle)){
			if(!in_array($file, $excluse))
			{
				if(is_dir($folder.$file))
				{
					if($first) $_options[] = "<option value='".replaceValue($folder.$file)."'>".printSpace(3).$file."</option>";
					recusiveFolder($folder.$file.DS, false);
				}
				else
				{
					if(substr($file, strrpos($file, '.') + 1) == $_type)
					{
						$size = calculateSize(filesize($folder . $file));
						$_options[] = "<option value='".replaceValue($folder.$file)."'>".printSpace(9).$file." [{$size}]</option>";
					}
				}
			}
		}
		closedir($handle);
	}
}

function replaceValue($string)
{
	$string = str_replace($_REQUEST['path'], "", $string);
	$string = str_replace(DIRECTORY_SEPARATOR , "/", $string);
	return $string;
}

function calculateSize($size, $sep = ' ')
{
	$unit 	= null;
	$units 	= array('B', 'KB', 'MB', 'GB', 'TB');
	
	for($i = 0, $c = count($units); $i < $c; $i++){
		if($size > 1024)
		{
			$size = $size / 1024;
		}
		else
		{
			$unit = $units[$i];
			break;
		}
	}
	return round($size, 2).$sep.$unit;
}

function printSpace($num)
{
	$sPad 	= "&nbsp;";
	$str 	= str_pad("", $num * strlen($sPad), $sPad) . "|_ ";
	
	return $str;
}