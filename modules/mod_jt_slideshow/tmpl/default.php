<?php 
/**
* @version		$Id: default.php 00005 2009-11-10 00:00:00 umitkenan $
* @package		Joomla
* @subpackage	JT SlideShow Module
* @link 		http://www.jt.gen.tr
* @copyright	Copyright (C) Joomla Türkçe Eğitim ve Destek Sitesi. http://www.jt.gen.tr 
* @license		GNU/GPL
* @information  Based on jQuery Cycle Plugin
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
/* <![CDATA[ */
// Define default values
jQuery.fn.cycle.defaults.timeoutFn = <?php echo $this->timeoutFn; ?>;
jQuery.fn.cycle.defaults.prevNextClick = <?php echo $this->prevNextClick; ?>;
jQuery.fn.cycle.defaults.pagerClick = <?php echo $this->pagerClick; ?>;
jQuery.fn.cycle.defaults.pagerAnchorBuilder = '<?php echo $this->pagerAnchorBuilder; ?>'; 
jQuery.fn.cycle.defaults.end = <?php echo $this->end; ?>;
jQuery.fn.cycle.defaults.easing = <?php echo $this->easing; ?>;
jQuery.fn.cycle.defaults.easeIn = <?php echo $this->easeIn; ?>;
jQuery.fn.cycle.defaults.easeOut = <?php echo $this->easeOut; ?>;
jQuery.fn.cycle.defaults.animIn = <?php echo $this->animIn; ?>;
jQuery.fn.cycle.defaults.animOut = <?php echo $this->animOut; ?>;
jQuery.fn.cycle.defaults.cssBefore = <?php echo $this->cssBefore; ?>;
jQuery.fn.cycle.defaults.cssAfter = <?php echo $this->cssAfter; ?>;
jQuery.fn.cycle.defaults.fxFn = <?php echo $this->fxFn; ?>;
jQuery.fn.cycle.defaults.height = '<?php echo $this->height; ?>';
jQuery.fn.cycle.defaults.startingSlide = <?php echo $this->startingSlide; ?>;
jQuery.fn.cycle.defaults.sync = <?php echo $this->sync; ?>;
jQuery.fn.cycle.defaults.autostopCount = <?php echo $this->autostopCount; ?>;
jQuery.fn.cycle.defaults.slideExpr = <?php echo $this->slideExpr; ?>;
jQuery.fn.cycle.defaults.cleartype = !jQuery.support.opacity; // true if clearType corrections should be applied (for IE) 
jQuery.fn.cycle.defaults.fastOnEvent = <?php echo $this->fastOnEvent; ?>;
jQuery.fn.cycle.defaults.manualTrump = <?php echo $this->manualTrump; ?>;
jQuery.fn.cycle.defaults.requeueOnImageNotLoaded = <?php echo $this->requeueOnImageNotLoaded; ?>;
jQuery.fn.cycle.defaults.requeueTimeout = <?php echo $this->requeueTimeout; ?>

