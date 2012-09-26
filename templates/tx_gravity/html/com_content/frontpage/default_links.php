<?php
/**
 * @package   ZOE
 * @version   2.5.0 June 01, 2010
 * @author    YOOtheme http://www.yootheme.com & ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * These template overrides are based on the fantastic GNU/GPLv2 overrides created by YOOtheme (http://www.yootheme.com)
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<h3>
	<?php echo JText::_( 'More Articles...' ); ?>
</h3>

<ul class="tx-more-articles">
	<?php foreach ($this->links as $link) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($link->slug, $link->catslug, $link->sectionid)); ?>"><?php echo $this->escape($link->title); ?></a>
	</li>
	<?php endforeach; ?>
</ul>