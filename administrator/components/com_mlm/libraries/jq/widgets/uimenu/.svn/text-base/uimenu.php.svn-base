<?php
/*
 * Created on Oct 17, 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once(APPPATH.'libraries/jq/widgets/widgets'.EXT);
 
class uimenu implements JQWidgets{
	var $ci;
	function uimenu($config=array()){
		$this->ci =& get_instance();
		$this->ci->load->library('jq');
//		$this->ci->jq->addJs(array('widgets/uimenu/js/webwidget_menu_dropdown.js'));
//		$this->ci->jq->addCss(array('widgets/uimenu/css/webwidget_menu_dropdown.css'));
                $this->ci->jq->addJs(array('widgets/uimenu/js/menu.js'));
		$this->ci->jq->addCss(array('widgets/uimenu/js/menu.css'));
//		$script="$('#webwidget_menu_dropdown').webwidget_menu_dropdown({
//				m_w: '130',   //Menu width
//				m_t_c: '#FFF',  //Text color
//				m_c_c: '#8FC45A',  //Current background color
//				m_bg_c: '#56A901',  //background color
//				m_b_s: '2',  //Menu margin
//				m_bg_h_c: '#8FC45A', //Mouse hover color
//				s_s: 'fast',  //Animation speed: slow  normal  fast  no-wait
//				m_s: 'medium'  //Menu size:large  medium  small
//				});\n";
//		$this->ci->jq->addDomReadyScript(array($script));
	}
	
	function display(){
		echo "menu here";
	}
}
?>
