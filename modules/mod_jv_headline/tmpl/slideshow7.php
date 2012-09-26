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
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/slideshow7.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/slideshow7.js');

$container = "jv_slide7_container".$moduleId;
$slideItem = "#jv_slide7_container".$moduleId." div.jv_slide7_item";
$butPre 	= "#jv_slide7_container".$moduleId." div.jv_but_pre";
$butNext 	= "#jv_slide7_container".$moduleId." div.jv_but_next";
$slideMain 	= "#jv_slide7_container".$moduleId." div.jv_slide7_main";
$slideDes 	= "#jv_slide7_container".$moduleId." div.jv_slide7_des_item";
$enableLink = $params->get('link_limage');
?>
<script type="text/javascript">
     var startSlideshow<?php echo $moduleId; ?> = function() {
        var mySlideShow7<?php echo $module->id; ?>  = new JVSlideShow7({
            container:'<?php echo $container; ?>',
            slideItem:'<?php echo $slideItem; ?>',
            butPre:'<?php echo $butPre; ?>',
            slideMain:'<?php echo $slideMain; ?>',
            slideDes:'<?php echo $slideDes; ?>',
            butNext:'<?php echo $butNext; ?>',
            mainWidth:<?php echo $mainModWidth; ?>,
            mainHeight:<?php echo $mainModHeight; ?>,
            autoRun:<?php echo $params->get('jv7_autorun'); ?>,
            slide7Delay:<?php echo $slideDelay; ?>,
            slide7Duration:<?php echo $params->get('trans_duration'); ?>,
            showButNext:<?php echo $showButNext; ?>,
			slideId: <?php echo $module->id;?>
        });       
    };
    window.addEvent('domready',startSlideshow<?php echo $module->id; ?>);
</script>
<div style="display: none;"><a title="Joomla Templates" href="http://www.zootemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.Com</div>
<div class="jv_headline7_wrap" id="jv_slide7<?php echo $moduleId; ?>">
    <div class="jv_headline7_container loading" id="jv_slide7_container<?php echo $moduleId; ?>">
        <div class="jv_slide7_main">  
            <?php
			$i=0;
			foreach($list as $item) { ?>
                <div class="jv_slide7_item"> 
					<?php if($i>1){?> 
						 <div class="jv_slide7_loading">
							  <div class="jv_slide7_headline<?php echo $module->id;?>_content_<?php echo $i;?>" rel="&lt;img src='<?php echo JURI::root().$item->thumb; ?>' alt='img' /&gt;">
								   <?php if($enableLink>0){?> 
										<a class="link<?php echo $module->id;?>_<?php echo $i;?>" href="<?php echo $item->link; ?>" style="cursor: pointer;"></a>
									<?php }?>
						 	  </div>
						 </div>
					<?php }else{?>
						 <div class="jv_slide7_headline<?php echo $module->id;?>_content_<?php echo $i;?>">
							  <?php if($enableLink>0){?> 
								   <a class="link<?php echo $module->id;?>_<?php echo $i;?>" href="<?php echo $item->link; ?>" style="cursor: pointer;"><img src="<?php echo $item->thumb; ?>" alt="img" /></a>
							   <?php }else{?>
								   <img src="<?php echo $item->thumb; ?>" alt="img" />
							   <?php }?>
						 </div>
					<?php }?>
                </div>
            <?php $i=$i+1;
			} ?>          
        </div>
        <?php if($showButNext == 1) { ?>
        <div class="jv_but_pre"></div>
        <div class="jv_but_next"></div>
        <?php } ?>       
        <?php foreach($list as $item) { ?>
        <div class="jv_slide7_des_item opaque" style="height:0px;opacity:0">
             <h3 class="title"><?php echo $item->title; ?></h3>        
             <p><?php echo $item->introtext; ?></p>
             <?php if($isReadMore){?> 
                <a class="readon" href="<?php echo $item->link; ?>"><?php echo JText::_('Read more'); ?></a>
             <?php } ?>
        </div>
        <?php } ?>       
    </div>
</div>
