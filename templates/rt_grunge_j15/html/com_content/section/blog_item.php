<?php
/**
 * @package   Quasar Template - RocketTheme
 * @version   1.5.2 January 10, 2011
 * @author    YOOtheme http://www.yootheme.com & RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * These template overrides are based on the fantastic GNU/GPLv2 overrides created by YOOtheme (http://www.yootheme.com)
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
include_once(dirname(__FILE__).DS.'..'.DS.'icon.php');

$article_details_show = ((intval($this->item->modified) !=0 && $this->item->params->get('show_modify_date')) || ($this->item->params->get('show_author') && ($this->item->author != "")) || ($this->item->params->get('show_create_date')) || ($this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon')));

$canEdit	= ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
?>

<div class="rt-article <?php if ($this->item->state == 0) echo 'unpublished' ?>">
	<div class="rt-article-bg">

		<?php /** Begin Article Title **/ if ($canEdit || $this->item->params->get('show_title')) : ?>
		<div class="rt-headline">
			<?php if ($this->item->params->get('show_title')) : ?>
			<h1 class="rt-article-title">
				<?php if ($this->item->params->get('link_titles') && $this->item->readmore_link != '') : ?>
					<a href="<?php echo $this->item->readmore_link; ?>"><?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
			</h1>
			<?php endif; ?>
			<?php if ($canEdit) : ?>
			<span class="icon edit">
				<?php echo JHTML::_('icon.edit', $this->item, $this->item->params, $this->access); ?>
			</span>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<?php /** End Article Title **/ endif; ?>
		<div class="rt-article-content">
			<?php  if (!$this->item->params->get('show_intro')) :
				echo $this->item->event->afterDisplayTitle;
			endif; ?>
		
			<?php echo $this->item->event->beforeDisplayContent; ?>
			<?php if ((intval($this->item->modified) !=0 && $this->item->params->get('show_modify_date')) || ($this->item->params->get('show_author') && ($this->item->author != "")) || ($this->item->params->get('show_create_date')) || ($this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon'))) : ?>
			<div class="rt-articleinfo">
				<?php /** Begin JComment count **/
                $comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
				if (file_exists($comments) ) :
				    require_once($comments);
                    if (JCommentsContentPluginHelper::checkCategory($this->item->catid) && (JCommentsContentPluginHelper::isEnabled($this->item, false) || !JCommentsContentPluginHelper::isDisabled($this->item, false))):

				        $jcomment_count = JComments::getCommentsCount($this->item->id, 'com_content');
				?>
				<a href="<?php echo $this->item->readmore_link; ?>#comments" class="rt-comment-badge">
					<span class="rt-comment-count"><?php echo $jcomment_count; ?></span>
				</a>
				<div class="clear"></div>
				<span class="rt-comment-text"><?php echo JText::_('COMMENTS'); ?></span>
				    <?php endif;?>
				<?php /** End JComment count **/ endif; ?>
				<?php /** Begin Created Date **/ if ($this->item->params->get('show_create_date')) : ?>
				<span class="rt-date-posted">
					<?php echo JText::_('Posted on'); ?>
					<span><?php echo JHTML::_('date', $this->item->created, JText::_('%b %d, %Y')); ?></span>
				</span>
				<?php /** End Created Date **/ endif; ?>
	
				<?php /** Begin Modified Date **/ if ( intval($this->item->modified) != 0 && $this->item->params->get('show_modify_date')) : ?>
				<span class="rt-date-modified">
					<?php echo JText::_('Last Updated'); ?>
					<span><?php echo JHTML::_('date', $this->item->modified, JText::_('%b %d, %Y')); ?></span>
				</span>
				<?php /** End Modified Date **/ endif; ?>
	
				<?php /** Begin Author **/ if (($this->item->params->get('show_author')) && ($this->item->author != "")) : ?>
				<span class="rt-author">
					<?php echo JText::_('Posted by'); ?>
					<span><?php JText::printf($this->escape($this->item->created_by_alias) ? $this->escape($this->item->created_by_alias) : $this->escape($this->item->author)); ?></span>
				</span>
				<?php /** End Author **/ endif; ?>
	
				<?php /** Begin Url **/ if ($this->item->params->get('show_url') && $this->item->urls) : ?>
				<span class="rt-url">
					<a href="http://<?php echo $this->escape($this->item->urls) ; ?>" target="_blank"><?php echo $this->escape($this->item->urls); ?></a>
				</span>
				<?php /** End Url **/ endif; ?>
				<?php /** Begin Article Icons **/ if ($this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon')) : ?>
				<div class="rt-article-icons">
					<?php if ($this->item->params->get('show_pdf_icon')) :
						echo RokIcon::pdf($this->item, $this->item->params, $this->access);
					endif;
					if ($this->item->params->get('show_print_icon')) :
						echo RokIcon::print_popup($this->item, $this->item->params, $this->access);
					endif;
					if ($this->item->params->get('show_email_icon')) :
						echo RokIcon::email($this->item, $this->item->params, $this->access);
					endif; ?>
				</div>
				<?php /** End Article Icons **/ endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if ($article_details_show) : ?>
			<div class="rt-article-inner">
			<?php endif; ?>
				<?php if (isset ($this->item->toc)) : ?>
					<?php echo $this->item->toc; ?>
				<?php endif; ?>
		
				<?php echo $this->item->text; ?>
	
				<?php /** Begin Read More **/ if ($this->item->params->get('show_readmore') && $this->item->readmore) : ?>
				<p class="rt-readon-surround">
					<a href="<?php echo $this->item->readmore_link; ?>" class="readon"><span>
						<?php if ($this->item->readmore_register) :
							echo JText::_('Register to read more...');
						elseif ($readmore = $this->item->params->get('readmore')) :
							echo $readmore;
						else :
							echo JText::sprintf('Read more...');
						endif; ?></span>
					</a>
				</p>
				<?php /** End Read More **/ endif; ?>
	
				<?php echo $this->item->event->afterDisplayContent; ?>
			<?php if ($article_details_show) : ?>
			</div>
			<?php endif; ?>
		</div>
		<?php if ($article_details_show) : ?>
		<div class="rt-article-inner">
		<?php endif; ?>
			<?php /** Begin Article Sec/Cat **/ if (($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid)) : ?>
			<p class="rt-article-cat">
				<?php if ($this->item->params->get('show_section') && $this->item->sectionid && isset($this->section->title)) : ?>
				<span>
					<?php if ($this->item->params->get('link_section')) : ?>
						<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->item->sectionid)).'">'; ?>
					<?php endif; ?>
					<?php echo $this->escape($this->section->title); ?>
					<?php if ($this->item->params->get('link_section')) : ?>
						<?php echo '</a>'; ?>
					<?php endif; ?>
						<?php if ($this->item->params->get('show_category')) : ?>
						<?php echo ' - '; ?>
					<?php endif; ?>
				</span>
				<?php endif; ?>
				<?php if ($this->item->params->get('show_category') && $this->item->catid) : ?>
				<span>
					<?php if ($this->item->params->get('link_category')) : ?>
						<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug, $this->item->sectionid)).'">'; ?>
					<?php endif; ?>
					<?php echo $this->escape($this->item->category); ?>
					<?php if ($this->item->params->get('link_category')) : ?>
						<?php echo '</a>'; ?>
					<?php endif; ?>
				</span>
				<?php endif; ?>
			</p>
			<?php /** End Article Sec/Cat **/ endif; ?>
		<?php if ($article_details_show) : ?>
		</div>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>