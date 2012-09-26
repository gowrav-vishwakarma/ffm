<?php
/**
* @module		Art News Ticker
* @copyright	Copyright (C) 2011 artetics.com
* @license		GPL
*/

defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$db = & JFactory::getDBO();
$moduleId = $module->id;

$loadJ = $params->get('loadJ', true);
$controls = $params->get('controls', 1);
if (!$controls) {
	$controls = 0;
}
$category = $params->get('category', '');
$titleText = $params->get('titleText', 'Latest');
$direction = $params->get('direction', 'ltr');

if ($loadJ) {
  $document->addScript( JURI::root() . 'modules/mod_artnewsticker/js/jquery.js' );
}
$document->addScript( JURI::root() . 'modules/mod_artnewsticker/js/jquery.nc.js' );
$document->addScript( JURI::root() . 'modules/mod_artnewsticker/js/script.js' );
$document->addStylesheet( JURI::root() . 'modules/mod_artnewsticker/css/style.css' );

$category = intval($category);
$query = 'SELECT * FROM #__content ';

if (isset($category) && $category) {
$query .= 'WHERE catid = ' . $category;
}
$query .= ' ORDER BY created DESC;';

$db->setQuery($query);
$rows = $db->loadObjectList();
?>

<ul id="js-news<?php echo $moduleId; ?>" class="js-hidden">
	<?php
	foreach ($rows as $row) {
		echo '<li class="news-item"><a href="' . JURI::root () . 'index.php?option=com_content&view=article&id=' . $row->id . '">' . $row->title . '</a></li>';
	}
	?>
</ul>
<script type="text/javascript">
    antjQuery(function () {
        antjQuery('#js-news<?php echo $moduleId; ?>').ticker({
			controls: <?php echo $controls; ?>,
            titleText: '<?php echo $titleText; ?>',
            direction: '<?php echo $direction; ?>'
		});
    });
</script>