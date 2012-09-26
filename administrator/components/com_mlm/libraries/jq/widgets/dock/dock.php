<?php
/*
 * Created on Oct 17, 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once(APPPATH.'libraries/jq/widgets/widgets'.EXT);
 
class dock implements JQWidgets{
	var $ci;
	private $items=array();
	private $id;
	private $dock;
	private $config;
	function dock($config){
		$this->config=$config;
		$this->dock['default']['id']="dock";
		$this->dock['default']['container']=".dock-container";
		$this->dock['default']['items']='
		 							<a class="dock-item" href="#"><span>Home</span><img src="images/home.png" alt="home" /></a>
		 							<a class="dock-item" href="#"><img src="images/email.png" alt="contact" /><span>Contact</span></a>
		 							';
		$this->ci =& get_instance();
		$this->ci->load->library('jq');
		$this->ci->jq->addJs(array('widgets/dock/js/interface.js'));
		$this->ci->jq->addCss(array('widgets/dock/style.css'));
		$script="$('#".$this->dock[$config]['id']."').Fisheye(
									{
										maxWidth: 50,
										items: 'a',
										itemsText: 'span',
										container: '".$this->dock[$config]['container']."',
										itemWidth: 40,
										proximity: 90,
										halign : 'center'
									}
								);\n";
		$this->ci->jq->addDomReadyScript(array($script));
	}
	
	function display(){
		$html='<div class="dock" id="'.$this->dock[$this->config]['id'].'">';
		$html .= '<div class="'.$this->dock[$this->config]['container'].'">';
		$html.=$this->dock[$this->config]['items'];
		$html.="</div></div>";
		echo $html;
	}
}
?>