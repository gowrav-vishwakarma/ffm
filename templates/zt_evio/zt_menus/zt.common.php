<?php
/**
* @version 1.5.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright (c) 2008 - 2011 http://www.ZooTemplate.com. All rights reserved.
*/
// No direct access 
defined('_JEXEC') or die();
/**
 * Class Menu Common
 *
 */
class MenuSystem
{
	var $_name 		= null;
	var $_template 	= null;
	var $_start 	= null;
	var $_end 		= null;
	var $_suffix 	= null;
	var $_active 	= null;
	var $_type 		= null;
	var $_cache 	= null;
	var $_nav 		= null;
	var $Itemid 	= null;
	var $fancy		= null;
	var $mega		= null;
	var $drill		= null;
	
	/**
	 * Enter description here...
	 *
	 * @param string $name
	 * @param string $menutype
	 * @param string $template_name
	 * @param string $suffix
	 * @return MenuSystem
	 */
	 
	function MenuSystem($name, $menutype, $template_name, $rtl, $fancy = 0, 
	$transition = 'Fx.Transitions.linear', $duration = '500', 
	$xdelay = 700, $xduration = 2000, $xtransition = 'Fx.Transitions.Bounce.easeOut')
	{
		global $Itemid;
		$this->_name 		= $name;
		$this->_template 	= $template_name;
		$this->_suffix 		= "";
		$this->_type 		= $menutype;
		$this->Itemid 		= $Itemid;
		$this->mega 		= '<script type="text/javascript">window.addEvent("domready", function(){ZTMegaMenu('.$xdelay.', 0, 0, "_megamenu", "megamenu_close", false, '.$xduration.', '.$xtransition.');var megas = $(document.body).getElements(\'div[class="menusub_mega"]\');megas.each(function(mega, i){var id = mega.getProperty("id").split("_");if(id[2] != null){var smart = "_" + id[1] + "_" + id[2];ZTMegaMenu('.$xdelay.', 0, 0, smart, "megamenu_close", true, '.$xduration.', '.$xtransition.');}});});</script>';
		$this->fancy 		= '<script type="text/javascript">window.addEvent("domready", function(){$(window).addEvents({"load" : loadListener});function loadListener(){new ZTFancy($E("ul", "zt-mainmenu-inner"), {transition: '.$transition.', duration: '.$duration.', onClick: function(ev, item){ev.stop();}});}if(!window.gecko && !window.ie){new ZTFancy($E("ul", "zt-mainmenu-inner"), {transition: '.$transition.', duration: '.$duration.', onClick: function(ev, item){ev.stop();}});}});</script>';
		$this->drill		= '<script type="text/javascript">var mymenu=new drilldownmenu({menuid: "drillmenu1", menuheight: "auto", breadcrumbid: "drillcrumb", persist: {enable: true, overrideselectedul: true}})</script>';
		
		$document 			= JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.css');
		
		//Mega menu
		if($this->_name == 'mega') {
			if(!class_exists('plgSystemPlg_ZTools')) {
				echo JText::_('Missing ZTools plugin.');
				die();
			}
		}
		
		if($rtl == 'rtl') {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.rtl.js');
		} else {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.js');
		}
		
		//Fancy menu
		if($fancy) {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/zt_fancymenu/zt_fancymenu.js');
			$document->addStyleSheet(JURI::base().'templates/'.$this->_template.'/zt_menus/zt_fancymenu/zt_fancymenu.css');
		}
		
		$this->genmenu();
	}
	
	function hasChild($lvl)
	{
		$pid = $this->fatherId($lvl);
		if(!$pid) return false;
		if(@$this->_nav[$pid]) return true;
		else return false;
	}
	
