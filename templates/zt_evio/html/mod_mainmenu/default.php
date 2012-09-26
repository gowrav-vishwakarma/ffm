<?php

// no direct access
defined('_JEXEC') or die('Restricted access');


if ( ! defined('modMainMenuXMLCallbackDefined') )
{
function modMainMenuXMLCallback(&$node, $args)
{
	$user	= &JFactory::getUser();
	$menu	= &JSite::getMenu();
	$active	= $menu->getActive();
	$path	= isset($active) ? array_reverse($active->tree) : null;

	if (($args['end']) && ($node->attributes('level') >= $args['end']))
	{
		$children = $node->children();
		foreach ($node->children() as $child)
		{
			if ($child->name() == 'ul') {
				$node->removeChild($child);
			}
		}
	}

	if ($node->name() == 'ul') {
		foreach ($node->children() as $child)
		{
			if ($child->attributes('access') > $user->get('aid', 0)) {
				$node->removeChild($child);
			}
		}

      // BEGIN: Added by iGURU
      $subitems_count = count($node->children());
      $subitem_index = 0;
      foreach ($node->children() as $child) {
         if ($subitem_index == 0) $child->addAttribute('first', 1);
         if ($subitem_index == $subitems_count - 1) $child->addAttribute('last', 1);
         $subitem_index++;
      }
      // END: Added by iGURU

	}

	if (($node->name() == 'li') && isset($node->ul)) {
		$node->addAttribute('class', 'parent');
	}

	if (isset($path) && in_array($node->attributes('id'), $path))
	{
		if ($node->attributes('class')) {
			$node->addAttribute('class', $node->attributes('class').' active');
		} else {
			$node->addAttribute('class', 'active');
		}
	}
	else
	{
		if (isset($args['children']) && !$args['children'])
		{
			$children = $node->children();
			foreach ($node->children() as $child)
			{
				if ($child->name() == 'ul') {
					$node->removeChild($child);
				}
			}
		}
	}

	if (($node->name() == 'li') && ($id = $node->attributes('id'))) {
      if ($node->attributes('class')) {
         // BEGIN: Commented and Added by iGURU
         //$node->addAttribute('class', $node->attributes('class').' item'.$id);
         $class_array[] = $node->attributes('class').' item'.$id;
         // END: Commented and Added by iGURU
      } else {
         // BEGIN: Commented and Added by iGURU
         //$node->addAttribute('class', 'item'.$id);
         $class_array[] = 'item'.$id;
         // END: Commented and Added by iGURU
      }

      // BEGIN: Added by iGURU
      if ($node->attributes('first')) $class_array[] = 'first';
      if ($node->attributes('last')) $class_array[] = 'last';
      $item_class = implode(" ", $class_array);
      $node->addAttribute('class', $item_class);
      // END: Added by iGURU

	}

	if (isset($path) && $node->attributes('id') == $path[0]) {
		$node->addAttribute('id', 'current');
	} else {
		$node->removeAttribute('id');
	}
	$node->removeAttribute('level');
	$node->removeAttribute('access');
   // BEGIN: Added by iGURU
   $node->removeAttribute('first');
   $node->removeAttribute('last');
   // END: Added by iGURU
}
	define('modMainMenuXMLCallbackDefined', true);
}
modMainMenuHelper::render($params, 'modMainMenuXMLCallback');
