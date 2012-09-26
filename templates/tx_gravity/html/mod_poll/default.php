<?php
/**
 * @package   ZOE
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009-2010 ThemExpert
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
defined('_JEXEC') or die('Restricted access');
?>

<h4 class="tx-polltitle">
	<?php echo $poll->title; ?>
</h4>
<form action="index.php" method="post" name="form2" class="tx-poll">
	<fieldset>
		<?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>
		<div class="tx-pollrow">
			<input type="radio" name="voteid" id="voteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" />
			<label for="voteid<?php echo $options[$i]->id;?>">
				<?php echo $options[$i]->text; ?>
			</label>
		</div>
		<?php endfor; ?>
	</fieldset>
	<div class="tx-pollbuttons">
		<div class="readon">
			<input type="submit" name="task_button" class="button" value="<?php echo JText::_('Vote'); ?>" />
		</div>
		<div class="readon">
			<input type="button" name="option" class="button" value="<?php echo JText::_('Results'); ?>" onclick="document.location.href='<?php echo JRoute::_("index.php?option=com_poll&id=$poll->slug".$itemid); ?>'" />
		</div>
	</div>

	<input type="hidden" name="option" value="com_poll" />
	<input type="hidden" name="task" value="vote" />
	<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