	function _showMenuDetail($row, $level = 0)
	{
		$_temp 			= null;
		$title 			= "title=\"$row->name\""; 
		$menu_params 	= new JParameter($row->params);

		if($menu_params->get('menu_image') && $menu_params->get('menu_image') != -1)
		{
			$str = '<img src="images/stories/'.$menu_params->get('menu_image').'" alt="'.$row->name.'" /><span class="menusys_name">'.$row->name.'</span>';
		}
		else
		{
			$str = '<span class="menusys_name">'.$row->name.'</span>';
		}
		
		$Class 	= $this->activeClass($row, $level);
		$id		='id="menusys'.$row->id.'"';            
		
		if(@$row->url != null)
		{
			if($row->browserNav == 0)
			{
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)
			{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2)
			{
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);   
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else
		{
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}
		echo $menuItem;
	}
	
	function show($start=0, $end = 14)
	{
		$this->_start = $start;
		$this->_end   = $end;
		echo "<div class=\"menusys_".$this->_name.$this->_suffix."\">";
		
		if($this->_start == 0)
		{
			switch($this->_name)
			{
				case "mega":
					$this->showMegaMenu(0, 0);
					$this->endMenu($this->mega);
					$this->endMenu($this->fancy);
				break;
				case "drill":
					$this->showDrillMenu(0, 0);
					$this->endMenu($this->drill);
				break;
				default:
					$this->showMenu(0, 0);
					$this->endMenu($this->fancy);
				break;
			}
		}
		else
		{
			$parID = $this->fatherId($this->_start); 
			switch($this->_name)
			{
				case "mega":
					$this->showMegaMenu($parID, $this->_start);
					$this->endMenu($this->mega);
					$this->endMenu($this->fancy);
				break;
				case "drill":
					$this->showDrillMenu(0, 0);
					$this->endMenu($this->drill);
				break;
				default:
					$this->showMenu($parID, $this->_start);
					$this->endMenu($this->fancy);
				break;
			}
		}
		echo "</div>";
	}
	
	function showMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			if($level == 0)
			{ 
				echo "<ul id=\"menusys_".$this->_name."\">"; 
			}
			elseif($level == 1 && ($this->_name == 'submoo' || $this->_name == 'split'))
			{
				echo "<ul id=\"menusub_".$this->_name."\">";
			}
			else
			{
				echo "<ul>";
			}	
					
			$i = 0;
			foreach($this->_nav[$pid] as $menu)
			{
				if(@$this->_nav[$menu->id]) $abc = " hasChild";
				else $abc = "";
				
				$class = ($this->isActive($menu)) ? " active" : "";
				
				if($i == 0) echo '<li class="first-item'.$abc.' '.$class.'">';
				elseif($i == count($this->_nav[$pid]) - 1) echo '<li class="last-item'.$abc.'">';
				else echo '<li class="'.$abc.' '.$class.'">';
				
				$this->_showMenuDetail($menu, $level);
				
				if($level < $this->_end) $this->showMenu($menu->id, $level+1);
				$i++;
				echo "</li>";
			}
			echo "</ul>";
		}
	}
	
	function activeClass($menu_item, $level)
	{
		return (in_array($menu_item->id, $this->_active)) ? " class=' active'" : " class=' item'";
	}
	
	//~~ This function will found the father ID of and item marked by level in array of active items ~~~~~~~
	function fatherId($lvl)
	{
		if(!$lvl) return 0;
		//echo "<pre>";print_r($this->_active);exit;
		if(count($this->_active) < $lvl) return 0;
		$parID = count($this->_active) - $lvl;
		return $this->_active[$parID];
	}
	
	/**
	 * Generate the menu
	 *
	 * @return mixed
	 */
	 
	function genmenu()
	{
		$nav          = @JMenu::getInstance();
		$my           = JFactory::getUser();
		$nav          = array();		 
		$this->_cache = array();
		
		if(@strtolower(get_class($menu)) == 'jexception')
		{
			$nav 		= @JMenu::getInstance('site');
		}
		$menus 	= &JSite::getMenu();
		$rows 	= $menus->getItems('menutype', $this->_type);
		$_tmp 	= array();
		
		if(count($rows))
		{
		   foreach($rows as $key => $value)
		   {
				if($value->access <= $my->get('gid'))
				{
					$par 		= $value->parent;
					$list_menu 	= @($nav[$par]) ? $nav[$par] : array();
					
					if($value->type == 'separator')
					{
						$value->_index 	= count($list_menu);
						$list_menu[] 	= $value;
						$nav[$par] 		= $list_menu;
						
						$this->_cache[$value->id] 	= $value;
						$_tmp[$value->id] 			= $key;
						
						continue;
					}
					elseif($value->type == 'url')
					{
						if((strpos($value->link, 'index.php?') !== false) && (strpos($value->link, 'Itemid=') === false))
						{
							$value->url = $value->link.'&amp;Itemid='.$value->id;
						}
						else
						{
							$value->url = $value->link;
						}   
					}
					else
					{
						$router = JSite::getRouter();
						if($router->getMode() == JROUTER_MODE_SEF)
						{
							//~~ No JRoute now ~~~
							$value->url = 'index.php?Itemid='.$value->id;
						}
						else
						{
							//~~ No JRoute now ~~~
							$value->url = $value->link.'&amp;Itemid='.$value->id;   
						}
					}
					
					if($value->url != null)
					{
						// Handle SSL links
						$iParams = new JParameter($value->params);
						$iSecure = $iParams->def('secure', 0);
						
						if($value->home == 1)
							$value->url = JURI::base();
						elseif(strcasecmp(substr($value->url, 0, 4), 'http') && (strpos($value->link, 'index.php?') !== false))
							$value->url = JRoute::_($value->url, true, $iSecure);
						else
							$value->url = str_replace('&', '&amp;', $value->url);
					}
					
					$value->_index 	= count($list_menu);
					$list_menu[] 	= $value;
					$nav[$par] 		= $list_menu;
				}
				$this->_cache[$value->id] = $value;
				$_tmp[$value->id] = $key;
			}
		}
		
		$this->_nav = $nav;
		//~~ Find out what submenus this item has ~~~~~~~~~~~
		$active 	= array ($this->Itemid);
		$max 		= 14;
		//~~ We dont need more than 14 levels of menu, do we? ~~~
		$id 		= $this->Itemid;
		
		while($max)
		{
			if(isset($_tmp[$id]))
			{
				$tmp = $_tmp[$id];
				if(isset ($rows[$tmp]) && $rows[$tmp]->parent > 0)
				{
					$id = $rows[$tmp]->parent;
					$active[] = $id;
				}
				else
				{
					break;
				}
			}
			$max--;
		}
		$this->_active = $active;
	}
	
	/**
		Package: Mega Menu Function
		Created: December 04, 2010
	*/
	
	function showMegaMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			$this->beginUl( NULL, "menusys_".$this->_name);
			$i = 0;
			foreach($this->_nav[$pid] as $menu) 
			{
				$params	= $menu->params;
				$aclass	= $this->getMegaMenuParam($params, "mega_class", '');
				$cols	= $this->getMegaMenuParam($params, "mega_cols", 1);
				
				if(@$this->_nav[$menu->id]){$class = "hasChild"; $id = "menu-".$menu->id;}
				else {$class = ""; $id = "";}
					
				if($i == 0) $class = "first-item $class";
				elseif($i == count($this->_nav[$pid]) - 1) $class = "last-item $class";
				else $class = $class;
				
				$class .= ($this->isActive($menu)) ? " active" : "";
				$class .= ($aclass != '') ? $aclass : "";
				
				$this->beginLi($class, $id);
					$this->genMegaTypeNormal($menu, $level);
					if(@$this->_nav[$menu->id])
					{
						$this->beginDiv("menusub_mega", "menu-".$menu->id."_megamenu");
							$this->showSubMegaMenu($menu, $menu->id, $level+1, $cols);
						$this->endDiv();
					}
				$this->endLi();
				$i++;
			}
			$this->endUl();
		}
	}
	
	function showSubMegaMenu($row, $pid, $level, $cols)
	{
		$params	= $row->params;
		$swidth = $this->getMegaMenuParam($params, "mega_colw", '');
		$colxw	= $this->getMegaMenuParam($params, "mega_colxw", '');
		$colw 	= array();
		$width  = $this->getMegaMenuParam($params, "mega_width", '');
		$style	= ($width != '') ? "width:$width" : "";
		
		if($colxw != '')
		{
			$colx  = explode("\n", $colxw);
			for($i = 0; $i < count($colx); $i++)
			{
				$col 	= explode("=", $colx[$i]);
				$colw[] = $col[1];
			}
		}
			
		
		$subs	= $this->_nav[$pid];
		$total	= count($subs);
		
		$count	= floor($total/$cols);
		$bal	= $total - $count*$cols;
		$m		= 0;
		
		$this->beginDiv("submenu-wrap", NULL, $style);
		for($i = 1; $i <= $cols; $i++)
		{
			$width	= (count($colw) == $cols) ? "width:".$colw[$i-1] : (($swidth !='') ? "width:".$swidth : NULL);			
			$params	= $subs[$m]->params;
			$group	= $this->getMegaMenuParam($params, "mega_group", 0);
			
			if($group)
			{
				for($g = 0; $g < $count; $g++)
				{
					$this->beginDiv("megacol column$i", NULL, $width);
						$this->_showMegaMenuDetail($subs[$m], $level);
						//Show sub level
						$spid	= $subs[$m]->id;
						if(@$this->_nav[$spid])
						{
							$level	= $level + 1;
							$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
							$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
						}
					$this->endDiv();
					$m ++;
				}
			}
			else
			{
				$this->beginDiv("megacol column$i", NULL, $width);
					$this->beginUl("mega-ul ul");
						for($k = 0; $k < $count; $k++)
						{						
							if($k == 0)
								$class	= "mega-li li first-item";
							elseif($k == ($count - 1))
								$class	= "mega-li li last-item";
							else
								$class	= "mega-li li";
							
							$spid	= $subs[$m]->id;
							if(@$this->_nav[$spid]){ $id = "menu-$spid"; $class .= " hasChild"; }
							else{$id = "";}
								
							$this->beginLi($class, $id);
								$this->_showMegaMenuDetail($subs[$m], $level);
								//Show sub level
								if(@$this->_nav[$spid])
								{
									$level	= $level + 1;
									$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
									
									$this->beginDiv("menusub_mega", "menu-".$subs[$m]->id."_megamenu_sub$level");
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									$this->endDiv();
								}
							$this->endLi();
							//Balance
							if($m == 0 && $bal !=0)
							for($b = 0; $b < $bal; $b++)
							{
								$m ++;
								$this->beginLi("mega-li li");
									$this->_showMegaMenuDetail($subs[$m], $level);
									//Show sub level
									$spid	= $subs[$m]->id;
									if(@$this->_nav[$spid])
									{
										$level	= $level + 1;
										$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									}
								$this->endLi();
							}
							$m ++;
						}
					$this->endUl();
				$this->endDiv();
			}
		}
		$this->endDiv();
	}
	
	function isActive($row)
	{
		$active	= $this->_active;
		$mid	= $row->id;
		
		return (in_array($mid, $active)) ? true : false;
	}
	
	function getMegaMenuParam($params, $key, $default = 0)
	{
		$params = new JParameter($params);
		$type	= $params->def($key, $default);
		return $type;
	}
	
	function genMegaTypeNormal($row, $level = 0)
	{
		$str	= "";
		$params	= $row->params;
		
		$image	= $this->getMegaMenuParam($params, "menu_image", -1);
		$stitle	= $this->getMegaMenuParam($params, "mega_showtitle", 0);
		$desc	= $this->getMegaMenuParam($params, "mega_desc", '');
		$group	= $this->getMegaMenuParam($params, "mega_group", 0);
		$width	= $this->getMegaMenuParam($params, "mega_width", '');
		$colw	= $this->getMegaMenuParam($params, "mega_colw", '');
		$colxw	= $this->getMegaMenuParam($params, "mega_colxw", '');
		
		$name			= '<span class="menu-title">'.$row->name.'</span>';
		$description	= ($desc != '') ? '<span class="menu-desc">'.$desc.'</span>' : "";
		$title			= ($stitle) ? " title=\"$row->name\"" : "";
		
		if($image != -1)
		{
			$itembg 	= 'style="background-image:url('.JURI::base(true).'/images/stories/'.$image.');"';
			$str	   	= "<span class=\"has-image\" $itembg>".$name.$description.'</span>';
		}
		else
		{
			$str		= "<span class=\"no-image\">".$name.$description.'</span>';
		}
		
		$Class 		= $this->activeClass($row, $level);
		$id			= 'id="menusys'.$row->id.'"';
		$add_class	= $this->getMegaMenuParam($params, "mega_class", '');
				
		if(@$row->url != null)
		{
			if($row->browserNav == 0)
			{
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)
			{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2)
			{
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);   
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else
		{
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}
		
		if($group)
		{
			$menuItem = '<div class="mega-group'.$add_class.'">'.$menuItem.'</div>';
		}
		
		echo $menuItem;
	}
	
	
	function genMegaTypeMod($row, $level = 0, $mid, $style = 'xhtml')
	{
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$db			= JFactory::getDBO();				
		
		$modules	= JModuleHelper::_load();
		$total		= count($modules);
		
		for ($i = 0; $i < $total; $i++)
		{
			if ($modules[$i]->id == $mid)
			{
				$this->beginDiv("mega-module");
				echo $renderer->render($modules[$i], $params);
				$this->endDiv();
			}
		}
	}
	
	
	function genMegaTypePosition($row, $level = 0, $position, $style = 'xhtml')
	{
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$contents 	= '';
		
		
		foreach(JModuleHelper::getModules($position) as $mod)
		{
			$contents .= $renderer->render($mod, $params);
		}
		
		echo $contents;
	}
	
	
	function _showMegaMenuDetail($row, $level = 0)
	{
		$type	= $this->getMegaMenuParam($row->params, 'mega_subcontent', 0);
		
		switch($type)
		{
			case "mod":
				$module		= $this->getMegaMenuParam($row->params, 'mega_subcontent-mod-modules');
				$style		= $this->getMegaMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->genMegaTypeMod($row, $level, $module, $style);				
			break;
			case "pos":
				$position	= $this->getMegaMenuParam($row->params, 'mega_subcontent-pos-positions');
				$style		= $this->getMegaMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->genMegaTypePosition($row, $level, $position, $style);				
			break;
			default:
				$this->genMegaTypeNormal($row, $level);
			break;
		}
	}
	
	//Begin, End DIV
	function beginDiv($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	= ($class) ? " class='$class'" : "";
		$id		= ($id) ? " id='$id'" : "";
		$style	= ($style) ? " style='$style'" : "";
		
		echo "<div$id$class$style>";
	}

	function endDiv()
	{
		echo "</div>";
	}
	
	//Begin, end UL
	function beginUl($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	= ($class) ? " class='$class'" : "";
		$id		= ($id) ? " id='$id'" : "";
		$style	= ($style) ? " style='$style'" : "";
		
		echo "<ul$id$class$style>";
	}
	function endUl()
	{
		echo "</ul>";
	}
	
	//Begin, end LI
	function beginLi($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	= ($class) ? " class='$class'" : "";
		$id		= ($id) ? " id='$id'" : "";
		$style	= ($style) ? " style='$style'" : "";
		
		echo "<li$id$class$style>";
	}
	function endLi()
	{
		echo "</li>";
	}
	
	//Function end menu
	function endMenu($text)
	{
		echo $text;
	}
	
	/**
		Function Show Drill Menu
	*/
	
	function showDrillMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			$this->beginUl();
			
			$i = 0;
			foreach($this->_nav[$pid] as $menu)
			{
				$this->beginLi();
					$this->_showMenuDetail($menu, $level);
					if($level < $this->_end) $this->showDrillMenu($menu->id, $level+1);
				$this->endLi();
				$i++;
			}
			$this->endUl();
		}
	}
}
?>