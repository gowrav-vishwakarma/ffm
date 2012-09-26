<?php
header("Content-type: text/css; charset: UTF-8");
$id = $_GET['id'];
$height = $_GET['height'];
$sidebar_width = $_GET['sw'];
?>
.mask<?php echo $id; ?>,
.mask<?php echo $id; ?> .sliderwrapper,
.mask<?php echo $id; ?> .contentdiv,
#paginate-slider<?php echo $id; ?> {
	height: <?php echo $height; ?>px;
}