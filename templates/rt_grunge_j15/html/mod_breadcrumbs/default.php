<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="breadcrumbs">
<span class="sep">YOU ARE HERE</span>
<?php for ($i = 0; $i < $count; $i ++) :

	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if(!empty($list[$i]->link)) {
			echo ' <span class="sep">&nbsp;&raquo;&nbsp;</span> ';
			echo '<a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a>';
		} else {
			echo ' <span class="sep">&nbsp;&raquo;&nbsp;</span> ';
			echo $list[$i]->name;
		}
		
	}  else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
		echo ' <span class="sep">&nbsp;&raquo;&nbsp;</span> ';
	    echo $list[$i]->name;
	}
endfor; ?>
</div>