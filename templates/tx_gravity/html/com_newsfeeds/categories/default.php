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
defined('_JEXEC') or die('Restricted access'); ?>

<div class="tx-joomla <?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<div class="tx-newsfeeds">

		<?php if ($this->params->get('show_page_title', 1)) : ?>
		<h1 class="tx-pagetitle">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
		<?php endif; ?>

		<?php if ( ($this->params->get('image') != -1) || $this->params->get('show_comp_description') ) : ?>
		<div class="tx-description">
			<?php
				if ( isset($this->image) ) :  echo $this->image; endif;
				echo $this->escape($this->params->get('comp_description'));
			?>
		</div>
		<?php endif; ?>

		<ul>
			<?php foreach ( $this->categories as $category ) : ?>
			<li>
				<a href="<?php echo $category->link ?>"><?php echo $this->escape($category->title);?></a>
				
				<?php if ( $this->params->get( 'show_cat_items' ) ) : ?>
					<span class="number">
						(<?php echo $category->numlinks;?>)
					</span>
				<?php endif; ?>
				
				<?php if ( $this->params->get( 'show_cat_description' ) && $category->description ) : ?>
					<br /><?php echo $category->description; ?>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>

	</div>
</div>