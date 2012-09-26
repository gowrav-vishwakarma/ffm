<?php
/**
 * @version		$Id: modules.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */

/*
 * Module chrome for rendering the module in a clean manner
 */
function modChrome_basic($module, &$params, &$attribs)
{
	?>
	<div class="rt-block">
	<?php
    if ($module->showtitle !=0 ):?>
    <h2 class="title"><?php echo $module->title; ?></h2>
    <?php
    endif;
	if (!empty ($module->content)) : ?>
		<?php echo $module->content; ?>
	<?php endif;?>
	</div>
	<?php
}
function modChrome_grunge($module, &$params, &$attribs)
{
	$mc_sfx = $params->get('moduleclass_sfx');
	if (!empty ($module->content)) : ?>
	<div class="rt-block">
	<?php if (strlen(trim($mc_sfx))>0) : ?>

		<div class="module rt-grunge m<?php echo $mc_sfx; ?>">
		<?php else: ?>
		<div class="module rt-grunge">
		<?php endif; ?>

			<?php if ($module->showtitle != 0) : ?>
			<h1 class="title"><?php echo $module->title; ?></h1>
			<?php endif; ?>
			<div class="module-divider<?php echo $mc_sfx; ?>"></div>
		    <div class="module-body">
		        <?php echo $module->content; ?>
	        </div>
		</div>
		<div class="module-bottom"></div>
	</div>
	<?php endif;
}
function modChrome_standard($module, &$params, &$attribs)
{
 	if (!empty ($module->content)) : ?>
        <?php if ($params->get('moduleclass_sfx')!='') : ?>
        <div class="<?php echo $params->get('moduleclass_sfx'); ?>">
        <?php endif; ?>
            <div class="rt-block">
				<div class="module-surround">
					<?php if ($params->get('moduleclass_sfx')!='') : ?>
			        <div class="module-icon"></div>
			        <?php endif; ?>
	                <?php if ($module->showtitle != 0) : ?>

	                	<h2 class="title"><?php echo $module->title; ?></h2>

	                <?php endif; ?>
					<div class="module-content">
	                	<?php echo $module->content; ?>
					</div>
				</div>
            </div>
        <?php if ($params->get('moduleclass_sfx')!='') : ?>
        </div>
	<?php endif; ?>
	<?php endif;
}
?>