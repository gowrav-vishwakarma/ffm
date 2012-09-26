<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

@session_start();
define('ELPATH', JPATH_COMPONENT);

//check language
//first check global joomfish
$check = false;
if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
if(isset($_COOKIE['jfcookie']['lang'])) $check = $_COOKIE['jfcookie']['lang'];
if(isset($_REQUEST['lang'])) $check = JRequest::getWord('lang',false);
if($check){
	if(file_exists(ELPATH.'/languages/'.$check.'.php')){
		require_once(ELPATH.'/languages/'.$check.'.php');
	}else{
		require_once(ELPATH.'/languages/en.php');
	}
}else{
	require_once(ELPATH.'/languages/en.php');
}

require_once( $mainframe->getPath( 'class' ) );
require_once( $mainframe->getPath( 'front_html' ) );

$limitstart 	= intval( JRequest::getVar( 'limitstart', 0 ) );
$pop 			= intval( JRequest::getVar( 'pop', 0 ) );
$func 			= JRequest::getVar( 'func' );
$did			= JRequest::getVar('did','');
$processform	= JRequest::getVar( 'form', array(), 'POST');
if(!empty($processform)){
	foreach($processform as $key=>$value){
		$processform[$key] = RemoveXSS($processform[$key]);
	}
}
$GLOBALS['formeConfig'] = buildFormeConfig();
$database =& JFactory::getDBO();

//get fid
 $fid = JRequest::getVar( 'fid', '', 'GET', 'string', '' );
if ( !$fid ) {
	$params = clone($mainframe->getParams('com_forme'));
	$fid = $params->get('fid');
}

switch ($func)
{
	case 'thankyou':
		thankyou($did);
	break;
	
	case 'captcha':
		genCaptcha();
	break;

	default:
		showForm($fid);
	break;
}

function genCaptcha(){
	//Create a CAPTCHA
	$captcha = new captcha();
	$_SESSION['CAPTCHA'] = $captcha->getCaptcha();
	exit();
}


function populateGlobal($fields){
	$fields[]->name = 'jos_sitename';
	$fields[]->name = 'jos_siteurl';
	$fields[]->name = 'jos_userip';
	$fields[]->name = 'jos_user_id';
	$fields[]->name = 'jos_username';
	$fields[]->name = 'jos_email';
	$fields[]->name = 'jos_date_added';

	return $fields;
}

function prepareParams($did)
{
	$CONFIG  = new JConfig();
	$my		 = & JFactory::getUser();
	$database =& JFactory::getDBO();

	$database->setQuery("SELECT * FROM #__forme_data WHERE id = '".$database->getEscaped($did)."'");
	$data_row = $database->loadObject();
	$params = $data_row->params;

	$database->setQuery("SELECT * FROM #__users WHERE id = '$data_row->uid'");
	$user = $database->loadObject();

	$result['jos_sitename'] = $CONFIG->sitename;
	$result['jos_siteurl'] = JURI :: base();
	$result['jos_userip'] = $data_row->uip;
	$result['jos_user_id'] = $data_row->uid;
	$result['jos_date_added'] = $data_row->date_added;
	$result['jos_username'] = (isset($user->username)) ? $user->username:'';
	$result['jos_email'] = (isset($user->email)) ? $user->email:'';

	$result_explode = explode("||\n",$params);
	foreach($result_explode as $param_row){
		$param_row = explode('=',$param_row,2);
		if(isset($param_row[1])){
			$result[$param_row[0]] = $param_row[1];
		}else{
			$result[$param_row[0]] = '';
		}
	}
	return $result;
}

