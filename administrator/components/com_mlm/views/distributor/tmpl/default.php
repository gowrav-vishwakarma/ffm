<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->jq->addJs('js/charting/js/excanvas.js');
//$this->jq->useHtmlGraph();
$this->jq->useInlineGraph();
$s="$('.inlinesparkline').sparkline();";
$this->jq->addDomReadyScript($s);
?>
<span class="inlinesparkline" values="1,2,3,2,3,2,6,5,3,4,2,3"></span>