<?php
// @version $Id: default.php 10381 2008-06-01 03:35:53Z pasamio $
defined('_JEXEC') or die('Restricted access');
?>

<span class="poll"><?php echo $poll->title; ?></span>
<form name="form2" method="post" action="index.php" class="poll">
	<fieldset style="margin-bottom: 10px;">
		<?php for ($i = 0, $n = count($options); $i < $n; $i++) : ?>
		<div class="zt-field">
		<input type="radio" name="voteid" id="voteid<?php echo $options[$i]->id; ?>" value="<?php echo $options[$i]->id; ?>" alt="<?php echo $options[$i]->id; ?>" />
		<label for="voteid<?php echo $options[$i]->id; ?>">
			<?php echo $options[$i]->text; ?>
		</label>
		</div>
		<?php endfor; ?>
	</fieldset>

	<input type="submit" name="task_button" class="button-poll" value="<?php echo JText::_('Vote'); ?>" />
	&nbsp;
	<input type="button" name="option" class="button-poll" value="<?php echo JText::_('Results'); ?>" onclick="document.location.href='<?php echo JRoute::_("index.php?option=com_poll&id=$poll->slug".$itemid); ?>'" />

	<input type="hidden" name="option" value="com_poll" />
	<input type="hidden" name="id" value="<?php echo $poll->id; ?>" />
	<input type="hidden" name="task" value="vote" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