function thankyou($did)
{
	global $mainframe, $limitstart, $Itemid;

	$my 	  = & JFactory::getUser();
	$CONFIG   = new JConfig();
	$database =& JFactory::getDBO();

	//get the submission & form id
	$database->setQuery("SELECT * FROM #__forme_data WHERE MD5(CONCAT(id,date_added)) = '".$database->getEscaped($did)."'");
	$formdata = $database->loadObject();

	if(isset($formdata->form_id)){
		//check if form has a thank you message
		$database->setQuery("SELECT * FROM #__forme_forms WHERE id = '$formdata->form_id'");
		$form = $database->loadObject();
		
		$params = prepareParams($formdata->id);

		//load fields
		$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '$formdata->form_id' AND published = 1");
		$fields = $database->loadObjectList();

		$fields = populateGlobal($fields);

		$replace = array();
		$with = array();
		
		foreach($fields as $field){
			if(!isset($params[$field->name]))
				$params[$field->name] = '';
			
			$replace[] = '{'.$field->name.'}';
			$with[] = $params[$field->name];
		}
		
		$form->thankyou = str_replace($replace,$with,$form->thankyou);
		$form->return_url = str_replace($replace,$with,$form->return_url);

		$form->thankyou = base64_encode($form->thankyou);
		if($form->thankyou!='') {
			$form->thankyou = base64_decode($form->thankyou);
			forme_HTML::thankyou($form, $Itemid, $did, $formdata->form_id);
		}else{
			//if there is a return url
			if($form->return_url!=''){
				$mainframe->redirect($form->return_url, _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}else{
				$mainframe->redirect(JRoute::_("index.php?option=com_forme&Itemid=$Itemid", false), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}
		}
	}else{
		$mainframe->redirect(JRoute::_("index.php?option=com_forme&Itemid=$Itemid", false), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
	}
}

function processForm($fid, $processform){
	global $Itemid, $mainframe;

	$my = & JFactory::getUser();
	$CONFIG = new JConfig();
	$database =& JFactory::getDBO();

	$row = new forme_data($database);
	$row->form_id = $fid;
	$data_id = 0;

	$form = new forme_forms($database);
	$form->load($fid);

	eval($form->script_process);

	if(!empty($processform)){
		$errors = false;
		$form_data = $processform;

		$row->uip = $_SERVER['REMOTE_ADDR'];
		$row->date_added = date('Y-m-d H:i:s');
		$_SESSION['formmsg'] = array();

		//check captcha if any
		$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '".(int) $fid."' AND published = 1");
		$fields = $database->loadObjectList();


		//load input data
		foreach($fields as $field){
			if(isset($form_data[$field->name])){
				$_SESSION['formdata'][$field->name] = $form_data[$field->name];
			}else{
				$_SESSION['formdata'][$field->name] = array();
			}
		}

		foreach($fields as $i=>$field){
			//check captcha
			if($field->inputtype == 'captcha'){
				//check session
				if(isset($_SESSION['CAPTCHA'])){
					if(isset($form_data[$field->name])){
						if(strtoupper($form_data[$field->name])!=$_SESSION['CAPTCHA']){
							$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ? _FORME_FRONTEND_REGISTRA_CAPTCHA : $field->validation_message;
						}
					}
					else
						$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ? _FORME_FRONTEND_REGISTRA_CAPTCHA : $field->validation_message;
				}else{
					$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ? _FORME_FRONTEND_REGISTRA_CAPTCHA : $field->validation_message;
				}
			}


			//check mandatory
			if($field->validation_rule == 'mandatory'){
				if($field->inputtype!='file upload'){
					if(isset($form_data[$field->name])){
						if(is_array($form_data[$field->name])){
							if(empty($form_data[$field->name])||(count($form_data[$field->name])==1&&$form_data[$field->name][0]=='')) $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
						}else{
							if($form_data[$field->name]=='')  $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
						}
					}else{
						$_SESSION['formmsg'][$field->name][] =  $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
					}
				}else{
					$field_exists = false;
					foreach($_FILES['form']['name'] as $field_name=>$field_value){
						if($field_name==$field->name){
							if($_FILES['form']['tmp_name'][$field_name]!='')	$field_exists = true;
						}
					}
					if(!$field_exists){
						$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_FILE_CANNOT_EMPTY) : $field->validation_message;
					}
				}

			}

			//check alphanum
			if($field->validation_rule == 'alphanum'){				
				if(preg_match('#[^a-zA-Z0-9 ]#i', $form_data[$field->name] )|| $form_data[$field->name] == ''){
					$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_ALPHANUMERIC,$field->title) : $field->validation_message;
				}
			}

			//check alpha
			if($field->validation_rule == 'alpha'){
				if(preg_match('#[^a-zA-Z ]#i', $form_data[$field->name] )|| $form_data[$field->name] == ''){
					$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_ALPHA,$field->title) : $field->validation_message;
				}
			}

			//check email
			if($field->validation_rule == 'email'){
				jimport('joomla.mail.helper');
				if(!JMailHelper::isEmailAddress($form_data[$field->name]) || $form_data[$field->name] == ''){
					$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  _FORME_FRONTEND_REGISTRA_EMAIL : $field->validation_message;
				}
			}

			//check number
			if($field->validation_rule == 'number'){
				if(!is_numeric($form_data[$field->name] )|| $form_data[$field->name] == ''){
					$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_NUMERIC,$field->title) : $field->validation_message;
				}
			}

			//check file type compatibility
			if($field->inputtype== 'file upload'){
				foreach($_FILES['form']['name'] as $field_name=>$field_value){
					if($field_name == $field->name){
						$field_rules = explode(',',$field->default_value);
						if( $field_rules[0] != '' || $field->default_value!=''){
							$type_match = false;
							foreach($field_rules as $rule){
								//check for size
								$size = explode('/',$rule);
								if($size[0]=='size'){
									if(!isset($size[1])) $size[1] = 0;
									if($size[1]){
										if($_FILES['form']['size'][$field->name] > (int)$size[1]*1024){
											$_SESSION['formmsg'][$field->name][] = sprintf(_FORME_FRONTEND_REGISTRA_SIZE,$size[1]);
										}
									}
								}

								//check for file type
								if($rule==$_FILES['form']['type'][$field->name]){
									$type_match = true;
								}
							}
							if($_FILES['form']['type'][$field->name]=='') $type_match = true;
							if(!$type_match){
								$_SESSION['formmsg'][$field->name][] = _FORME_FRONTEND_REGISTRA_NOT_ALLOWED;
							}
						}
					}
				}
			}

		}
		if(!empty($_SESSION['formmsg'])){
			$mainframe->redirect($_SERVER['REQUEST_URI']);
		}


		//build params
		$params_field = '';
		foreach($form_data as $key=>$value){
			if(is_array($value)) $value = implode(',',$value);
			$params_field .= $key.'='.$value."||\n";
		}

		//files
		foreach($fields as $field){
			if($field->inputtype=='file upload'){

					$target_file = time().'_'.str_replace('..', '', $_FILES['form']['name'][$field->name]);

					if(!move_uploaded_file($_FILES['form']['tmp_name'][$field->name],JPATH_SITE.'/components/com_forme/uploads/'.$target_file)){

					}else{
						@chmod(JPATH_SITE.'/components/com_forme/uploads/'.$target_file,0755);
						$params_field .= $field->name . '=' . $target_file ."||\n";
					}
			}
		}

		// bind it to the table
		if (!$row -> bind($form_data)) {
			echo "<script> alert('"
			.$row -> getError()
				."'); window.history.go(-1); </script>\n";
			exit();
		}else{
			$row->params = $params_field;
		}
		if($my->id) $row->uid = $my->id;

		// store it in the db
		if (!$row -> store()) {
			echo "<script> alert('"
				.$row -> getError()
				."'); window.history.go(-1); </script>\n";
			exit();
		}else{
			$data_id = $row->id;
			if($form->emailto!=''&&$form->email!=''){
				$emailto = explode(',',str_replace(' ','',$form->emailto));

				$fields = populateGlobal($fields);

				$params = prepareParams($data_id);
				foreach($fields as $field){
					if(!isset($params[$field->name])) $params[$field->name] = '';
					$form->email = str_replace('{'.$field->name.'}',$params[$field->name],$form->email);
					$form->emailsubject = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailsubject);
					$form->emailfrom = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailfrom);
					$form->emailfromname = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailfromname);
					foreach($emailto as $i=>$to){
						$emailto[$i] = str_replace('{'.$field->name.'}',$params[$field->name],$emailto[$i]);
					}
				}

				jimport('joomla.mail.helper');	
				
				if($form->emailfrom=='' || !JMailHelper::isEmailAddress($form->emailfrom))$form->emailfrom = $CONFIG->mailfrom;
				if($form->emailfromname=='')$form->emailfromname = $CONFIG->sitename;
				
				foreach($emailto as $to){
					if (!JMailHelper::isEmailAddress($to)) continue;
					JUtility::sendMail($form->emailfrom,$form->emailfromname,$to,$form->emailsubject,$form->email,$form->emailmode);
				}
			}
		}
		//check if there is a thank you message
		if(strlen($form->thankyou)!=0){
			if(isset($_SESSION['formdata'])){
				unset($_SESSION['formdata']);
			}
			$mainframe->redirect(JRoute::_("index.php?option=com_forme&Itemid=$Itemid&func=thankyou&did=" . md5( $data_id.$row->date_added), false));
		}else {
			if(isset($_SESSION['formdata'])){
				unset($_SESSION['formdata']);
			}
			//if there is a return url
			if($form->return_url!=''){

				$params = prepareParams($data_id);
				$fields = populateGlobal($fields);
				foreach($fields as $field){
					if(!isset($params[$field->name])) $params[$field->name] = '';
					$form->return_url = str_replace('{'.$field->name.'}',$params[$field->name],$form->return_url);
				}
				$mainframe->redirect($form->return_url, _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}else{
				if(isset($_SESSION['formdata'])){
					unset($_SESSION['formdata']);
				}
				$mainframe->redirect(JRoute::_("index.php?option=com_forme&Itemid=$Itemid&fid=$fid", false), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}
		}
	}

}

