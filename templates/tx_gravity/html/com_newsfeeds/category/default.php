<?php
/**
 * @package   ZOE
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009-2010 ThemExpert
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * 
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<div class="tx-joomla <?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<div class="tx-newsfeeds">
	
		<?php if ($this->params->get('show_page_title', 1)) : ?>
		<h1 class="tx-pagetitle">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
		<?php endif; ?>

		<?php if ( @$this->image || @$this->category->description ) : ?>
		<div class="tx-description">
			<?php
				if ( isset($this->image) ) :  echo $this->image; endif;
				echo $this->category->description;
			?>
		</div>
		<?php endif; ?>
		
		<?php echo $this->loadTemplate('items'); ?>

	</div>
</div>
