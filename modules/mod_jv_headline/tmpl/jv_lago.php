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
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/vertical.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/jd.gallery_lago.js');

$slideCss 			= "height:".$moduleHeight."px;width:".$slide_width."px";
$navigatorLeftWidth = $params->get('jv_lago_main_width') - 14;
$navigatorLeftCss 	= "left:".$navigatorLeftWidth."px";
$autoPlay 			= $params->get('jv_lago_auto',1);
?>
<script type="text/javascript">
function startSlideshow<?php echo $module->id; ?>() {
    var mySlideshow<?php echo $module->id; ?> = new JVLagoGallery($('mySlideshow<?php echo $module->id; ?>'), {       
        defaultTransition:'<?php echo $params->get('lago_animation'); ?>',
        timed:<?php if($autoPlay) echo "true";else echo "false"; ?>,       
        baseClass: 'jdSlideshow',              
        embedLinks:false,        
        showCarousel: false,       
        showInfopane:true,               
        slideBarItem:'<?php echo $slideBarItem; ?>',    
        fadeDuration:<?php echo $params->get('trans_duration',500); ?>,
        showArrows:<?php if($showButNext == 1) : echo "true"; else : echo "false"; endif; ?>,        
        delay:'<?php echo $slideDelay; ?>',
        isNormalSmooth:0,
		itemBarHeight:<?php echo $params->get('lago_hitem_sliderbar',100); ?>,
        navItemsDisplay:<?php echo $params->get('max_show_item',3); ?>,
        moduleId:<?php echo $module->id; ?>     
    });
}
window.addEvent('domready',startSlideshow<?php echo $module->id; ?>);
</script>
<div style="display: none;"><a title="Joomla Templates" href="http://www.ZooTemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.com</div>
<div id="<?php echo $divHeadLine; ?>" class="jv_lagoheadline_wrap">
<div class="jv-maskslide" style=" <?php  echo $css_width; ?>;<?php echo $css_height; ?>">
<div id="slide_wrapper<?php echo $module->id; ?>">
<div id="slide_outer<?php echo $module->id; ?>" class="slide_outer">
  <div id="mySlideshow<?php echo $module->id; ?>" style="<?php echo $slideCss.";z-index:5"; ?>" >
     <?php foreach($slides as $item) { ?>
    <div class="imageElement">
        <h3>
        <?php if($params->get('lago_enable_link_apanel')) { ?>
        <a class="smooth_link" href="<?php echo $item->link; ?>">
        <?php } ?> 
        <?php echo $item->title; ?>
        <?php { ?></a> <?php } ?>
        </h3>
        <p><?php echo $item->introtext; ?></p>   
      <?php if($item->thumbl) { ?>   
       <img src="<?php echo $item->thumbl; ?>" class="full" alt="<?php echo $item->title; ?>" /> 
       <img src="<?php echo $item->thumbl; ?>" class="thumbnail" width="100" height="100" alt="<?php echo $item->title; ?>" />
       <?php } else { ?>
       <img border="0" alt="" class="full" src ="<?php echo JURI::base().'modules/mod_jv_headline/assets/images/nophoto.png'; ?>" />
       <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
</div>
</div>
<div id="jv_pagislide<?php echo $module->id; ?>" class="jv-pagislide" style="<?php echo $css_height.";".$css_slidebar_width.";".$navigatorLeftCss; ?>">
<ul class="nav_slideitems" style="top:0px">    
<?php foreach($slides as $item) { ?>
<li class="nav_item" style="<?php echo $css_item_heigth; ?>">	
	<div class="nav_slideitem_wrap">	
	 <div class="nav_slideitem">
       <?php if($item->thumbs !=''){ ?>       
      <img border="0" alt="thumbnail" src ="<?php echo JURI::base().$item->thumbs; ?>" />
       <?php } ?>
       <?php if($params->get('lago_enable_link_artslidebar')) { ?>
       <a class="slidetitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>  
       <?php } else { ?>
        <h3 class="slidetitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></h3>
       <?php } ?>   
       <p class="slidedes"><?php echo $item->introtext; ?></p>   
    </div>
    </div>
</li>   
<?php } ?>
</ul>
</div>    
</div>