function showForm($fid){
	global $mainframe, $limitstart, $acl, $formeConfig;
	$my  		 =& JFactory::getUser();
	$fid 		 = (int) $fid;
	$processform = JRequest::getVar( 'form', array(), 'POST');
	$database 	 =& JFactory::getDBO();

	//get first cid
	if(!$fid)
	{
		$database->setQuery("SELECT id FROM #__forme_forms WHERE published = 1 LIMIT 1");
		$fid = (int) $database->loadResult();
	}

	//check language
	//first check global joomfish
	$check = false;
	if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
	if(isset($_COOKIE['jfcookie']['lang'])) $check = $_COOKIE['jfcookie']['lang'];
	if(isset($_REQUEST['lang'])) $check = JRequest::getWord('lang',false);
	if($check)
	{
		$oldform = new forme_forms($database);
		$oldform->load($fid);

		//check if we find something similar
		$database->setQuery("SELECT id FROM #__forme_forms WHERE lang='".$database->getEscaped($check)."' AND name='".$database->getEscaped($oldform->name)."' AND published = 1");
		$newfid = $database->loadResult();
		if ($newfid) $fid = $newfid;
	}

	processForm($fid, $processform);

	$database->setQuery("SELECT * FROM #__forme_forms WHERE id = '{$fid}' AND published = '1'");
	$form = $database->loadObject();

	if(empty($form->published))
		$mainframe->redirect(JURI :: base(),JText::_('_NOT_EXIST'));
	
	//load fields
	$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '{$fid}' AND published = '1' ORDER BY ordering");
	$fields = $database->loadObjectList();

	//Output
	forme_HTML::showForm($form, $fields);
}
function RemoveXSS($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
	  // ;? matches the ;, which is optional
	  // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

	  // &#x0040 @ search for the hex values
	  $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
	  // &#00064 @ 0{0,7} matches '0' zero to seven times
	  $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
	  $val_before = $val;
	  for ($i = 0; $i < sizeof($ra); $i++) {
		 $pattern = '/';
		 for ($j = 0; $j < strlen($ra[$i]); $j++) {
			if ($j > 0) {
			   $pattern .= '(';
			   $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
			   $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
			   $pattern .= ')?';
			}
			$pattern .= $ra[$i][$j];
		 }
		 $pattern .= '/i';
		 $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
		 $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
		 if ($val_before == $val) {
			// no replacements were made, so exit the loop
			$found = false;
		 }
	  }
   }
   return $val;
}

