<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
	
	<jdoc:include type="head" />
	<meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0;" name="viewport">	
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/default.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/mobile.css" type="text/css" />
	
	<script language="javascript" src="<?php echo $ztTools->templateurl(); ?>zt_menus/zt_drillmenu/jquery.min.js"></script>
	<script language="javascript" src="<?php echo $ztTools->templateurl(); ?>js/ladyoverlay.js"></script>
</head>
<body>
<a name="top"></a>
	
	<div id="zt-toolbar-btn">
		<a href="#" id="btn-search"></a>
		<?php if($this->countModules('mlogin')) : ?>
			<a href="#" id="btn-login"></a>
		<?php endif ?>	
		<a href="?ismobile=0" id="btn-destop"></a>
		<a href="?ismobile=1" id="btn-mobile"></a>
	</div>
	
	<div id="shadowbox_container">
		<?php if($this->countModules('msearch')) : ?>
		<div id="zt-search" >
			<div id="zt-search-inner">
				<a id="btn-search_close" href="#">close</a>
				<jdoc:include type="modules" name="msearch" style="ztmobile" />
			</div>
		</div>
		<?php endif?>
		
		<?php if($this->countModules('mlogin')) : ?>
		<div id="zt-sign">
			<div id="zt-sign-inner">
				<a id="btn-login_close" href="#">close</a>
				<jdoc:include type="modules" name="mlogin" style="ztmobile" />
			</div>	
		</div>
		<?php endif?>
		
	</div>
	
	<div id="zt-wrapper">
		<div id="zt-header">
			<div id="zt-header-inner">
				<a class="logo" href="<?php echo JURI::base();?>">
					<img src="<?php echo $ztTools->templateurl(); ?>images/mobile/logo.png" border="0" />
				</a>
				
			</div>
		</div>
		
		
		<div id="zt-navigation">
			<div id="zt-navigation-inner">
				<div id="drillcrumb"></div>
				<div id="drillmenu1" class="drillmenu">
					<?php $menu->show(); ?>
				</div>
			</div>
		</div>
		<div id="zt-mainbody">
			<div id="zt-mainbody-inner">
				<?php if($this->countModules('muser5')) : ?>
					<div id="zt-user5" class="clearfix">
						<jdoc:include type="modules" name="muser5" style="ztxhtml" />
					</div>
				<?php endif; ?>
				
				<div id="zt-content">
					<jdoc:include type="component" />
				</div>
				
				<?php if($this->countModules('muser6')) : ?>
				<div id="zt-user6">
					<jdoc:include type="modules" name="muser6" style="ztxhtml" />
				</div>
				<?php endif; ?>
			</div>
		</div>
	
		
		<div id="zt-bottom">
			<div id="zt-bottom-inner">
				<div id="zt-copyright">Copyright &copy; 2008 - <?php echo date('Y'); ?> <a href="http://www.zootemplate.com" title="Joomla Templates">Joomla Templates</a>  by <a href="http://www.zootemplate.com" title="ZooTemplate">ZooTemplate.Com</a>. All rights reserved.</div>
				<div id="pannel-top"><a href="#top">Top</a></div>
			</div>
		</div>
	
		<script type="text/javascript" language="javascript">
			window.addEvent("load", function(){     
				new LadyOverlay('btn-search', {
					id: 'zt-search'
				});
				new LadyOverlay('btn-login', {
					id: 'zt-sign'
				});
			});
		</script>
	</div>
</body>
</html>