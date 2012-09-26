<?php 
/**
 * @package ZT Headline module for Joomla! 1.6
 * @author http://www.zootemplate.com
 * @copyright (C) 2011- ZooTemplate.Com
 * @license PHP files are GNU/GPL
**/
JHTML::_('behavior.mootools');
$document 	= JFactory::getDocument(); 
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/zt_flow.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/zt_flow.js');
$imgWidth = $params->get('zt_flow_thumb_width');
$imgHeight = $params->get('zt_flow_thumb_height');
$ztauto = $params->get('zt_play');
$mainWidth = $params->get('zt_flow_width');
$mainHeight = $params->get('zt_flow_height');
$shownext = $params->get('zt_flow_show_next');
$transaction = $params->get('zt_flow_duration');
$isReadMore = $params->get('zt_flow_readmore');
?>
<script type="text/javascript">
    var zt_slide<?php echo $module->id; ?> = function() {
        var zt_slideshow<?php echo $module->id; ?>  = new ZT_Flow({
            ztContainer: $('zt-container<?php echo $module->id; ?>'),
            items: $("zt-container<?php echo $module->id; ?>").getElements(".zt-items<?php echo $module->id; ?>"),
            content: $$('.zt-content<?php echo $module->id; ?>'),
            transaction: <?php echo $transaction;?>,
			imgwidth: <?php echo $imgWidth;?>,
			imgheight: <?php echo $imgHeight;?>,
            pagenext: $$('.zt-next<?php echo $module->id; ?>'),
            auto: <?php echo $ztauto;?>,
			shownext: <?php echo $shownext;?>
        })
    };
    window.addEvent('load',function(){
        setTimeout(zt_slide<?php echo $module->id; ?>,200);
    });
</script>
<div style="display: none;"><a title="Joomla Templates" href="http://www.zootemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.Com</div>
<div id="zt-slide" style="width: <?php echo $mainWidth;?>px; height: <?php echo $mainHeight;?>px">
	<div class="zt-mainContent" style="height: <?php echo $mainHeight;?>px">
		<?php foreach($list as $item){?>
		<div id="zt-content" class="zt-content<?php echo $module->id; ?>">
			<span class="zt-title"><a class="readon" href="<?php echo $item->link; ?>" title="Title content"><?php echo $item->title; ?></a></span>
			<p><?php echo $item->introtext ; ?></p>
			<?php if($isReadMore>0) { ?>
				<a class="readon" href="<?php echo $item->link; ?>" title="Title content"><?php echo JText::_('Read more'); ?></a>
			<?php } ?>
		</div>
		<?php }?>
	</div>
	<?php if($shownext>0){?>
	<div id="zt-next" class="zt-next<?php echo $module->id; ?>"> <img src="<?php echo JURI::base();?>modules/mod_jv_headline/assets/images/zt_flow/next.png" alt="next"/> </div>
	<?php }?>
	<div class="zt-container" id="zt-container<?php echo $module->id; ?>" style="height: <?php echo $mainHeight;?>px">
		<?php
			$i=0;
			foreach($list as $row){
			$width = $imgWidth-($i*32.3);
			$height = $imgHeight-($i*28.3);
			$imgLeft = 10+(($i*70.5)/1.6);
			$imgTop = 5-($i*(-10.5-($i)));
			$ztZindex = 51 - ($i+1);
		?>
		<div id="zt-items" style="z-index: <?php echo $ztZindex; ?>; background: url(<?php echo $row->thumbl;?>) no-repeat center top; visibility: visible; opacity: 1; width: <?php echo $width;?>px; height: <?php echo $height;?>px; left: <?php echo $imgLeft;?>px; top: <?php echo $imgTop;?>px;" class="zt-items<?php echo $module->id; ?>"></div>
		<?php $i=$i+1;}?>
	</div> 
</div> 