/**
 * Builds configuration variable
 *
 * @return formeConfig
 */
function buildFormeConfig(){
	$database =& JFactory::getDBO();

	$formeConfig = array();
	$database->setQuery("SELECT setting_name, setting_value FROM #__forme_config");
	$formeConfigObj = $database->loadObjectList();

	foreach ($formeConfigObj as $formeConfigRow){
		$formeConfig[$formeConfigRow->setting_name] = $formeConfigRow->setting_value;
	}
	return $formeConfig;
}

class captcha{

var $Length;
var $CaptchaString;
var $fontpath;
var $fonts;


function captcha ($length = 4){
global $mainframe;
if(!function_exists('imagecreate')) header('Location:uploads/nogd.gif');//die('GD Library not found!');

header('Content-type: image/png');

	//$mainframe->registerEvent( 'onAfterInitialise', 'pngHeader' );

  $this->Length   = $length;

  //$this->fontpath = dirname($_SERVER['SCRIPT_FILENAME']) . '/fonts/';
  $this->fontpath = JPATH_SITE.DS.'components'.DS.'com_forme'.DS.'fonts'.DS;
  //echo $this->fontpath;die();
  $this->fonts    = $this->getFonts();
  $errormgr       = new error;

  if ($this->fonts == FALSE)
  {

	  //$errormgr = new error;
	  $errormgr->addError('No fonts available!');
	  $errormgr->displayError();
	  die();

  }

  if (function_exists('imagettftext') == FALSE)
  {

	$errormgr->addError('Function imagettftext does not exist');
	$errormgr->displayError();
	die();

  }

  $this->stringGenerate();

  $this->makeCaptcha();

} //captcha

function getFonts (){
  $fonts = array();
  if ($handle = @opendir($this->fontpath)){
	while (($file = readdir($handle)) !== FALSE){
	  $extension = strtolower(substr($file, strlen($file) - 3, 3));
	  if ($extension == 'ttf'){
		$fonts[] = $file;
	  }
	}
	closedir($handle);
  }else{
	  return FALSE;
  }

  if (count($fonts) == 0){
	  return FALSE;
  }else{
	  return $fonts;
  }
}
function getRandomFont (){
  return $this->fontpath . $this->fonts[mt_rand(0, count($this->fonts) - 1)];
}
function stringGenerate(){
  $uppercase  = range('A', 'Z');

  $CharPool   = range('A', 'Z');
  $PoolLength = count($CharPool) - 1;

  for ($i = 0; $i < $this->Length; $i++){
	$this->CaptchaString .= $CharPool[mt_rand(0, $PoolLength)];
  }
} //stringGenerate

function makeCaptcha (){
  $imagelength = $this->Length * 15 + 16;
  $imageheight = 40;
	$image       = imagecreate($imagelength, $imageheight);


  $bgcolor     = imagecolorallocate($image, 255, 255, 255);

  $stringcolor = imagecolorallocate($image, 0, 0, 0);

  $filter      = new filters;

  $filter->signs($image, $this->getRandomFont(),1);

  for ($i = 0; $i < strlen($this->CaptchaString); $i++){
	imagettftext($image,15, mt_rand(-15, 15), $i * 15 + 10,
				 mt_rand(20, 30),
				 $stringcolor,
				 $this->getRandomFont(),
				 $this->CaptchaString{$i});
  }

  $filter->noise($image, 2);
  //$filter->blur($image, 0);

  imagepng($image);

  imagedestroy($image);

} //MakeCaptcha

function getCaptcha ()
{

  return $this->CaptchaString;

} //getCaptcha

} //class: captcha



