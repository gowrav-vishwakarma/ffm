<?php
/**
* @version 1.5.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright (c) 2008 - 2011 http://www.ZooTemplate.com. All rights reserved.
*/

/* 
 *DEFINE 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Class ZT_Tools
 */
class ZT_Tools {
	var $_tpl = null;
	var $template = '';
	var $_params_cookie = array();

	function ZT_Tools ($template, $_params_cookie = null) {
		$this->_tpl = $template;
		$this->template = $template->template;
		if(!$_params_cookie) {
			$_params_cookie = array();
		}

		if ($this->getParam('zt_font') && !in_array($this->getParam('zt_font'), $_params_cookie)) {
			$_params_cookie[]= 'zt_font';
		}
		if ($this->getParam('zt_menustyle') && !in_array($this->getParam('zt_menustyle'), $_params_cookie)) {
			$_params_cookie[]= 'zt_menustyle';
		}
		foreach ($_params_cookie as $k) {
			$this->_params_cookie[$k] = $this->_tpl->params->get($k);
		}
		$this->getUserSetting();
	}

	function getUserSetting(){
		$exp = time() + 60*60*24*355;
		if (isset($_COOKIE[$this->template.'_tpl']) && $_COOKIE[$this->template.'_tpl'] == $this->template){
			foreach($this->_params_cookie as $k=>$v) {
				$kc = $this->template."_".$k;
				if (isset($_GET[$k])){
					$v = $_GET[$k];
					setcookie ($kc, $v, $exp, '/');
				}else{
					if (isset($_COOKIE[$kc])){
						$v = $_COOKIE[$kc];
					}
				}
				$this->setParam($k, $v);
			}

		}else{
			@setcookie ($this->template.'_tpl', $this->template, $exp, '/');
		}
		return $this;
	}

	function getParam ($param, $default='') {
		if (isset($this->_params_cookie[$param])) {
			return $this->_params_cookie[$param];
		}
		return $this->_tpl->params->get($param, $default);
	}

	function setParam ($param, $value) {
		$this->_params_cookie[$param] = $value;
	}

	/**
	 * Get Current URL
	 *
	 * @return URL string
	 */
	function getCurrentURL(){
		$cururl = JRequest::getURI();
		if(($pos = strpos($cururl, "index.php"))!== false){
			$cururl = substr($cururl,$pos);
		}
		$cururl =  JRoute::_($cururl, true, 0);
		return $cururl;
	}

	function calSpotlight ($spotlight, $totalwidth=100, $unit, $firstwidth=0) {

		/********************************************
		$spotlight = array ('position1', 'position2',...)
		*********************************************/
		$modules = array();
		$modules_s = array();
		foreach ($spotlight as $position) {
			if( $this->_tpl->countModules ($position) ){
				$modules_s[] = $position;
			}
			$modules[$position] = array('class'=>'-full', 'width'=>$totalwidth);
		}

		if (!count($modules_s)) return null;

		if ($firstwidth) {
			if (count($modules_s)>1) {
				$width = round(($totalwidth-$firstwidth)/(count($modules_s)-1),1) . $unit;
				$firstwidth = $firstwidth . $unit;
			}else{
				$firstwidth = $totalwidth . $unit;
			}
		}else{
			$width = round($totalwidth/(count($modules_s)),1) . $unit;
			$firstwidth = $width;
		}

		if (count ($modules_s) > 1){
			$modules[$modules_s[0]]['class'] = "-left";
			$modules[$modules_s[0]]['width'] = $firstwidth;
			$modules[$modules_s[count ($modules_s) - 1]]['class'] = "-right";
			$modules[$modules_s[count ($modules_s) - 1]]['width'] = $width;
			for ($i=1; $i<count ($modules_s) - 1; $i++){
				$modules[$modules_s[$i]]['class'] = "-center";
				$modules[$modules_s[$i]]['width'] = $width;
			}
		}
		return $modules;
	}
	function countSpotlight($spotlight) {
		/********************************************
		$spotlight = array ('position1', 'position2',...)
		*********************************************/
		$count = 0;
		foreach ($spotlight as $position) {
			if( $this->_tpl->countModules ($position) ){
				$count++;
			}
		}
		return $count;
	}
	/**
	 * @return boolean
	 */
	function isIE6 () {
		return $this->browser() == 'IE6';
	}

	/** URL of the site 
	 * @return URL string 
	 */	
	function baseurl(){
		 return JURI::base();
	}

	/**
	* URL of the template
	* @return URL string
	*/
	function templateurl() {
		return JURI::base()."templates/".$this->template.'/';
	}

	/** @return Sitename sting
	*/
	function sitename() {
		$config = new JConfig();
		return $config->sitename;
	}

	/*
	 * @return boolean
	 */
	function isOP () {
		return isset($_SERVER['HTTP_USER_AGENT']) &&
			preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT']);
	}

	/**
	 * @return boolean
	 */
	function isHomePage(){
		  $db  = & JFactory::getDBO();  
		  $db->setQuery("SELECT home FROM #__menu WHERE id=" . JRequest::getCmd( 'Itemid' ));
		  $db->query();
		  return  $db->loadResult();
	 }

	/*
	 * @return browser string
	 */
	function browser () {
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if ( strpos($agent, 'Gecko') )
		{
		   if ( strpos($agent, 'Netscape') )
		   {
		     $browser = 'NS';
		   }
		   else if ( strpos($agent, 'Firefox') )
		   {
		     $browser = 'FF';
		   }
		   else
		   {
		     $browser = 'Moz';
		   }
		}
		else if ( strpos($agent, 'MSIE') && !preg_match('/opera/i',$agent) )
		{
			 $msie='/msie\s(7\.[0-9]).*(win)/i';
		   	 if (preg_match($msie,$agent)) $browser = 'IE7';
		   	 else $browser = 'IE6';
		}
		else if ( preg_match('/opera/i',$agent) )
		{
		     $browser = 'OPE';
		}
		else
		{
		   $browser = 'Others';
		}
		return $browser;
	}

	function set_cookie($name, $value = "") {
		$expires = time() + 60*60*24*365;
		setcookie($name, $value, $expires,"/","");
	}

	function get_cookie($item) {
		if (isset($_COOKIE[$item]))
			return urldecode($_COOKIE[$item]);
		else
			return false;
	}

	function parse_ztcolor_cookie($stylecookie) {
		$_tpl_cookie =  $this->get_cookie($stylecookie);
		$_tpl_cookie = str_replace("\\","",$_tpl_cookie);
		if($_tpl_cookie) {
			$result =  substr($_tpl_cookie,strrpos($_tpl_cookie, '":"')+3,strlen($_tpl_cookie));
			$result =  substr($result, 0, strlen($result)-2);
		}
		elseif($_tpl_cookie == false) {
			$result = $this->templateurl() . '/css/colors/' . $this->getParam('zt_color') . '.css';
		}
		return stripslashes($result);
	}
}
?>