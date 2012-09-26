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

jimport('joomla.filesystem.file');
class ZTGzip extends JObject
{
	var $gzip_folder;
	var $gzip_css_exclude;
	var $gzip_js_exclude;
	var $merge;
	
	function __construct()
	{
		$document 	= &JFactory::getDocument();
		$this->gzip_folder 		= $document->params->get('gzip_folder', 'zt-assets');
		$this->gzip_css_exclude = $document->params->get('css-exclude', '');
		$this->gzip_js_exclude	= $document->params->get('js-exclude', '');
		$this->merge			= $document->params->get('gzip_merge', 0);
		
		$this->setMinifyConfigFile();
		@JFolder::create($this->gzip_folder);
	}
	
	function optimizecss()
	{
		// Get body string after render
		$_body = JResponse::getBody();
		$_body = explode("</head>", $_body, 2);
		// Replace CSS library
		$avoid = $this->gzip_css_exclude;
		$avoid = ($avoid != '') ? (is_array($avoid) ? $avoid : array($avoid)) : array();
		
		if(is_array($avoid)) {
			$avoid = array_merge($avoid, $this->getExcludeCSSByCondition($_body[0]));
		}
		
		$_body[0] 	= $this->replaceWithLibrary($_body[0], "css", $avoid, $this->merge);
		$_body 		= $_body[0]."</head>".$_body[1];
		
		if($_body) {
			JResponse::setBody($_body);
		}
		return true;
	}		
	
	function optimizehtml()
	{
		$buffer = JResponse::getBody();
		$buffer = $this->compresshtml($buffer);
		JResponse::setBody($buffer);
	}
	
	function compresshtml($data)
	{			
		/* remove comments */
	    $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
		/* remove tabs, spaces, new lines, etc. */        
	    $data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $data);		
		