class error
{

  var $errors;

  function error ()
  {

	$this->errors = array();

  } //error

  function addError ($errormsg)
  {

	$this->errors[] = $errormsg;

  } //addError

  function displayError ()
  {

  $iheight     = count($this->errors) * 20 + 10;
  $iheight     = ($iheight < 130) ? 130 : $iheight;

  $image       = imagecreate(600, $iheight);

  //$errorsign   = imagecreatefromgif('images/error.gif');
  //imagecopy($image, $errorsign, 1, 1, 1, 1, 180, 120);

  $bgcolor     = imagecolorallocate($image, 255, 255, 255);

  $stringcolor = imagecolorallocate($image, 0, 0, 0);

  for ($i = 0; $i < count($this->errors); $i++)
  {

	$imx = ($i == 0) ? $i * 20 + 5 : $i * 20;


	$msg = 'Error[' . $i . ']: ' . $this->errors[$i];

	imagestring($image, 5, 190, $imx, $msg, $stringcolor);

	}

  imagepng($image);

  imagedestroy($image);

  } //displayError

  function isError ()
  {

	if (count($this->errors) == 0)
	{

		return FALSE;

	}
	else
	{

		return TRUE;

	}

  } //isError

} //class: error



class filters
{

function noise (&$image, $runs = 30){

  $w = imagesx($image);
  $h = imagesy($image);

  for ($n = 0; $n < $runs; $n++)
  {

	for ($i = 1; $i <= $h; $i++)
	{

	  $randcolor = imagecolorallocate($image,
									  mt_rand(0, 255),
									  mt_rand(0, 255),
									  mt_rand(0, 255));

	  imagesetpixel($image,
					mt_rand(1, $w),
					mt_rand(1, $h),
					$randcolor);

	}

  }

} //noise

function signs (&$image, $font, $cells = 3){

  $w = imagesx($image);
  $h = imagesy($image);

	 for ($i = 0; $i < $cells; $i++)
	 {

		 $centerX     = mt_rand(5, $w);
		 $centerY     = mt_rand(1, $h);
		 $amount      = mt_rand(5, 10);
	$stringcolor = imagecolorallocate($image, 150, 150, 150);

		 for ($n = 0; $n < $amount; $n++)
		 {

	  $signs = range('A', 'Z');
	  $sign  = $signs[mt_rand(0, count($signs) - 1)];

		   imagettftext($image, 15,
						mt_rand(-15, 15),
						$n * 15,//mt_rand(0, 15),
						30 + mt_rand(-5, 5),
						$stringcolor, $font, $sign);

		 }

	 }

} //signs


} //class: filters
?>