<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$html .= '
<script type="text/javascript" src="'.JURI :: base().'/components/com_forme/calendar/yahoo.js"></script>
<script type="text/javascript" src="'.JURI :: base().'/components/com_forme/calendar/event.js" ></script>
<script type="text/javascript" src="'.JURI :: base().'/components/com_forme/calendar/dom.js" ></script>
<script type="text/javascript" src="'.JURI :: base().'/components/com_forme/calendar/calendar.js"></script>
<link type="text/css" rel="stylesheet" href="'.JURI :: base().'/components/com_forme/calendar/calendar.css">

<script language="javascript">
    YAHOO.namespace("example.calendar");
</script>




';
?>