<?php 
// no direct access
defined('_JEXEC') or die('Restricted access'); 
$document = &JFactory::getDocument();
$document->addStyleSheet("modules/mod_jv_titleflash/assets/css/jv.titleflash.css");
$document->addScript("modules/mod_jv_titleflash/assets/js/jv.titleflash.js");
?>
<div style="display: none;"><a href="http://www.zootemplate.com" title="Joomla Templates">Joomla Templates</a> and Joomla Extensions by ZooTemplate.Com</div>
<div class="jv-jvtitleflash">
	<div id="paginate-jvtitleflash<?php echo $module->id; ?>" class="jv-titleflash-pagination">
		<ul>
			<?php if($params->get('showtitle') == 1 ) : ?><li><span class="title"><?php echo $params->get('title'); ?></span></li><?php endif; ?>
            <?php if($params->get('showbutton') == 1) : ?>
			
			<li><a href="#" class="prev">&nbsp;</a><a href="#" class="next">&nbsp;</a></li>
            <?php endif; ?>
		</ul>
	</div>
	<div id="jvtitleflash<?php echo $module->id; ?>" class="sliderwrapper">
		<?php foreach($list as $itemSubject) : ?>
		<div class="contentdiv">
			<span class="cattitle"><?php if($params->get('style_display')==1 || $params->get('style_display') == 2 ) : ?><?php echo  $itemSubject->stitle; ?> - <?php endif; ?><?php echo $itemSubject->cat_title; ?>:</span> <a href="<?php echo $itemSubject->link; ?>" class="toc"><span><?php echo $itemSubject->title; ?></span></a><span class="jv-titleflash-time"> <?php if($params->get('style_display')==1 || $params->get('style_display') == 3 ) : ?>- <?php else : ?>(<?php endif; ?><?php echo JHTML::_('date', $itemSubject->created, JText::_('DATE_FORMAT_LC2')) ?><?php if($params->get('style_display')==2 || $params->get('style_display') == 4 ) : ?>)<?php endif; ?></span>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<script type="text/javascript">

	window.addEvent('domready',function(){
		featuredcontentslider.init({
			id: "jvtitleflash<?php echo $module->id; ?>", 
			contentsource: ["inline", ""], 
			toc: "markup",  
			nextprev: ["Previous", "Next"],  
			revealtype: "click", 
			enablefade: [true, 0.1], 
			autorotate: [true, 5000],  
			onChange: function(previndex, curindex){ 
				
			}
		});
	});

</script>