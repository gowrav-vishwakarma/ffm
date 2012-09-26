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
	<div class="weblinks">

		<?php if ($this->params->get('show_page_title', 1)) : ?>
		<h1 class="tx-pagetitle">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
		<?php endif; ?>


		<?php if ( @$this->category->image || @$this->category->description ) : ?>
		<div class="tx-description">
			<?php
				if ( isset($this->category->image) ) :  echo $this->category->image; endif;
				echo $this->category->description;
			?>
		</div>
		<?php endif; ?>

		<?php echo $this->loadTemplate('items'); ?>

		<?php if ($this->params->get('show_other_cats', 1)): ?>
		<ul>
			<?php foreach ( $this->categories as $category ) : ?>
			<li>
				<a href="<?php echo $category->link; ?>" class="category<?php echo $this->params->get( 'pageclass_sfx' ); ?>"><?php echo $this->escape($category->title);?></a>
				&nbsp;
				<span class="small">
					(<?php echo $category->numlinks;?>)
				</span>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
</div>