<?php 
/**
 * @package JV Headline module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.mootools');

$document 	= JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/jv_boro.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/jv_boro.js');

$modHeight 	= "height:".$moduleHeight."px";
$modWidth 	= "width:".$moduleWidth."px";
?>
<script type="text/javascript">   
var startSlideshow<?php echo $moduleId; ?> = function() {
    var mySlideShow7<?php echo $module->id; ?>  = new JVSlideBoro({
        container:'jv_accordion<?php echo $moduleId; ?>',
        moduleHeight:<?php echo $moduleHeight; ?>,
        expandWidth:<?php echo $expandWidth; ?>,
        descHeight:<?php echo $descHeight; ?>,
        eventType:"<?php echo $params->get('jv9_eventtype'); ?>"              
    });       
};
window.addEvent('domready',startSlideshow<?php echo $moduleId; ?>);
</script>
<div style="display: none;"><a title="Joomla Templates" href="http://www.ZooTemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.com</div>
<div class="jv_headline_accord_wrap" style="<?php echo $modWidth; ?>">
<div class="jv_headline_accord_container" style="<?php echo $modHeight; ?>" id="jv_accordion<?php echo $moduleId; ?>">
	<?php foreach($list as $item) {?>
	<div class="featured">		
		<?php if($params->get('jv9_eventtype') != "click") { ?><a class="wrap" href="<?php echo $item->link;?>"> <?php } ?>
		<div class="lof_shadow"></div>
		<div class="feature_excerpt"><h4>
		<?php if($params->get('jv9_eventtype') == "click") { ?> <a href="<?php echo $item->link; ?>"><?php } ?>
		<?php echo $item->title; ?>
		<?php if($params->get('jv9_eventtype') == "click") { ?>  </a> <?php } ?>	
		</h4><?php echo $item->introtext; ?></div>
		<img width="<?php echo $thumbWidth; ?>" height="<?php echo $thumbHeight; ?>" src="<?php echo $item->thumbl;?>" alt="image" />
		<div class="sliderheading"><?php echo $item->title; ?></div>
		<?php if($params->get('jv9_eventtype') != "click") { ?> </a> <?php } ?>	
	</div>			
	<?php }?>
</div>
</div>