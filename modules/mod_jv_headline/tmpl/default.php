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

$document 		= JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_jv_headline/assets/css/jvslidecontent.css');
$document->addScript(JURI::base() . 'modules/mod_jv_headline/assets/js/jvheadline.js');

$pagWidthCss 	= "width:" . $params->get('jv_news_slidebar_width') . "px";
$panelWidthCss 	= "width:" . ($params->get('news_thumb_width') -5) . "px";
$enableLink 	= $params->get('link_limage');
if(count($list_slidecontent) != 0) {
?>
<div style="display: none;"><a title="Joomla Templates" href="http://www.ZooTemplate.com">Joomla Templates</a> and Joomla Extensions by ZooTemplate.com</div>
<div class="jv-headline-news">
		<!--<div id="titledirect">-->
		<div id="paginate-slider<?php echo $module->id; ?>" class="jv-headline-pagination" style="<?php echo $pagWidthCss; ?>">		
			<?php foreach($list_slidecontent as $item) : ?>
			<a href="<?php echo $item->link; ?>" class="toc"><span><?php echo $item->title; ?></span></a>
			<?php endforeach; ?>			
		</div>
		<div class="mask<?php echo $module->id; ?>">
			<div id="slider<?php echo $module->id; ?>" class="sliderwrapper" style="<?php echo $panelWidthCss; ?>">
				<?php foreach($list_slidecontent as $itemSubject) : ?>
				<div class="contentdiv" style="<?php echo $panelWidthCss; ?>">					
					<?php if($itemSubject->thumbl) : ?>
						<p>
						<?php if($enableLink>0){?>
						<a href="<?php echo $itemSubject->link; ?>" class="readone"><img src="<?php echo $itemSubject->thumbl; ?>" alt="<?php echo $itemSubject->title; ?>" /></a>
						<?php }else{?>
						<img src="<?php echo $itemSubject->thumbl; ?>" alt="<?php echo $itemSubject->title; ?>" />
						<?php }?>
						</p>
					<?php endif; ?>

					<?php if($itemSubject->thumb_diff) : ?>
						<p><img src="<?php echo $itemSubject->thumb_diff; ?>" alt="<?php echo $itemSubject->title; ?>" width="<?php echo $thumbsize; ?>" height="<?php echo $thumbsize; ?>" /></p>
					<?php endif; ?>

					<h2><?php echo $itemSubject->title; ?></h2>
					<p><?php echo $itemSubject->introtext; ?></p>
					<p><a href="<?php echo $itemSubject->link; ?>" class="readone"><?php echo JText::_('Detail'); ?></a></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
<br class="clearfix" />
</div>
<script type="text/javascript">
<!--
/* <![CDATA[ */
	window.addEvent('domready',function(){
		featuredcontentslider.init({
			id: "slider<?php echo $module->id; ?>",  //id of main slider DIV
			contentsource: ["inline", ""],  //Valid values: ["inline", ""] or ["ajax", "path_to_file"]
			toc: "markup",  //Valid values: "#increment", "markup", ["label1", "label2", etc]
			nextprev: ["Previous", "Next"],  //labels for "prev" and "next" links. Set to "" to hide.
			revealtype: "<?php echo $params->get('news_event_type'); ?>", //Behavior of pagination links to reveal the slides: "click" or "mouseover"
			enablefade: [true, 0.2],  //[true/false, fadedegree]
			autorotate: [<?php echo $autorun; ?>, <?php echo $timming; ?>],  //[true/false, pausetime]
			onChange: function(previndex, curindex){  //event handler fired whenever script changes slide
				//previndex holds index of last slide viewed b4 current (1=1st slide, 2nd=2nd etc)
				//curindex holds index of currently shown slide (1=1st slide, 2nd=2nd etc)
			}
		});
	});
/* ]]> */
-->
</script>

<?php } ?>