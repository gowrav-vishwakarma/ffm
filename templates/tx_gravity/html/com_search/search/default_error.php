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
defined('_JEXEC') or die('Restricted access');
?>

<h2 class="error<?php $this->escape($this->params->get( 'pageclass_sfx' )) ?>">
	<?php echo JText::_('Error') ?>
</h2>
<div class="error<?php echo $this->escape($this->params->get( 'pageclass_sfx' )) ?>">
	<p><?php echo $this->escape($this->error); ?></p>
</div>
