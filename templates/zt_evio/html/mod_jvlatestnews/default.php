<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$i = 0;
$count_list = count($list);
?>
<div class="latestnews" style="width:100%">
<?php foreach ($list as $item) :  ?>
	<?php $i++; ?>
	<?php if($i == $count_list) : ?>
	<div class="latestnewsitems last-item" style="width:<?php echo $item->width; ?>%">
	<?php else : ?>
	<div class="latestnewsitems" style="width:<?php echo $item->width; ?>%">
	<?php endif; ?>	
		<div class="latestnewsitems-inner">
			<h4 ><a href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>"><?php echo $item->title; ?></a></h4>
			
			<?php if($params->get('thumb')==1 && $item->thumb) : ?>
				<div style="display:block; text-align:center;">
					<img src="<?php echo $item->thumb; ?>" border="0" alt="<?php echo $item->title; ?>" />
				</div>
			<?php endif; ?>
			
			<?php if($params->get('showdate')==1) : ?>
				<span class="latestnewsdate"><?php echo $item->date; ?></span>
			<?php endif; ?>
			<p>
			<?php if($params->get('showintro')==1) echo '<span  style="margin: 0;">'.$item->introtext.'</span>'; ?>
			</p>
			<?php if($params->get('readmore')==1) : ?><a href="<?php echo $item->link; ?>" class="readone"><?php echo JText::sprintf('READ_MORE'); ?></a><?php endif; ?>
			
		</div>
	</div>
<?php endforeach; ?>
</div>
<div style="display: none;"><a href="http://www.joomlavision.com" title="Joomla Templates">Joomla Templates</a> and Joomla Extensions by JoomlaVision.Com</div>