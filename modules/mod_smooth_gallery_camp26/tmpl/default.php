<?php
/**
* Module Smooth Gallery For Joomla 1.5.x
* Versi			: 1.1
* Created by	: Reza Erauansyah, Rony Sandra Yofa Zebua And Camp26.Biz Team
* Email			: old_smu17@yahoo.com
* Created on	: 19 March 2008
* Las Modified 	: 12 November
* 
* URL			: www.camp26.biz
* License GPLv2.0 - http://www.gnu.org/licenses/gpl-2.0.html
* Based on jquery(http://www.jquery.com) and interface element (http://interface.eyecon.ro)
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$slidewidth 		= $params->get( 'slidewidth' );
$slideheight		= $params->get( 'slideheight' );
$slideduration 		= $params->get( 'slideduration' );
$slidedelay			= $params->get( 'slidedelay' );
$baseurl 			= JURI::base();

$image_status1 	= $params->get( 'image_status1' );
$slide_img1 		= $params->get( 'slide_img1' );
$image_url1 		= str_replace('&', '&amp;', $params->get( 'image_url1' ));
$image_title1 		= $params->get( 'image_title1' );
$image_description1 		= $params->get( 'image_description1' );

$image_status2 	= $params->get( 'image_status2' );
$slide_img2 		= $params->get( 'slide_img2' );
$image_url2 		= str_replace('&', '&amp;', $params->get( 'image_url2' ));
$image_title2 		= $params->get( 'image_title2' );
$image_description2 		= $params->get( 'image_description2' );

$image_status3 	= $params->get( 'image_status3' );
$slide_img3 		= $params->get( 'slide_img3' );
$image_url3 		= str_replace('&', '&amp;', $params->get( 'image_url3' ));
$image_title3 		= $params->get( 'image_title3' );
$image_description3 		= $params->get( 'image_description3' );

$image_status4 	= $params->get( 'image_status4' );
$slide_img4 		= $params->get( 'slide_img4' );
$image_url4 		= str_replace('&', '&amp;', $params->get( 'image_url4' ));
$image_title4 		= $params->get( 'image_title4' );
$image_description4 		= $params->get( 'image_description4' );

$image_status5 	= $params->get( 'image_status5' );
$slide_img5 		= $params->get( 'slide_img5' );
$image_url5 		= str_replace('&', '&amp;', $params->get( 'image_url5' ));
$image_title5 		= $params->get( 'image_title5' );
$image_description5 		= $params->get( 'image_description5' );

$image_status6 	= $params->get( 'image_status6' );
$slide_img6 		= $params->get( 'slide_img6' );
$image_url6 		= str_replace('&', '&amp;', $params->get( 'image_url6' ));
$image_title6 		= $params->get( 'image_title6' );
$image_description6 		= $params->get( 'image_description6' );

$image_status7 	= $params->get( 'image_status7' );
$slide_img7 		= $params->get( 'slide_img7' );
$image_url7 		= str_replace('&', '&amp;', $params->get( 'image_url7' ));
$image_title7 		= $params->get( 'image_title7' );
$image_description7 		= $params->get( 'image_description7' );

$image_status8 	= $params->get( 'image_status8' );
$slide_img8 		= $params->get( 'slide_img8' );
$image_url8 		= str_replace('&', '&amp;', $params->get( 'image_url8' ));
$image_title8 		= $params->get( 'image_title8' );
$image_description8 		= $params->get( 'image_description8' );

$image_status9 	= $params->get( 'image_status9' );
$slide_img9 		= $params->get( 'slide_img9' );
$image_url9 		= str_replace('&', '&amp;', $params->get( 'image_url9' ));
$image_title9 		= $params->get( 'image_title9' );
$image_description9 		= $params->get( 'image_description9' );

$image_status10 	= $params->get( 'image_status10' );
$slide_img10 		= $params->get( 'slide_img10' );
$image_url10 		= str_replace('&', '&amp;', $params->get( 'image_url10' ));
$image_title10 		= $params->get( 'image_title10' );
$image_description10 		= $params->get( 'image_description10' );

$mutul 	= $params->get( 'mutul', 1 );

echo "  <link rel=\"stylesheet\" href=\"".$baseurl."modules/mod_smooth_gallery_camp26/smooth_gallery/jd.gallery.css\" type=\"text/css\" />";
echo "  <link rel=\"stylesheet\" href=\"".$baseurl."modules/mod_smooth_gallery_camp26/smooth_gallery/layout.css\" type=\"text/css\" />";
if($mutul){
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_smooth_gallery_camp26/smooth_gallery/mootools.js\"></script>";}
echo "  <script type=\"text/javascript\" src=\"".$baseurl."modules/mod_smooth_gallery_camp26/smooth_gallery/jd.gallery.js\"></script>";

?>

<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true,
					fadeDuration: <?php echo $slideduration;?>,
					delay: <?php echo $slidedelay;?>,
					useThumbGenerator: true,
					textShowCarousel: 'More Images',
					thumbGenerator: '<?php echo $baseurl; ?>/modules/mod_smooth_gallery_camp26/resizer.php'
				});
			}
			window.onDomReady(startGallery);
</script>
<div>
	<div id="myGallery" style="width: <?php echo $slidewidth;?>px; height: <?php echo $slideheight;?>px;">
			<?php if ($image_status1==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title1;?></h3>
					<p><?php echo $image_description1; ?></p>
					<a href="<?php echo $image_url1 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img1; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status2==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title2;?></h3>
					<p><?php echo $image_description2; ?></p>
					<a href="<?php echo $image_url2 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img2; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status3==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title3;?></h3>
					<p><?php echo $image_description3; ?></p>
					<a href="<?php echo $image_url3 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img3; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status4==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title4;?></h3>
					<p><?php echo $image_description4; ?></p>
					<a href="<?php echo $image_url4 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img4; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status5==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title5;?></h3>
					<p><?php echo $image_description5; ?></p>
					<a href="<?php echo $image_url5 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img5; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status6==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title6;?></h3>
					<p><?php echo $image_description6; ?></p>
					<a href="<?php echo $image_url6 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img6; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status7==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title7;?></h3>
					<p><?php echo $image_description7; ?></p>
					<a href="<?php echo $image_url7 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img7; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status8==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title8;?></h3>
					<p><?php echo $image_description8; ?></p>
					<a href="<?php echo $image_url8 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img8; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status9==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title9;?></h3>
					<p><?php echo $image_description9; ?></p>
					<a href="<?php echo $image_url9 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img9; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
			<?php if ($image_status10==1) { ?>
			<div class="imageElement">
					<h3><?php echo $image_title10;?></h3>
					<p><?php echo $image_description10; ?></p>
					<a href="<?php echo $image_url10 ?>" title="open image" class="open"></a>
					<img src="<?php echo $baseurl?>/media/smooth_gallery/<?php echo $slide_img10; ?>" class="full" />
			</div>
			<?php } else { ?>
			<?php } ?>
			
	</div>
</div>