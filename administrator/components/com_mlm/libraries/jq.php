<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Joomla
 * 
 * @package ci_jq_doct
 * @author 
 * @copyright 2010
 * @version $Id$
 * @access public
 */
class JQ {

    protected static $_instance;
    private $_initialised;
    private $_js = array();
    private $_css = array();
    private $_domReady = array();
    private $_widgets = array();
    private $_flashMessages = array();
    private $ci;
    private $_Tabs;

    /**
     * Joomla::__construct()
     * 
     * @return void
     */
    function __construct() {
        $this->ci = & get_instance();
        $this->_js += array('js/jquery-1.4.2.js', 'js/noconflict.js','js/ui/jquery-ui-1.8.12.custom.min.js', 'js/shortkeys.js', 'js/jquery.tooltip.js', 'js/jquery.datepick.js', 'js/formvalidator/jquery.ufvalidator.js');
//        $this->_js += array('js/jquery-1.4.2.js');
        $this->_css += array('css/jquery.css', 'css/greenstyle/jquery-ui-1.8.12.custom.css', 'css/jquery.tooltip.css', 'css/jquery.datepick.css', 'js/formvalidator/assets/reset.css', 'js/formvalidator/assets/styles.css');
    }

    /**
     * Joomla::getInstance()
     * 
     * @return
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getHeader($forajax=false) {
        $document = JFactory::getDocument();
        $admin = "administrator/";
        if (strpos(JPATH_BASE, "administrator"))
            $admin = "";
        if (!$forajax) {
            $this->setCodeForConfirmBox(".confirminwindow");
            $this->setCodeForAlertBox(".alertinwindow");
            foreach ($this->_js as $s) {
                $document->addScript("${admin}components/com_mlm/libraries/jq/$s");
//                echo "<script src=" . base_url() . "system/application/libraries/jq/" . $s .
//                " type='text/javascript'></script>\n";
            }
            foreach ($this->_css as $s) {
                $document->addStyleSheet("${admin}components/com_mlm/libraries/jq/$s");
//                echo "<link href=" . base_url() . "system/application/libraries/jq/" . $s .
//                " rel='stylesheet' type='text/css' />\n";
            }
        }
        // DOM READY SCRIPTS
        $domReady = "";
        $domReady .="
jQuery(function($) {
";
        if ($this->_domReady != '') {
            $domReady .= "$(document).ready(function() {\n";
            foreach ($this->_domReady as $d) {
                $domReady .= $d;
            }
            $domReady .= "});\n";
        }
        $domReady .= "
            });
            ";

        if ($forajax) {
            echo '<script type="text/javascript">';
//            echo "jQuery(function($) {
//$(document).ready(function() {\n";
            echo $domReady;
//            echo "});\n";
//            echo '});';
            echo "</script>";
        }
        else
            $document->addScriptDeclaration($domReady);
//        echo $domReady;
    }

    public function addCss($css) {
        if (!is_array($css)) {
            $css = array($css);
        }
        $this->_css = array_merge($this->_css, $css);
    }

    public function addJs($js) {
        if (!is_array($js)) {
            $js = array($js);
        }
        $this->_js = array_merge($this->_js, $js);
    }

    public function addDomReadyScript($script) {
        if (!is_array($script)) {
            $script = array($script);
        }
        $this->_domReady = array_merge($this->_domReady, $script);
    }

    public function addError($title='', $message='') {
        $newMsg = array('title' => $title, 'content' => $message, 'type' => 'Error');
        $this->_flashMessages = array_merge($this->_flashMessages, array($newMsg));
        $this->ci->session->set_userdata('flashMessages', $this->_flashMessages);
    }

    public function addInfo($title, $message) {
        $newMsg = array('title' => $title, 'content' => $message, 'type' => 'Info');
        $this->_flashMessages = array_merge($this->_flashMessages, array($newMsg));
        $this->ci->session->set_userdata('flashMessages', $this->_flashMessages);
    }

    public function getFlashMessages() {
        $this->_flashMessages = $this->ci->session->userdata('flashMessages');
        $this->ci->session->set_userdata('flashMessages', '');
        return $this->_flashMessages;
    }

    public function flashMessages($toReturn=false) {
        $this->_flashMessages = $this->ci->session->userdata('flashMessages');
        $this->ci->session->set_userdata('flashMessages', '');
        $html = "";
        if (!is_array($this->_flashMessages))
            return;
        foreach ($this->_flashMessages as $flmsg) {
            $mode = "error";
            if ($flmsg['type'] == "Info")
                $mode = "highlight";
            $html .= '<div class="ui-widget">
						<div class="ui-state-' . $mode . ' ui-corner-all" style="padding: 0 .7em;">
							<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
								<strong>' . $flmsg['title'] . '</strong> ' . $flmsg["content"] . '</p>
							</div>
						</div>
						';
        }

        $this->_flashMessages = array();
        if ($toReturn)
            return $html;
        else
            echo $html;
    }

    public function loadWidget($widget, $config=array()) {
        $path = APPPATH . 'libraries/jq/widgets/' . $widget . "/" . $widget . EXT;
        if (!file_exists($path)) {
            throw new Exception("Widget $widget not found at $path");
            return;
        }
        require_once($path);
        $w = new $widget($config);
        $this->_widgets = array_merge($this->_widgets, array($w));
        return $w;
    }

    public function array_to_json($array) {

        if (!is_array($array)) {
            return false;
        }

        $associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
        if ($associative) {

            $construct = array();
            foreach ($array as $key => $value) {

                // We first copy each key/value pair into a staging array,
                // formatting each key and value properly as we go.
                // Format the key:
                if (is_numeric($key)) {
                    $key = "key_$key";
                }
                $key = "\"" . addslashes($key) . "\"";

                // Format the value:
                if (is_array($value)) {
                    $value = array_to_json($value);
                } else if (!is_numeric($value) || is_string($value)) {
                    $value = "\"" . addslashes($value) . "\"";
                }

                // Add to staging array:
                $construct[] = "$key: $value";
            }

            // Then we collapse the staging array into the JSON form:
            $result = "{ " . implode(", ", $construct) . " }";
        } else { // If the array is a vector (not associative):
            $construct = array();
            foreach ($array as $value) {

                // Format the value:
                if (is_array($value)) {
                    $value = $this->array_to_json($value);
                } else if (!is_numeric($value) || is_string($value)) {
                    $value = "'" . addslashes($value) . "'";
                }

                // Add to staging array:
                $construct[] = $value;
            }

            // Then we collapse the staging array into the JSON form:
            $result = "[ " . implode(", ", $construct) . " ]";
        }

        return $result;
    }

    function addTab($tabId, $title, $contents) {
        $this->_Tabs[$tabId]["titels"][] = $title;
        $this->_Tabs[$tabId]["contents"][] = $contents;
    }

    function getTab($tabID) {
        $titels = "";
        $contents = "";
        $i = 0;
        for ($i = 0; $i < count($this->_Tabs[1]['titels']); $i++) {
            $titels .='<li><a href="#tabs-' . $i . '">' . $this->_Tabs[$tabID]['titels'][$i] . '</a></li>';
            $contents .='<div id="tabs-' . $i . '">' . $this->_Tabs[$tabID]['contents'][$i] . '</div>';
        }

        $html = "<div id='tab$tabID'><ul>$titels</ul>$contents</div>";
        $script = "$(function() {
                            $( '#tab$tabID' ).tabs();
                    });
                    ";
        $this->ci->jq->addDomReadyScript($script);
        return $html;
    }

    function setCodeForConfirmBox($id) {
        $script = '$("' . $id . '").each(function() {
			var $link = $(this);
			$link.click(function() {
                                var dialogDiv=$("<div></div>");
				var $dialog = $(dialogDiv)
				.load($link.attr("href"))
				.dialog({
					autoOpen: false,
					title: $link.attr("title"),
					width: 600,
                                        buttons: {
                                                        "OK": function() {
                                                                $(dialogDiv).load($link.attr("hrefok")+"/" +Math.random(Date.now()));
                                                        },
                                                        Cancel: function() {
                                                                $(this).dialog("close");
                                                        }
                                                  }
				});

				$dialog.dialog("open");

				return false;
			});
		});';
        $this->ci->jq->addDomReadyScript($script);
    }

    function setCodeForAlertBox($id) {
        $script = '$("' . $id . '").each(function() {
			var $link = $(this);
			$link.click(function() {
                                
                                var dialogDiv=$("<div></div>");
				var $dialog = $(dialogDiv)
				.load($link.attr("href"))
				.dialog({
					autoOpen: false,
					title: $link.attr("title"),
                                        height: document.documentElement.clientHeight,
					width: document.documentElement.clientWidth,
                                        modal: true
				});

				$dialog.dialog("open");

				return false;
			});
		});';
        $this->ci->jq->addDomReadyScript($script);
    }

    function useHtmlGraph() {
        $this->ci->jq->addJs('js/charting/js/visualize.jQuery.js');
        $this->ci->jq->addCss('js/charting/css/visualize.css');
//        $s="$('#table').visualize({type: 'bar', height: '300px', width: '420px'}).appendTo('#haha');
//        Add this domreadyscript to make any table in graph
        /*
         * <table style="display:none" id="table">
          <caption>2009 Employee Sales by Department</caption>
          <thead>
          <tr>
          <td></td>
          <th scope="col">food</th>
          <th scope="col">auto</th>
          <th scope="col">household</th>
          <th scope="col">furniture</th>
          <th scope="col">kitchen</th>
          <th scope="col">bath</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <th scope="row">Mary</th>
          <td>190</td>
          <td>160</td>
          <td>40</td>
          <td>120</td>

          <td>30</td>
          <td>70</td>
          </tr>
         *
         */
    }

    function useInlineGraph($selector='') {
        $this->ci->jq->addJs('js/jquery.sparkline.js');
        if ($selector != '') {
            $script = "\$('$selector').sparkline();";
            $this->ci->jq->addDomReadyScript($script);
        }
    }

    function useGraph() {
        $this->ci->jq->addJs('tabletograph/swfobject.js');
        $this->ci->jq->addJs('tabletograph/json/json2.js');
    }

    function getGraphObject($width, $height, $data_url, $targetDiv) {
        $str = '
                <script type="text/javascript">
                            swfobject.embedSWF(
                              "open-flash-chart.swf", "'.$targetDiv.'",
                              "'.$width.'", "'.$height.'",
                              "9.0.0", "expressInstall.swf",
                              {"data-file":"'.urlencode($data_url).'"}
                            );
                        </script>
                    </div>
                <div id="'.$targetDiv.'"></div>
                ';
        echo $str;
    }

    function useTableToGraph($selector='') {
        $this->useGraph();
        $this->ci->jq->addJs('tabletograph/attc.js');
    }

}

?>