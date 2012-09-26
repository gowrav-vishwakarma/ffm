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
	<div class="user">
		<?php if ( $this->params->get( 'show_page_title' ) ) : ?>
		<h1 class="tx-pagetitle">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
		<?php endif; ?>
		<p>
			<?php echo nl2br($this->escape($this->params->get('welcome_desc', JText::_( 'WELCOME_DESC' )))); ?>
		</p>
	</div>
</div>