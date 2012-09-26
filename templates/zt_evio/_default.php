<?php
/**
 * @copyright	Copyright (C) 2008 - 2011 ZooTemplate.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once (dirname(__FILE__).DS.'libs'.DS.'zt_tools.php');
include_once (dirname(__FILE__).DS.'zt_menus'.DS.'zt.common.php');
include_once (dirname(__FILE__).DS.'libs'.DS.'zt_vars.php');
unset($this->_scripts[$this->baseurl . '/media/system/js/caption.js']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<jdoc:include type="head" />
<?php JHTML::_('behavior.mootools'); ?>
	<?php
		$document = JFactory::getDocument();
		$document->addStyleSheet($ztTools->templateurl() . 'css/template.css');
		$document->addStyleSheet($ztTools->baseurl() . 'templates/system/css/system.css');
		$document->addStyleSheet($ztTools->baseurl() . 'templates/system/css/general.css');
		$document->addStyleSheet($ztTools->templateurl() . 'css/default.css');
		
		if($ztrtl == 'rtl') {
			$document->addStyleSheet($ztTools->templateurl() . 'css/template_rtl.css');
			$document->addStyleSheet($ztTools->templateurl() . 'css/typo_rtl.css');
		} else {
			$document->addStyleSheet($ztTools->templateurl() . 'css/typo.css');
		}
		
		if($ztTools->getParam('zt_fontfeature')) {
			$document->addStyleSheet($ztTools->templateurl() . 'css/fonts.css');
		}
		
		$document->addScript($ztTools->templateurl() . 'js/zt.script.js');
		$document->addScript($ztTools->templateurl() . 'js/lazyEffects.js');
	?>

	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/modules.css" type="text/css" />		
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/css3.php?url=<?php echo $ztTools->templateurl(); ?>" type="text/css" />
	<script type="text/javascript">
		var baseurl = "<?php echo $ztTools->baseurl() ; ?>";
		var ztpathcolor = '<?php echo $ztTools->templateurl(); ?>css/colors/';
		var tmplurl = '<?php echo $ztTools->templateurl();?>';
		var CurrentFontSize = parseInt('<?php echo $ztTools->getParam('zt_font');?>');
	</script>
	<!--[if lte IE 6]>
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/ie6.css" type="text/css" />
	<script type="text/javascript" src="<?php echo $ztTools->templateurl() ?>js/ie_png.js"></script>
	<script type="text/javascript">
	window.addEvent ('load', function() {
	   ie_png.fix('.png');
	});
	</script>
	<![endif]-->
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/ie7.css" type="text/css" />
	<![endif]-->
</head>
<body id="bd" class="fs<?php echo $ztTools->getParam('zt_font'); ?> <?php echo $ztTools->getParam('zt_display'); ?> <?php echo $ztTools->getParam('zt_display_style'); ?> <?php echo $ztrtl; ?>">
<div id="zt-wrapper">

	<!-- HEADER -->
	<div id="zt-header" class="clearfix">
		<div class="zt-wrapper">
			<div id="zt-header-inner">
				<?php if($isMobile) { ?>
					<a class="btmodile" href="<?php echo $ztTools->baseurl() ; ?>?ismobile=1">Desktop layout</a>
				<?php }?>
				<div id="zt-logo">
					<h1 id="logo"><a class="png" href="<?php echo $ztTools->baseurl() ; ?>" title="<?php echo $ztTools->sitename() ; ?>">
						<span><?php echo $ztTools->sitename() ; ?></span></a>
					</h1>
				</div>
				<div id="zt-mainmenu" >
					<div id="zt-mainmenu-inner" >
						<?php $menu->show(); ?>
					</div>
				</div>

			</div>
			
		</div>
	</div>
	<!-- END HEADER -->
	
	<?php if($this->countModules('slideshow')) : ?>	
		<div id="zt-slideshow" class="clearfix">
			<div class="zt-wrapper">	
				<div id="zt-slideshow-inner">
					<jdoc:include type="modules" name="slideshow" style="ztxhtml" />
				</div>	
			</div>
		</div>		
	<?php endif; ?>
	
	<?php if($this->countModules('top1') || $this->countModules('top1')
		|| $this->countModules('user1') || $this->countModules('user2')|| $this->countModules('user3') || $this->countModules('user4')|| $this->countModules('highlight1') || $this->countModules('highlight2')) : ?>
		
		<div id="zt-userwrap1" class="clearfix">
			<div id="zt-userwrap1-inner">
				<?php
				$spotlight = array ('top1','top2');
				$consl = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:100,'%',58);
				if( $consl) :
				?>	
					<div id="zt-mass-top">
						<div class="zt-wrapper">
							<?php if($this->countModules('top1')) : ?>
							<div id="zt-top1" class="zt-user zt-box<?php echo $consl['top1']['class']; ?>" style="width: <?php echo $consl['top1']['width']; ?>;">
								<div class="zt-box-inside">
									<jdoc:include type="modules" name="top1" style="ztxhtml" />
								</div>
							</div>
							<?php endif; ?>
							
							<?php if($this->countModules('top2')) : ?>
							<div id="zt-top2" class="zt-user zt-box<?php echo $consl['top2']['class']; ?>" style="width: <?php echo $consl['top2']['width']; ?>;">
								<div class="zt-box-inside">
									<jdoc:include type="modules" name="top2" style="ztxhtml" />
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				
				<?php
				$spotlight = array ('user1','user2','user3','user4');
				$cons2 = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:99,'%');
				if( $cons2) :
				?>	
				<div id="zt-mass-mid">
					<div class="zt-wrapper">
						<?php if($this->countModules('user1')) : ?>
						<div id="zt-user1" class="zt-user zt-box<?php echo $cons2['user1']['class']; ?>" style="width: <?php echo $cons2['user1']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user1" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
						
						<?php if($this->countModules('user2')) : ?>
						<div id="zt-user2" class="zt-user zt-box<?php echo $cons2['user2']['class']; ?>" style="width: <?php echo $cons2['user2']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user2" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
						
						<?php if($this->countModules('user3')) : ?>
						<div id="zt-user3" class="zt-user zt-box<?php echo $cons2['user3']['class']; ?>" style="width: <?php echo $cons2['user3']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user3" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
						
						<?php if($this->countModules('user4')) : ?>
						<div id="zt-user4" class="zt-user zt-box<?php echo $cons2['user4']['class']; ?>" style="width: <?php echo $cons2['user4']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user4" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>	
				<?php endif; ?>
		
				<?php
				$spotlight = array ('breadcrumb','highlight2');
				$cons3 = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:100,'%');
				if( $cons3) :
				?>	
					<div id="zt-mass-bot">
						<div class="zt-wrapper">
							<div id="zt-mass-bot-inner">
								<?php if($this->countModules('breadcrumb')) : ?>
								<div id="zt-breadcrumb" class="zt-user zt-box<?php echo $cons3['breadcrumb']['class']; ?>" style="width: <?php echo $cons3['breadcrumb']['width']; ?>;">
									<div class="zt-box-inside">
										<span class="first"><strong><?php echo JText::_('YOU_ARE_HERE')?></strong></span> <jdoc:include type="modules" name="breadcrumb" />
									</div>
								</div>
								<?php endif; ?>
								
								<?php if($this->countModules('highlight2')) : ?>
								<div id="zt-highlight2" class="zt-user zt-box<?php echo $cons3['highlight2']['class']; ?>" style="width: <?php echo $cons3['highlight2']['width']; ?>;">
									<div class="zt-box-inside">
										<jdoc:include type="modules" name="highlight2" style="ztxhtml" />
									</div>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
			</div>
		</div>
	<?php endif; ?>	
	
	
	<!-- MAINBODY -->
	<div id="zt-mainbody" class="clearfix">
		<div id="zt-mainbody-inset">
		<div id="zt-mainbody-inner"  class="zt-container<?php echo $zt_width; ?>">
			<div id="zt-mainbody1">
			<div id="zt-mainbody2">
			<div id="zt-mainbody3">				
				<div class="zt-wrapper">
				
					<!-- CONTAINER -->
					<div id="zt-container" class="clearfix">
							<?php if($this->countModules('left')) : ?>
							<div id="zt-left">
								<div id="zt-left-inner">
									<jdoc:include type="modules" name="left" style="ztxhtml" />
								</div>
							</div>
							<?php endif; ?>

							<div id="zt-maincontent">
								<div id="zt-maincontent-inner">
									
									<div id="zt-content">
										<?php if($this->countModules('user5')) : ?>
											<div id="zt-user5" >
												<jdoc:include type="modules" name="user5" style="ztxhtml" />
											</div>
										<?php endif; ?>
											<div id="zt-component" >
												<jdoc:include type="message" />
												<jdoc:include type="component" />
											</div>
									   <?php if($this->countModules('user6')) : ?>
										   <div id="zt-user6" >
												<jdoc:include type="modules" name="user6" style="ztxhtml" />
										   </div>
										<?php endif; ?>
									</div>
									
									<div id="zt-right">
										<div id="zt-right-inner">
											<jdoc:include type="modules" name="right" style="ztxhtml" />
										</div>
									</div>
								
								</div>
								
								<?php
							$spotlight = array ('col1','col2','col3');
							$botsl1 = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:99,'%');
							if( $botsl1 ) :
							?>
							<div id="zt-userwrap3" class="clearfix">
								<div id="zt-userwrap3-inner">
									<?php if($this->countModules('col1')) : ?>
										<div id="zt-col1" class="zt-user zt-box<?php echo $botsl1['col1']['class']; ?>" style="width: <?php echo $botsl1['col1']['width']; ?>;">
												<div class="zt-box-inside">
													<jdoc:include type="modules" name="col1" style="ztxhtml" />
												</div>
										</div>
									<?php endif; ?>
									
									<?php if($this->countModules('col2')) : ?>
										<div id="zt-col2" class="zt-user zt-box<?php echo $botsl1['col2']['class']; ?>" style="width: <?php echo $botsl1['col2']['width']; ?>;">
												<div class="zt-box-inside">
													<jdoc:include type="modules" name="col2" style="ztxhtml" />
												</div>	
										</div>
									<?php endif; ?>
									
									<?php if($this->countModules('col3')) : ?>
										<div id="zt-col3" class="zt-user zt-box<?php echo $botsl1['col3']['class']; ?>" style="width: <?php echo $botsl1['col3']['width']; ?>;">
												<div class="zt-box-inside">
													<jdoc:include type="modules" name="col3" style="ztxhtml" />
												</div>	
										</div>
									<?php endif; ?>
								</div>
							</div>	
							<?php endif; ?>
								
								
							</div>
							
							
							
						</div>
					<!-- END CONTAINER -->
				</div>
				
			</div>
			</div>	
			</div>	

			<?php
			$spotlight = array ('user7','user8','user9','user10');
			$botsl2 = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:100, '%');
			if( $botsl2 ) :
			?>
			<div id="zt-userwrap4" class="clearfix">
				<div class="zt-wrapper ">
					<div id="zt-userwrap4-inner" >	
						<?php if($this->countModules('user7')): ?>
						<div id="zt-user7" class="zt-user zt-box<?php echo $botsl2['user7']['class']; ?>" style="width:<?php echo $botsl2['user7']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user7" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>

						<?php if($this->countModules('user8')): ?>
						<div id="zt-user8" class="zt-user zt-box<?php echo $botsl2['user8']['class']; ?>" style="width:<?php echo $botsl2['user8']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user8" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>

						<?php if($this->countModules('user9')) : ?>
						<div id="zt-user9" class="zt-user zt-box<?php echo $botsl2['user9']['class']; ?>" style="width:<?php echo $botsl2['user9']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user9" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
							
						<?php if($this->countModules('user10')) : ?>
						<div id="zt-user10" class="zt-user zt-box<?php echo $botsl2['user10']['class']; ?>" style="width:<?php echo $botsl2['user10']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user10" style="ztrounded" />
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>	
		
		
		</div>		
		</div>
	</div>
	<!-- END MAINBODY -->
	
		
		
	<div id="zt-bottom" class="<?php echo $zt_positon; ?>">
		
		<?php
		$spotlight = array ('user11','user12','user13','user14');
		$botsl3 = $ztTools->calSpotlight ($spotlight,$ztTools->isOP()?100:100,'%');
		if( $botsl3 ) :
		?>	
		<div id="zt-userwrap5" class="clearfix zt-user14<?php echo $botsl3['user14']['class']; ?>">
			<div class="zt-wrapper">
				<div id="zt-userwrap5-inner" >
					<?php if($this->countModules('user11')) : ?>
						<div id="zt-user11" class="zt-user zt-box<?php echo $botsl3['user11']['class']; ?>" style="width: <?php echo $botsl3['user11']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user11" style="ztrounded" />
							</div>
						</div>
					<?php endif; ?>
				
					<?php if($this->countModules('user12')) : ?>
						<div id="zt-user12" class="zt-user zt-box<?php echo $botsl3['user12']['class']; ?>" style="width: <?php echo $botsl3['user12']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user12" style="ztrounded" />
							</div>
						</div>
					<?php endif; ?>
				
					<?php if($this->countModules('user13')) : ?>
						<div id="zt-user13" class="zt-user zt-box<?php echo $botsl3['user13']['class']; ?>" style="width: <?php echo $botsl3['user13']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user13" style="ztrounded" />
							</div>
						</div>
					<?php endif; ?>
				
					<?php if($this->countModules('user14')) : ?>
						<div id="zt-user14" class="zt-user zt-box<?php echo $botsl3['user14']['class']; ?>" style="width: <?php echo $botsl3['user14']['width']; ?>;">
							<div class="zt-box-inside">
								<jdoc:include type="modules" name="user14" style="ztrounded" />
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<?php endif; ?>
		
	
		<div class="zt-wrapper">
			<div id="zt-bottom-inner">
				<div id="zt-footer">
					<div id="zt-footer-inner"><jdoc:include type="modules" name="footer" /></div>
				</div>
				<div id="zt-copyright">
					<div id="zt-copyright-inner">
							<?php if($ztTools->getParam('zt_footer')) : ?>
							<?php echo $ztTools->getParam('zt_footer_text'); ?>
							<?php else : ?>
							Copyright &copy; 2008 - <?php echo date('Y'); ?> <a href="http://www.familyfuturebusiness.in" title="Family Future">Family Future Web Application</a>  <!-- by <a href="http://www.xaovc.com" title="Xavoc International">Xavoc International</a>&nbsp;(Xavoc is just Software Developer Company. It has no relation with plan, this company or any payment.)--><br /> Other companies of ARTH group is  <a href="http://www.arthindia.in" title="Arth India">Arth India</a> And   <a href="http://www.arthcredit.com" title="Arth credit">Arth Credit</a>. All rights reserved.
							<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</div>
	
</div>


<?php if($this->countModules('debug')) : ?>
<div class="clearfix">
<jdoc:include type="modules" name="debug" />
</div>
<?php endif; ?>


</body>
</html>