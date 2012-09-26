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
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/slideshow6.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/slideshow6.js');

$cssModuleWidth = "width:".$moduleWidth."px";
$rightW 		= 0;
if($moduleWidth != $imgSlideWidth) $rightW = $moduleWidth - $imgSlideWidth - 10;
$leftWidth 	= "width:".$imgSlideWidth."px";
$rightWidth = "width:".$rightW."px";
$cssSlideImgHeight = "height:".$imgSlideHeight."px";
$slideImg = "#slide_image".$moduleId." div.slide_img";
$slideBar = "#s6bar_container".$moduleId." div.s6_itembar";
$descItem = "#des_container".$moduleId." div.descript_item";
$slideImgContainer = "slide_image".$moduleId;
$butNext 	= "#slide_image".$moduleId." div.s6_itembar_next";
$butPre 	= "#slide_image".$moduleId." div.s6_itembar_pre";
$enableLink = $params->get('link_limage');
?>
<script type="text/javascript">
    var startSlideshow<?php echo $moduleId; ?> = function() {
        var mySlideShow6<?php echo $module->id; ?>  = new JVSlideShow6({
            slideImg:'<?php echo $slideImg; ?>',
            slideBar:'<?php echo $slideBar; ?>',
            descItem:'<?php echo $descItem ?>',
            slideHeight:<?php echo $imgSlideHeight; ?>,
            slideWidth:<?php echo $imgSlideWidth; ?>,
            styleEffect:'<?php echo $params->get('sello1_animation'); ?>',
            delay:<?php echo $slideDelay; ?>,
            slide6transition:<?php echo $params->get('trans_duration'); ?>,
            slideImgContainer:'<?php echo $slideImgContainer; ?>',
            butNext:'<?php echo $butNext; ?>',
            butPre:'<?php echo $butPre; ?>',
            showButNext:<?php echo $showButNext;?>,
			linkimg: <?php echo $enableLink;?>,
			slideId: <?php echo $module->id;?>
        })
    };
    window.addEvent('load',function(){
        setTimeout(startSlideshow<?php echo $moduleId; ?>,200);
      }
    );
</script>
<div style="display: none;"><a title="Joomla Templates" href="http://www.ZooTemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.com</div>
<div class="jv_slideshow6_wrap" style="<?php echo $cssModuleWidth; ?>">
<div class="jv_slide6_wrap">
    <div class="jv_lslide6_wrap" style="<?php echo $leftWidth.";".$cssSlideImgHeight; ?>">
        <div class="slide_img_wrap loading" id="slide_image<?php echo $moduleId; ?>" style="<?php echo $cssSlideImgHeight; ?>">
         <?php if($showButNext == 1) {?> <div class="s6_itembar_pre" style="height:<?php echo $imgSlideHeight."px"; ?>"></div> <?php } ?>
            <?php
			$i=0;
			foreach($list as $item) { ?>
				<div class="slide_img opaque1" style="opacity:0">
					<?php if($i>1){?>
						<div class="jv_sello1_loading">
							<div id="jv_sello1_headline<?php echo $module->id;?>_content_<?php echo $i;?>" rel="&lt;img src='<?php echo $item->thumbl; ?>' height='<?php echo $imgSlideHeight ?>' width='<?php echo $imgSlideWidth; ?>' alt='image' /&gt;">
								<?php if($enableLink>0){?> 
									<a class="link<?php echo $module->id;?>_<?php echo $i;?>" href="<?php echo $item->link; ?>" style="cursor: pointer;"></a>
								<?php }else{?>
								<?php }?> 
							</div>
						</div>
					<?php }else{?>
						<div id="jv_sello1_headline<?php echo $module->id;?>_content_<?php echo $i;?>">
							<?php if($enableLink>0){?> 
								<a class="link<?php echo $module->id;?>_<?php echo $i;?>" href="<?php echo $item->link; ?>" style="cursor: pointer;"><img height="<?php echo $imgSlideHeight ?>" width="<?php echo $imgSlideWidth; ?>" src="<?php echo $item->thumbl; ?>" alt="image" /></a>
							<?php }else{?>
								<img height="<?php echo $imgSlideHeight ?>" width="<?php echo $imgSlideWidth; ?>" src="<?php echo $item->thumbl; ?>" alt="image" />
							<?php }?> 
						</div>
					<?php }?> 
				</div>
            <?php $i=$i+1;
			} ?>
            <?php if($showButNext == 1){ ?><div class="s6_itembar_next" style="height:<?php echo $imgSlideHeight."px"; ?>"></div><?php } ?>
        </div>       
    </div>
    <?php if($rightW !=0) { ?>    
    <div class="jv_rslide_wrap" style="<?php echo $rightWidth.";".$cssSlideImgHeight; ?>" >
    <?php } else { ?>
     <div class="jv_rslide_wrap" style="<?php echo $rightWidth.";".$cssSlideImgHeight.";display:none"; ?>" >
    <?php } ?>
        <div class="des_item_container" id="des_container<?php echo $moduleId; ?>">
        <?php foreach($list as $item) { ?>
        <div class="descript_item opaque1" style="opacity:0">          
              <h3 class="title"><?php echo $item->title; ?></h3>        
              <p><?php echo $item->introtext; ?></p> 
               <?php if($isReadMore){?> 
                <a class="readmore" href="<?php echo $item->link; ?>"><?php echo JText::_('Read more'); ?></a>
             <?php } ?>          
        </div>
        <?php } ?>
        </div>
    </div>
  </div>  
    <div class="slide6_itembar_wrap">
           <div class="s6bar_container" id="s6bar_container<?php echo $moduleId; ?>">          
           <?php foreach($list as $item) { ?>
            <div class="s6_itembar opaque" style="opacity:0.5">
                <img src="<?php echo $item->thumbs; ?>" alt="img" />
            </div>
            <?php } ?>          
           </div> 
    </div>
</div>

