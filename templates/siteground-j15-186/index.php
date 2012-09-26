<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JPlugin::loadLanguage( 'tpl_SG1' );
define( 'path', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<?php
	$menu_name        = $this->params->get("menuName", "topmenu");
	$menu_type        = $this->params->get("menuType", "splitmenu");
	require(path .DS."styleloader.php");
	require(path .DS."utils.php");
?>
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

</head>

<body id="page_bg">
	<div id="holder">
		<div id="search"><jdoc:include type="modules" name="user4" /></div>
		<div class="clr"></div>
		<div class="logo">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<h1><a href="index.php"><?php echo $mainframe->getCfg('sitename') ;?></a></h1>
					</td>
				</tr>
			</table>
		</div>
		<div id="pillmenu">
			<?php if($mtype != "module") :
				echo $mainnav;
				else: ?>
				<jdoc:include type="modules" name="user3" />
			<?php endif;?>
		</div>
		<div class="clr"></div>
	</div>
	<div id="header"></div>
		
	<div id="content">		
		
		<?php if($this->countModules('left') and JRequest::getCmd('layout') != 'form') : ?>
		<div id="leftcolumn">
			<jdoc:include type="modules" name="left" style="rounded" />
			<br />
			<?php $sg = 'banner'; include "templates.php"; ?>
		</div>
		<?php endif; ?>
		
		<?php if($this->countModules('left') and $this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
		<div id="maincolumn">			
		<?php elseif($this->countModules('left') and !$this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
		<div id="maincolumn_left">
		<?php elseif(!$this->countModules('left') and $this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
		<div id="maincolumn_right">
		<?php else: ?>
		<div id="maincolumn_full">
		<?php endif; ?>
		
		
		<div class="nopad">
			<jdoc:include type="message" />
			<?php if($this->params->get('showComponent')) : ?>
				<jdoc:include type="component" />
			<?php endif; ?>
		</div>
			
		</div>
			
		<?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
		<div id="rightcolumn">
			<jdoc:include type="modules" name="right" style="rounded" />
		</div>
		<?php endif; ?>
		<div class="clr"></div>
		
		<div class="newsflash<?php if(!$this->countModules('user1') and JRequest::getCmd('layout') != 'form') : ?> only<?php endif; ?>">
			<jdoc:include type="modules" style="rounded" name="top" />
		</div>

		<div id="footer">
			<div id="sgf">
				<p>
					<jdoc:include type="modules" name="debug" />
					<?php $sg = ''; include "templates.php"; ?>
					<a href="http://validator.w3.org/check/referer">valid xhtml</a>
					<a href="http://jigsaw.w3.org/css-validator/check/referer">valid css</a>
				</p>
			</div>
		</div>
		
	</div>	
	
</body>
</html>