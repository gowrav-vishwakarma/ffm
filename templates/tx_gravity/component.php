<?php
/**
 * @package   ZOE Template Framework by ThemExpert
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2010 ThemExpert LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * 
 * This Framework uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 * 
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
</head>

<body class="contentpane">
<div class="column">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</div>

</body>

</html>
