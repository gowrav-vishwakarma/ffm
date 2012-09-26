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

<div class="tx-joomla <?php echo $this->params->get('pageclass_sfx')?>">
	
	<div class="user">

		<h1 class="tx-pagetitle">
			<?php echo JText::_('Reset your Password'); ?>
		</h1>
		
		<p>
			<?php echo JText::_('RESET_PASSWORD_COMPLETE_DESCRIPTION'); ?>
		</p>
	
		<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=completereset' ); ?>" method="post" class="josForm form-validate">
		<fieldset>
			<legend><?php echo JText::_('Reset your Password'); ?></legend>
			
			<div>
				<label for="password1" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TEXT'); ?>"><?php echo JText::_('Password'); ?>:</label>
				<input id="password1" name="password1" type="password" class="required validate-password" />
			</div>
			<div>
				<label for="password2" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TEXT'); ?>"><?php echo JText::_('Verify Password'); ?>:</label>
				<input id="password2" name="password2" type="password" class="required validate-password" />
			</div>
			<div class="readon">
				<button type="submit" class="button"><?php echo JText::_('Submit'); ?></button>
			</div>
			
		</fieldset>
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
	</div>
</div>