// Main codes
jQuery(document).ready(function(){
	// Hide the loading message box
	jQuery('#<?php echo $this->boxname; ?>loading').hide();

	// Show Footer (using css)
	jQuery('#<?php echo $this->boxname; ?>footer').css({ display: 'block' });
	// Show SlideShow box (using css)
	jQuery('#<?php echo $this->boxname; ?>').css({ display: 'block' });
	// Show navigation bar (using css)
	jQuery('#<?php echo $this->boxname; ?>navigationbar').css({ display: 'block' });
	// Show pagination bar (using css)
	jQuery('#<?php echo $this->boxname; ?>nav').css({ display: 'block' });

	// Checking the gallery
	var showgallery = <?php echo $this->showgallery; ?>;

	// If gallery is on
	if(showgallery == 1) {
		jQuery('#<?php echo $this->boxname; ?>') .before('<ul id="<?php echo $this->boxname; ?>gallery">') .cycle({
			fx: '<?php echo $this->fx; ?>',
			timeout: <?php echo $this->timeout; ?>, 
			continuous: <?php echo $this->continuous; ?>,
			speed: <?php echo $this->speed; ?>,
			speedIn: <?php echo $this->speedIn; ?>, 
			speedOut: <?php echo $this->speedOut; ?>,
			next: '#<?php echo $this->next; ?>',
			prev: '#<?php echo $this->prev; ?>',
			pager: '#<?php echo $this->boxname; ?>gallery',
			pagerEvent: '<?php echo $this->pagerEvent; ?>', 
			pagerAnchorBuilder: function(idx, slide) { var src = jQuery('img',slide).attr('src'); return '<li><a href="javascript:void(0);"><img src="' + src + '" width="<?php echo $this->gallerythumbnailwidth; ?>" height="<?php echo $this->gallerythumbnailheight; ?>" /><\/a><\/li>'; },
			before: <?php echo $this->before; ?>,
			after: <?php echo $this->after; ?>,
			shuffle: <?php echo $this->shufflesetting; ?>,
			random: <?php echo $this->random; ?>,
			fit: <?php echo $this->fit; ?>,
			containerResize: <?php echo $this->containerResize; ?>,
			pause: <?php echo $this->pause; ?>,
			pauseOnPagerHover: <?php echo $this->pauseOnPagerHover; ?>,
			autostop: <?php echo $this->autostop; ?>,
			delay: <?php echo $this->delay; ?>,
			nowrap: <?php echo $this->nowrap; ?>,
			randomizeEffects: <?php echo $this->randomizeEffects; ?>,
			rev: <?php echo $this->rev; ?>
		});
	}
	// If gallery is off
	else { 
		jQuery('#<?php echo $this->boxname; ?>').cycle({
			fx: '<?php echo $this->fx; ?>',
			timeout: <?php echo $this->timeout; ?>, 
			continuous: <?php echo $this->continuous; ?>,
			speed: <?php echo $this->speed; ?>,
			speedIn: <?php echo $this->speedIn; ?>, 
			speedOut: <?php echo $this->speedOut; ?>,
			next: '#<?php echo $this->next; ?>',
			prev: '#<?php echo $this->prev; ?>',
			pager: '#<?php echo $this->boxname; ?>nav',
			pagerEvent: '<?php echo $this->pagerEvent; ?>', 
			before: <?php echo $this->before; ?>,
			after: <?php echo $this->after; ?>,
			shuffle: <?php echo $this->shufflesetting; ?>,
			random: <?php echo $this->random; ?>,
			fit: <?php echo $this->fit; ?>,
			containerResize: <?php echo $this->containerResize; ?>,
			pause: <?php echo $this->pause; ?>,
			pauseOnPagerHover: <?php echo $this->pauseOnPagerHover; ?>,
			autostop: <?php echo $this->autostop; ?>,
			delay: <?php echo $this->delay; ?>,
			nowrap: <?php echo $this->nowrap; ?>,
			randomizeEffects: <?php echo $this->randomizeEffects; ?>,
			rev: <?php echo $this->rev; ?>			
		});
	};
});
/* ]]> */
</script>

<div class="JT-ClearBox"></div>

<?php echo $this->loading; ?>

<?php if ($this->navigationbarposition == 'top') echo $this->navigationbarcontent.'<div class="JT-ClearBox"></div>'; ?>

<?php if ($this->paginationbarposition == 'top') echo $this->paginationbarcontent.'<div class="JT-ClearBox"></div>'; ?>

<?php if ($this->captionposition == 'top') echo $this->caption.'<div class="JT-ClearBox"></div>'; ?>

<?php if ($this->pagination == 0 && $this->gallery == 1) echo $this->gallerycontent; ?>

<div id="<?php echo $this->boxname; ?>">
	<?php for ( $i=0 ; $i < count($this->image) ; $i++ ) echo $this->slideshowcontent[$i]; ?>
</div>

<div class="JT-ClearBox"></div>

<?php if ($this->captionposition == 'bottom') echo $this->caption.'<div class="JT-ClearBox"></div>'; ?>

<?php if ($this->paginationbarposition == 'bottom') echo $this->paginationbarcontent.'<div class="JT-ClearBox"></div>'; ?>

<?php if ($this->navigationbarposition == 'bottom') echo $this->navigationbarcontent.'<div class="JT-ClearBox"></div>'; ?>

<?php echo $this->jtslideshowfooter; ?>

<script type="text/javascript">jQuery.noConflict();</script>