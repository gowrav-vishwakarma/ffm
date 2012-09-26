<?php
/**
 * @package ZTools plugin for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JElementComponents extends JElement
{
	
    var $_name = 'Components';

    function fetchElement($name, $value, &$node, $control_name)
    {
        $path 		= JPATH_ROOT.DS.'components';		
		$rows 		= $this->loadAllFolder($path);
		$options	= array();				
		
		$count = 0;
		if(count($rows))
		for($i = 0; $i < count($rows); $i++)
		{
			$id 	= $rows[$i]['id'];
			$parent = $rows[$i]['parent'];
			$dname	= $rows[$i]['name'];
			$view	= $rows[$i]['fullname'].DS.'views';
			
			if(!$parent)
			{								
				$options[$count]->value = $dname;
				$options[$count]->text  = $dname;
				
				if(is_dir($view))
				{
					$views = $this->loadAllFolder($view);
					if(count($views))
					{
						for($k = 0; $k < count($views); $k++)
						{
							$parent = $views[$k]['parent'];
							$dname	= $views[$k]['name'];
							if(!$parent)
							{								
								$count ++;
								$options[$count]->value = $rows[$i]['name'].'.'.$dname;
								$options[$count]->text  = "|---- " . $dname;
							}
						}
					}
				}
				$count ++;
			}
		}
		
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]',
                      'class="inputbox" size="10" style="width:100%;" multiple="multiple"',
                      'value', 'text', $value, $control_name.$name);
    }
	
	function loadAllFolder($path)
	{
		$folders = JFolder::listFolderTree($path, '');
		return $folders;
	}
}
?>