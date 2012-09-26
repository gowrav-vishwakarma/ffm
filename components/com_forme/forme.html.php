<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class forme_HTML
{	
	function thankyou($form, $Itemid, $did, $fid)
	{
		$fid = (int) $fid;
		$return_url = ($form->return_url == '') ? JRoute::_("index.php?option=com_forme&Itemid=$Itemid&fid=$fid", false) : $form->return_url;

		echo '<div class="thankyou">'.stripslashes($form->thankyou).'</div>';
		echo '<input type="button" name="ok" value="'._FORME_FRONTEND_THANKYOU_BUTTON.'" onclick="document.location=\''.$return_url.'\'"/>';
	}

	function showForm(&$form, &$fields)
	{
		global  $Itemid, $mainframe, $params, $hide_js, $pop, $formeConfig;
		$database =& JFactory::getDBO();

		//Page title
		$mainframe->setPageTitle( $form->title );
    	$mainframe->addMetaTag( 'title' , $form->title );

    	eval($form->script_display);

    	//if we have upload file fields, add enctype
    	$enctype='';
	    foreach($fields as $field){
	    	if($field->inputtype=='file upload') $enctype = ' enctype="multipart/form-data"';
	    }

		//load calendar if calendar field exists
		$calexists = false;
		foreach($fields as $field){
			if($field->inputtype=='calendar') $calexists = true;
		}


		//parse field template
		$formfields = '';
		foreach($fields as $field){
			if($form->fieldstyle=='') $form->fieldstyle = _FORME_BACKEND_EDITFORMS_FIELDSTYLE_DEFAULT;
			if($field->fieldstyle=='') $field->fieldstyle = $form->fieldstyle;
			$formfields .= forme_HTML::parseFields($field);
		}

		if($calexists){
			$html = '';
			$check = false;
			if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
			if(isset($_COOKIE['jfcookie']['lang'])) $check = $_COOKIE['jfcookie']['lang'];
			if(isset($_REQUEST['lang'])) $check = JRequest::getWord('lang',false);
			if($check){
				if(file_exists(JPATH_SITE.'/components/com_forme/calendar/initcal-'.$check.'.php'))
				require_once(JPATH_SITE.'/components/com_forme/calendar/initcal-'.$check.'.php');
				else require_once(JPATH_SITE.'/components/com_forme/calendar/initcal.php');
			}
			else require_once(JPATH_SITE.'/components/com_forme/calendar/initcal.php');

			echo $html;
			?>
				<script language="javascript">
					function init() {
						<?php
						foreach($fields as $field){
							if($field->inputtype=='calendar'){
						?>
							function handleSelect<?php echo $field->name;?>(type,args,obj) {
								var dates = args[0];
								var date = dates[0];
								var year = date[0], month = date[1], day = date[2];
								var txtDate = document.getElementById("txt<?php echo $field->name;?>");
								txtDate.value = month + "/" + day + "/" + year;
							}


							YAHOO.example.calendar.<?php echo $field->name;?> = new YAHOO.widget.Calendar("<?php echo $field->name;?>","<?php echo $field->name;?>Container");
							YAHOO.example.calendar.<?php echo $field->name;?>.selectEvent.subscribe(handleSelect<?php echo $field->name;?>, YAHOO.example.calendar.<?php echo $field->name;?>, true);


							var txt<?php echo $field->name;?> = document.getElementById("txt<?php echo $field->name;?>");

							if (txt<?php echo $field->name;?>.value != "") {
								YAHOO.example.calendar.<?php echo $field->name;?>.select(txt<?php echo $field->name;?>.value);
							}

					    	YAHOO.example.calendar.<?php echo $field->name;?>.render();
					    <?php
							}
						}
					    ?>
					}

					YAHOO.util.Event.addListener(window, "load", init);
				</script>
			<?php

		}


		$action = JRoute::_('index.php?option=com_forme&fid='.$form->id.'&Itemid='.$Itemid);

		//parse form template
		if($form->formstyle == '') $form->formstyle = _FORME_BACKEND_EDITFORMS_STYLE_DEFAULT;
		$form->formstyle = str_replace('{formtitle}',$form->title,$form->formstyle);
		$form->formstyle = str_replace('{formname}',$form->name,$form->formstyle);
		$form->formstyle = str_replace('{enctype}',$enctype,$form->formstyle);
		$form->formstyle = str_replace('{action}',$action,$form->formstyle);

		$form->formstyle = str_replace('{formfields}',$formfields,$form->formstyle);

		echo $form->formstyle;
	}

	function parseErrorMsg($fieldid){
		$error = '';
		if(isset($_SESSION['formmsg'][$fieldid])){
			if(!empty($_SESSION['formmsg'][$fieldid])){
				foreach($_SESSION['formmsg'][$fieldid] as $i=>$errmsg){
					$_SESSION['formmsg'][$fieldid][$errmsg] = $errmsg;
					unset($_SESSION['formmsg'][$fieldid][$i]);
				}
				foreach($_SESSION['formmsg'][$fieldid] as $errmsg){
					$error .= '<br/><span style="color: #CF4D4D;font-weight:bold;font-size:10px;">'.$errmsg.'</span>';
				}
				unset($_SESSION['formmsg'][$fieldid]);
			}
		}
		return $error;
	}

	function parseFields($row){

		$html = '';
		if(!isset($_SESSION['formdata'])) $_SESSION['formdata'] = array();
		switch($row->inputtype){
			case 'text':
				if(isset($_SESSION['formdata'][$row->name])){
					$row->default_value = stripslashes($_SESSION['formdata'][$row->name]);

				}

				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="text" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="button" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'reset button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="reset" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'submit button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="submit" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'image button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="image" name="form['.$row->name.']" src="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'hidden':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="hidden" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'file upload':
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="file" name="form['.$row->name.']" value="" id="'.$row->name.'" '.$row->params.' />'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'password':
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="password" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' />'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'radio':

				$errmsg = forme_HTML::parseErrorMsg($row->name);
				if(isset($_SESSION['formdata'][$row->name])) $row->default_value = str_replace('{checked}','',$row->default_value);

				$row->default_value = explode(',',$row->default_value);
				$radios = '';
				foreach ($row->default_value as $i=>$radioset){
					$valTitle = explode('|',$radioset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];
					if(isset($_SESSION['formdata'][$row->name])){
						if($_SESSION['formdata'][$row->name]==$valTitle[0]){
							$valTitle[0] = $valTitle[0].'" checked="checked';
						}
					}else{
						$valTitle[0] = str_replace('{checked}','" checked="checked',$valTitle[0]);
					}

					$radios .= '<span class="radio'.$row->name.'" style="white-space: nowrap"><input type="radio" name="form['.$row->name.']" id="'. $row->name .$i. '" value="'.$valTitle[0].'" '.$row->params.' /><label for="'. $row->name .$i. '">'. $valTitle[1].'</label></span>';
				}
				$html = str_replace('{fieldtitle}', $row->title, $row->fieldstyle);
				$html = str_replace('{validationsign}', ($row->validation_rule) ? ' *':'', $html);
				$html = str_replace('{field}', $radios.$errmsg, $html);
				$html = str_replace('{fielddesc}', $row->description, $html);
			break;
			case 'checkbox':
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				if(isset($_SESSION['formdata'][$row->name])) $row->default_value = str_replace('{checked}','',$row->default_value);

				$row->default_value = explode(',',$row->default_value);
				$checks = '';
				foreach ($row->default_value as $i=>$checkset){
					$valTitle = explode('|',$checkset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];
					if(isset($_SESSION['formdata'][$row->name])){
						foreach($_SESSION['formdata'][$row->name] as $val){
							if($val==$valTitle[0]){
								$valTitle[0] = $valTitle[0].'" checked="checked';
							}
						}
					}else{
						$valTitle[0] = str_replace('{checked}','" checked="checked',$valTitle[0]);
					}
					$checks .= '<span class="check'.$row->name.'" style="white-space: nowrap"><input type="checkbox" name="form['.$row->name.'][]" id="'. $row->name .$i. '" value="'.$valTitle[0].'" '.$row->params.' /><label for="'. $row->name .$i. '">'. $valTitle[1].'</label></span>';
				}
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}', $checks.$errmsg, $html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'textarea':
				if(isset($_SESSION['formdata'][$row->name])){
					$row->default_value = stripslashes($_SESSION['formdata'][$row->name]);

				}
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<textarea name="form['.$row->name.']" id="'.$row->name.'" '.$row->params.'>'.$row->default_value.'</textarea>'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'select':
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				if(isset($_SESSION['formdata'][$row->name])) $row->default_value = str_replace('{checked}','',$row->default_value);

				$options = '';
				$row->default_value = explode(',',$row->default_value);
				foreach ($row->default_value as $optionset){
					$valTitle = explode('|',$optionset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];

					if(isset($_SESSION['formdata'][$row->name])){
						foreach($_SESSION['formdata'][$row->name] as $val){
							if($val==$valTitle[0]){
								$valTitle[0] = $valTitle[0].'" selected="selected';
							}
						}
					}else{
						$valTitle[0] = str_replace('{checked}','" selected="selected',$valTitle[0]);
					}


					$options .= '<option value="'.$valTitle[0].'">'.$valTitle[1].'</option>';
				}
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<select name="form['.$row->name.'][]" '.$row->params.' id="'.$row->name.'" >'.$options.'</select>'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;

			case 'calendar':

				if(isset($_SESSION['formdata'][$row->name])){
					$default_value = $_SESSION['formdata'][$row->name];
				}else{
					$default_value = '';
				}
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);

				$html = str_replace('{field}','<div id="'.$row->name.'Container"></div><input id="txt'.$row->name.'" name="form['.$row->name.']" value="'.$default_value.'" type="hidden"/>'.$errmsg,$html);


				$html = str_replace('{fielddesc}',$row->description,$html);
			break;

			case 'free text':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}','',$html);
				$html = str_replace('{field}',$row->default_value,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;

			case 'ticket number':
				$length = (int)$row->default_value;
				if($length<1||$length>255) $length = 8;
				  $key = "";
				  $possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				  $i = 0;
				  while ($i < $length) {
				    $key .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				    $i++;
				  }

				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}','',$html);
				$html = str_replace('{field}','<input id="'.$row->name.'" name="form['.$row->name.']"  value="'.$key.'" type="hidden"/>',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'captcha':
				$errmsg = forme_HTML::parseErrorMsg($row->name);
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<img src="'.JURI :: base().'index.php?option=com_forme&func=captcha"/><br/><input type="text" name="form['.$row->name.']" value="'.$row->default_value.'" id="'.$row->name.'" '.$row->params.' style="width:74px;text-align:center;" />'.$errmsg,$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
		}

		return $html;
	}


//end of class
}
?>