		return $data;
	}
	
	function optimizejs()
	{
		// Get body string after render
		$_body = JResponse::getBody();
		$_body = explode("</head>", $_body, 2);
		// Replace CSS library
		$avoid = $this->gzip_css_exclude;
		$avoid = ($avoid != '') ? (is_array($avoid) ? $avoid : array($avoid)) : array();
		
		if(is_array($avoid)) {
			$avoid = array_merge($avoid, $this->getExcludeCSSByCondition($_body[0]));
		}
		
		$_body[0] 	= $this->replaceWithLibrary($_body[0], "js", $avoid, $this->merge);
		$_body 		= $_body[0]."</head>".$_body[1];
		
		if($_body) {
			JResponse::setBody($_body);
		}
		return true;
	}	
		
	function clearCache()
	{
		global $app;
		@JFolder::delete($this->gzip_folder);
		@JFolder::create($this->gzip_folder);
		die('Clear cache successful !');
	}
	
	function setMinifyConfigFile()
	{
		// Read config file content and Write to it.
		$content = JFile::read(JPATH_PLUGINS.DS."system".DS."plg_ztools".DS."libs".DS."minify".DS."config_default.php");
		$content = explode("\n", $content);
		
		if(stristr(PHP_OS, 'WIN'))
		{
			$path1 = str_replace(DS, "/", JPATH_ROOT.DS);
			$path2 = str_replace(DS, "/", JPATH_ROOT.DS.$this->gzip_folder.DS);
		}
		else
		{
			$path1 = JPATH_ROOT.DS;
			$path2 = JPATH_ROOT.DS.$this->gzip_folder.DS;
		}
		
		$content[13] = '$min_allowDebugFlag = 1;';
		$content[40] = '$min_cachePath = \''.$path2.'\';';
		$content[54] = '$min_documentRoot = \''.$path1.'\';';
		$content[86] = '$min_serveOptions[\'maxAge\'] = 1;';
		
		JFile::write(JPATH_PLUGINS.DS."system".DS."plg_ztools".DS."libs".DS."minify".DS."config.php", implode("\n", $content));
	}
	
	function replaceWithLibrary($bodyString, $type, $arrAvoid, $merge = 1)
	{
		$strLink 		= JURI::root()."plugins/system/plg_ztools/libs/minify/?f=";
		$strFullLink 	= ($type=="js") ? '<script language="javascript" charset="utf-8" type="text/javascript" src="'.$strLink.'"></script>' : 
		'<link rel="stylesheet" href="'.$strLink.'" type="text/css" />';
		
		// Find script
		$scriptRegex =($type=="js")?"/<script[^>]*?>[\s\S]*?<\/script>/i":"/<link [^>]+(\/>)/i";
		preg_match_all($scriptRegex, $bodyString, $matches);
			
		// Find link...
		$regString = "/([^\"\'=]+\.(".$type."))[\"\']/i";	
		$remotePath = str_replace(str_replace(DS, "/", $_SERVER['DOCUMENT_ROOT']), "", str_replace(DS, "/", JPATH_SITE)) . '/';
		
		$strMerge = "";
		$strPath = "";
		
		foreach($matches[0] as $match)
		{
			preg_match_all($regString, $match, $arrMatchs);
			
			if(isset($arrMatchs[1][0]))
			{
				$filePath = $arrMatchs[1][0];			
				if(strpos($filePath, 'http') !== 0) {
					$strTemp = str_replace($remotePath, "", $filePath);					
				} else {
					if(strpos($filePath, JURI::root()) === false) continue;
					$strTemp = "/".substr($filePath, strlen(JURI::root()));
				}
				
				$strTemp = str_replace("//", "/", $strTemp);
				
				if(!file_exists(str_replace(DS, "/", JPATH_SITE)."/".$strTemp)) continue;			
				
				$replace = true;
				if($arrAvoid != '')
				{
					foreach($arrAvoid as $string)
					{
						if(strpos($filePath, $string) !== false  && $string != '')
						{
							$replace = false;
							if($type == "js" && $lib == "minify" && $strMerge != "")
							{
								preg_match_all("/<script[^>]*?>[\s\S]*?<\/script>/i", $match, $result);
								if(isset($result[0][0]))
								{
									$strMerge   = substr($strMerge, 0, strlen($strMerge)-1);
									$bodyString = str_replace($match, str_replace($strLink, $strLink.$strMerge, $strFullLink)."\n".$match, $bodyString);
									$strMerge   = "";
								}
							}
							break;
						}
					}
				}
				// Replace with another link
				if($replace)
				{
					// Not merge files
					if($merge == 0)
					{
						$strTemp    = $strLink.$strTemp;
						$bodyString = str_replace($filePath, $strTemp, $bodyString);
					}
					if($merge == 1)
					{
						// Merge files
						$strReplace = "";
						if(strpos($strMerge, $strTemp) === false) $strMerge .= $strTemp.",";				
						// Remove link to css, js file
						foreach($matches[0] as $string)
						{
							if(strpos($string, $filePath) !== false)
							{
								$bodyString = str_replace($string, $strReplace, $bodyString);
							}
						}					
					}				
				}
			}
			else
			{
				// Process internal javascript
				if($type == "js" && $strMerge != "" && $merge == 1)
				{
					preg_match_all("/<script[^>]*?>[\s\S]*?<\/script>/i", $match, $result);
					if(isset($result[0][0]))
					{
						$strMerge   = substr($strMerge, 0, strlen($strMerge)-1);
						$bodyString = str_replace($match, str_replace($strLink, $strLink.$strMerge, $strFullLink)."\n".$match, $bodyString);
						$strMerge   = "";
					}
				}
			}
		}
		
		// Merge file
		if($merge == "1" && $strMerge != "")
		{
			$strMerge = substr($strMerge, 0, strlen($strMerge)-1);			
			if($type == "js") {
				$bodyString = $bodyString."\n".str_replace($strLink, $strLink.$strMerge, $strFullLink)."\n";
			} else {
				$bodyString = str_replace("</title>", "</title>\n".str_replace($strLink, $strLink.$strMerge, $strFullLink), $bodyString);
			}
		}
		return $bodyString;
	}
	
	/* Get list of CSS link avoid by: <!--[if ... <![endif]-->*/
	function getExcludeCSSByCondition($bodyString)
	{
		// Find script		
		$scriptRegex = "/<!--\[if[^\]]*?\][\s\S]*?<!\[endif\]-->/i";
		preg_match_all($scriptRegex, $bodyString, $matches);
		$regString   = "/([^\"\'=]+\.(css))[\"\']/i";
		
		if(isset($matches[0]))
			preg_match_all($regString, implode("", $matches[0]), $arrMatchs);
		else
			return array();
		
		if(isset($arrMatchs[1]))
			return $arrMatchs[1];
		else
			return array();
	}
}