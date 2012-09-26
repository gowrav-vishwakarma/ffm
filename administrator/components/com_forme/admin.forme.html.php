<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/


defined('_JEXEC') or die('Restricted access');

$document =& JFactory::getDocument();
$document->addStyleSheet('components/com_forme/style.css');

//check language
//first check global joomfish
$check = 'en';
if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
if(isset($_REQUEST['lang'])) $check = JRequest::getVar('lang',false);
if($check){
	if(file_exists(JPATH_SITE.'/components/com_forme/languages/'.$check.'.php'))
		require_once(JPATH_SITE.'/components/com_forme/languages/'.$check.'.php');
	else
		require_once(JPATH_SITE.'/components/com_forme/languages/en.php');
}else{
	require_once(JPATH_SITE.'/components/com_forme/languages/en.php');
}


class forme_HTML
{

function genKeyCode(){
	$formeConfig = buildFormeConfig();

	return md5($formeConfig['global.register.code']._FORME_KEY);
}

function fieldsCopyScreen($fields, $forms){
?>
	<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<tr>
	  		<td><img src="<?php echo JURI :: base()."components/com_forme/images/rsform.gif"; ?>" height="70" width="250" alt="RSform! Logo" align="left"></td>
	  		<td class="sectionname" align="right"><font style="color: #C24733; font-size : 18px; font-weight: bold; text-align: left;"><?php echo  _FORME_BACKEND_FIELDSCOPY_HEAD;?></font></td>
		</tr>
		<tr>
			<td colspan="2">

				<?php
				$hiddens = '';
					foreach($fields as $field){
						$names[] = $field->name;
						$hiddens .= '<input type="hidden" name="cid[]" value="'.$field->id.'"/>';
					}
					printf(_FORME_BACKEND_FIELDSCOPY_TITLE,implode(', ',$names));
					echo $forms;
					echo $hiddens;
				?>
			</td>
	  </tr>
	</table>

	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="form_id" value="<?php echo $fields[0]->form_id;?>" />
	<input type="hidden" name="task" value="" />
	</form>
<?php
}

/**
*
*Show RSform! policy
*
**/
function showInformation()
{
	?>
	<form action="index.php" method="post" name="adminForm">
	<center>
  <table width="100%" border="0">
   <tr>
      <td>
        <strong>RSform!</strong><br/>
        Released under the terms and conditions of the License</a>.<br>
		<br/>
      </td>
    </tr>
    <tr>
      <td background="E0E0E0" style="border:1px solid #999;" colspan="2">
   		<font color="green"><b>Joomla! RSform! 1.0.6 Installed Successfully!</b></font><br />
		</code>
      </td>
    </tr>
  </table>
  <p style="text-align:left;">
  	<img src="components/com_forme/images/rsform.gif"/><br/><br/>
		<b>RSform! Component for Joomla!</b><br/>
&copy; 2007-2009 by <a href="http://www.rsjoomla.com" target="_blank">http://www.rsjoomla.com</a><br/>
All rights reserved.
<br/><br/>
This Joomla! Component has been released under a <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPL License</a>.<br/>
<em>Note:  This package works only on Joomla! 1.5</em>
<br/><br/>
<b>Load Sample Data</b><br/>
If you don't know how to start, be sure to check out the "Add Sample Data" menu option or <a href="index.php?option=com_forme&task=sample">click here</a>
<br/><br/>
Thank you for using RSform!!
<br/><br/>
The rsjoomla.com team.
<br/><br/>
<a href="index.php?option=com_forme"><big><strong>Continue</strong></big></a>
</p>
  </center>

	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="hidemainmenu" value="0">
</form>
	<?php
}

/**
*
*List the forms
*
**/
function listforms(&$rows, &$pageNav, &$search, &$filter)
{
	global $mainframe;
?>
<form action="index.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
	  		<td colspan="7"><img src="<?php echo JURI :: base()."components/com_forme/images/rsform.gif"; ?>" height="70" width="250" alt="RSform! Logo" align="left"></td>
	  		<td class="sectionname" align="right"><font style="color: #C24733; font-size : 18px; font-weight: bold; text-align: left;"><?php echo _FORME_BACKEND_FORMS_MANAGE_FORMS;?></font></td>
		</tr>
		<tr align="right">
			<td colspan="8">
				<?php echo _FORME_BACKEND_FORMS_SEARCH." ";?>
				<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
				<?php
				echo _FORME_BACKEND_FORMS_SEARCH_LIMIT." ";
				echo $pageNav->getLimitBox();
				?>
			</td>
	  </tr>
	  <tr>
		  <td colspan="8">&nbsp;</td>
	  </tr>
		<tr>
			<th width="5"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" /></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_TITLE." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_NAME." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_PUBLISHED." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_DATA." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_LINK." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_PREVIEW." "; ?></th>
			<th class="title"><?php echo _FORME_BACKEND_FORMS_ID." "; ?></th>
		</tr>
		<?php
		$k = 0;
		for($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$link 		= 'index.php?option=com_forme&task=editform&hidemainmenu=1&cid='.$row->id;
			?>
		<tr class="<?php echo "row$k"; ?>">
			<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
			<td><a href="<?php echo $link; ?>" title="Edit Form"><?php echo $row->title == '' ? '<em>no title</em>' : $row->title; ?></a></td>
			<td><?php echo $row->name; ?></td>
			<?php
			$task = $row->published ? 'unpublishform' : 'publishform';
			$img = $row->published ? 'publish_g.png' : 'publish_x.png';
			?>
			<td><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>
			<td><a href="<?php echo 'index.php?option=com_forme&task=listdata&cid='.$row->id;?>">
					<?php echo _FORME_BACKEND_FORMS_TODAY.$row->cnt_today.'<br/>'.
							   _FORME_BACKEND_FORMS_MONTH.$row->cnt_month.'<br/>'.
							   _FORME_BACKEND_FORMS_ALL.$row->cnt_all.'<br/>';?>
					</a></td>
			<td><a href="<?php echo $mainframe->getSiteURL();?>index.php?option=com_forme&amp;fid=<?php echo $row->id;?>" target="_blank">index.php?option=com_forme&amp;fid=<?php echo $row->id;?></a></td>
			<td><a href="<?php echo $mainframe->getSiteURL();?>index.php?option=com_forme&amp;fid=<?php echo $row->id;?>" target="_blank" style="text-decoration:none;font-size:14px;text-align:center;padding-top:4px;font-weight:bold;"><?php echo _FORME_BACKEND_FORMS_PREVIEW;?></a></td>
			<td><?php echo $row->id;?></td>
				<?php $k = 1 - $k;  } ?>
		</tr>
		<tr>
		  <td align="center" colspan="8"><?php echo $pageNav->getPagesLinks(); ?></td>
	  	</tr>
		<tr>
		  <td align="center" colspan="8"><?php echo $pageNav->getPagesCounter(); ?></td>
	  	</tr>
	</table>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="task" value="forms" />
	<input type="hidden" name="hidemainmenu" value="0">
</form>

<?php
}

//Parse field

	function parseFields($row){

		global $mainframe;
		$html = '';
		switch($row->inputtype){
			case 'text':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="text" value="'.$row->default_value.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="button" value="'.$row->default_value.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'submit button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="button" value="'.$row->default_value.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'reset button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="reset" value="'.$row->default_value.'"'.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'image button':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="image" src="'.$row->default_value.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'hidden':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'file upload':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="file" value="" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'password':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<input type="password" value="'.$row->default_value.'" '.$row->params.' />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'radio':
				$row->default_value = explode(',',$row->default_value);
				$radios = '';
				foreach ($row->default_value as $i=>$radioset){
					$valTitle = explode('|',$radioset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];
					$valTitle[0] = str_replace('{checked}','" checked="checked',$valTitle[0]);
					$radios .= '<span class="radio'.$row->name.'"><input type="radio" value="'.$valTitle[0].'" '.$row->params.' /><label for="'. $row->name .$i. '">'. $valTitle[1].'</label></span>';
				}
				$html = str_replace('{fieldtitle}', $row->title, $row->fieldstyle);
				$html = str_replace('{validationsign}', ($row->validation_rule) ? ' *':'', $html);
				$html = str_replace('{field}', $radios, $html);
				$html = str_replace('{fielddesc}', $row->description, $html);
			break;
			case 'checkbox':
				$row->default_value = explode(',',$row->default_value);
				$checks = '';
				foreach ($row->default_value as $i=>$checkset){
					$valTitle = explode('|',$checkset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];
					$valTitle[0] = str_replace('{checked}','" checked="checked',$valTitle[0]);
					$checks .= '<span class="check'.$row->name.'"><input type="checkbox" value="'.$valTitle[0].'" '.$row->params.' /><label for="'. $row->name .$i. '">'. $valTitle[1].'</label></span>';
				}
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}', $checks, $html);
				$html = str_replace('{fielddesc}','',$html);
			break;
			case 'textarea':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<textarea '.$row->params.'>'.$row->default_value.'</textarea>',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'select':
				$options = '';
				$row->default_value = explode(',',$row->default_value);
				foreach ($row->default_value as $optionset){
					$valTitle = explode('|',$optionset);
					if(!isset($valTitle[1])) $valTitle[1] = $valTitle[0];
					$options .= '<option value="'.$valTitle[0].'">'.$valTitle[1].'</option>';
				}
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<select '.$row->params.' >'.$options.'</select>',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;

			case 'calendar':
				$default_value = '';
				$check = false;
				if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
				if(isset($_REQUEST['lang'])) $check = JRequest::getVar('lang',false);
				if($check){
					if(file_exists(JPATH_SITE.'/components/com_forme/calendar/initcal-'.$check.'.php'))
					require_once(JPATH_SITE.'/components/com_forme/calendar/initcal-'.$check.'.php');
					else require_once(JPATH_SITE.'/components/com_forme/calendar/initcal.php');
				}
				else require_once(JPATH_SITE.'/components/com_forme/calendar/initcal.php');

				$html .='
					<script language="javascript">
						function init() {

								function handleSelect'.$row->name.'(type,args,obj) {
									var dates = args[0];
									var date = dates[0];
									var year = date[0], month = date[1], day = date[2];
									var txtDate = document.getElementById("txt'.$row->name.'");
									txtDate.value = month + "/" + day + "/" + year;
								}


								YAHOO.example.calendar.'.$row->name.' = new YAHOO.widget.Calendar("'.$row->name.'","'.$row->name.'Container");
								YAHOO.example.calendar.'.$row->name.'.selectEvent.subscribe(handleSelect'.$row->name.', YAHOO.example.calendar.'.$row->name.', true);


								var txt'.$row->name.' = document.getElementById("txt'.$row->name.'");

								if (txt'.$row->name.'.value != "") {
									YAHOO.example.calendar.'.$row->name.'.select(txt'.$row->name.'.value);
								}

						    	YAHOO.example.calendar.'.$row->name.'.render();
						}

						YAHOO.util.Event.addListener(window, "load", init);
					</script>';
				$html2 = $html;

				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<div id="'.$row->name.'Container"></div><input id="txt'.$row->name.'" name="form['.$row->name.']" value="'.$default_value.'" type="hidden"/>',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
				$html = $html2.$html;
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
				$html = str_replace('{field}','<input value="'.$key.'" type="hidden"/>',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
			case 'captcha':
				$html = str_replace('{fieldtitle}',$row->title,$row->fieldstyle);
				$html = str_replace('{validationsign}',($row->validation_rule) ? ' *':'',$html);
				$html = str_replace('{field}','<img src="'.$mainframe->getSiteURL().'index.php?option=com_forme&func=captcha"/><br/><input type="text"  value="'.$row->default_value.'" '.$row->params.' style="width:74px;text-align:center;" />',$html);
				$html = str_replace('{fielddesc}',$row->description,$html);
			break;
		}
		return $html;
	}

/**
*
*Edit Fields Layout
*
**/
function editfield(&$row)
{
	global $mainframe;
	
	$row->default_value = htmlspecialchars($row->default_value, ENT_COMPAT, 'UTF-8');
	$row->params = htmlspecialchars($row->params, ENT_COMPAT, 'UTF-8');

	//create field types list
	$field_types = array();
	$field_types[] = JHTML::_('select.option',  'text', 'text');
	$field_types[] = JHTML::_('select.option', 'password', 'password' );
	$field_types[] = JHTML::_('select.option', 'radio', 'radio' );
	$field_types[] = JHTML::_('select.option', 'checkbox', 'checkbox' );
	$field_types[] = JHTML::_('select.option', 'calendar', 'calendar' );
	$field_types[] = JHTML::_('select.option', 'textarea', 'textarea' );
	$field_types[] = JHTML::_('select.option', 'select', 'select' );
	$field_types[] = JHTML::_('select.option', 'button', 'button' );
	$field_types[] = JHTML::_('select.option', 'image button', 'image button' );
	$field_types[] = JHTML::_('select.option', 'submit button', 'submit button' );
	$field_types[] = JHTML::_('select.option', 'reset button', 'reset button' );
	$field_types[] = JHTML::_('select.option', 'file upload', 'file upload' );
	$field_types[] = JHTML::_('select.option', 'hidden', 'hidden' );
	$field_types[] = JHTML::_('select.option', 'free text', 'free text' );
	$field_types[] = JHTML::_('select.option', 'ticket number', 'ticket number' );
	$field_types[] = JHTML::_('select.option', 'captcha', 'captcha(antispam)' );
	$field_types = JHTML::_('select.genericlist', $field_types, 'inputtype', ' id="inputtype" size="1" class="inputbox" onchange="changeDesc();"', 'value', 'text', $row->inputtype );

	$field_validation = array();
	$field_validation[] = JHTML::_('select.option', '', _FORME_BACKEND_EDITFIELD_VALIDATION_NONE );
	$field_validation[] = JHTML::_('select.option', 'email', _FORME_BACKEND_EDITFIELD_VALIDATION_EMAIL );
	$field_validation[] = JHTML::_('select.option', 'number', _FORME_BACKEND_EDITFIELD_VALIDATION_NUMBER );
	$field_validation[] = JHTML::_('select.option', 'alphanum', _FORME_BACKEND_EDITFIELD_VALIDATION_ALPHANUM );
	$field_validation[] = JHTML::_('select.option', 'alpha', _FORME_BACKEND_EDITFIELD_VALIDATION_ALPHA );
	$field_validation[] = JHTML::_('select.option', 'mandatory', _FORME_BACKEND_EDITFIELD_VALIDATION_MANDATORY );

	$field_validation = JHTML::_('select.genericlist',  $field_validation, 'validation_rule', ' id="validation_rule" size="1" class="inputbox" onchange="outputValidation();"', 'value', 'text', $row->validation_rule );

	?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancelfield') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.name.value == ""){
			//BUMP needs multilanguage support
			alert( '<?php echo _FORME_EDITFIELD_ERROR_NAME;?>' );
		} else {
			if(pressbutton!='false')submitform(pressbutton);
		}
	}
	</script>
	<script language="javascript">

	function outputValidation(){
		var validationrule = document.getElementById('validation_rule');
		switch(validationrule.value){
			case '':
			document.getElementById('validationmessage').style.display = 'none';
			document.getElementById('validationmessagefield').value='';
			break;
			<?php
			if($row->validation_message!=''){
			?>
			default:
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo $row->validation_message;?>';
			break;
			<?php
			}else{
			?>
			case 'email':
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo sprintf(_FORME_BACKEND_EDITFIELD_VALIDATION_EMAIL_MESS,$row->title);?>';
			break;
			case 'number':
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo sprintf(_FORME_BACKEND_EDITFIELD_VALIDATION_NUMBER_MESS,$row->title);?>';
			break;
			case 'alphanum':
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo sprintf(_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHANUM_MESS,$row->title);?>';
			break;
			case 'alpha':
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo sprintf(_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHA_MESS,$row->title);?>';
			break;
			case 'mandatory':
			document.getElementById('validationmessage').style.display = 'inline';
			document.getElementById('validationmessagefield').value='<?php echo sprintf(_FORME_BACKEND_EDITFIELD_VALIDATION_MANDATORY_MESS,$row->title);?>';
			break;
			<?php
			}
			?>
		}
	}

	function changeDesc(){
		var inputtype = document.getElementById('inputtype');
		switch(inputtype.value){
			case 'text':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_TEXT);?>';
			break;
			case 'password':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_PASSWORD);?>';
			break;
			case 'radio':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_RADIO);?>';
			break;
			case 'checkbox':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_CHECKBOX);?>';
			break;
			case 'calendar':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_CALENDAR);?>';
			break;
			case 'textarea':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_TEXTAREA);?>';
			break;
			case 'select':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_SELECT);?>';
			break;
			case 'button':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_BUTTON);?>';
			break;
			case 'submit button':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_SUBMIT_BUTTON);?>';
			break;
			case 'reset button':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_RESET_BUTTON);?>';
			break;
			case 'image button':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_IMAGE_BUTTON);?>';
			break;
			case 'file upload':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_FILE_UPLOAD);?>';
			break;
			case 'hidden':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_HIDDEN);?>';
			break;
			case 'free text':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_FREE_TEXT);?>';
			break;
			case 'ticket number':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_TICKET_NUMBER);?>';
			break;
			case 'captcha':
			document.getElementById('fieldtype').innerHTML = '<?php echo addslashes(_FORME_BACKEND_EDITFIELD_TYPE_DESC_CAPTCHA);?>';
			break;
		}

	}

	</script>
	<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<tr>
	  		<td><img src="<?php echo JURI :: base()."components/com_forme/images/rsform.gif"; ?>" height="70" width="250" alt="RSform! Logo" align="left"></td>
	  		<td class="sectionname" align="right"><font style="color: #C24733; font-size : 18px; font-weight: bold; text-align: left;"><?php echo $row->id ? _FORME_BACKEND_EDITFORMS_EDIT_FIELD : _FORME_BACKEND_EDITFORMS_ADD_FIELD;?></font></td>
		</tr>
	</table>
	<table class="adminform">
		<tr>
			<td valign="top">
	<table cellpadding="4" cellspacing="0" border="0" class="adminform">
	<tr>
  		<th colspan="3"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_HEAD." "; ?></th>
  	</tr>
  	<tr>
  		<td valign="top" align="left" width="100%">
  			<table>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFORMS_FIELD_NAME." "; ?></td>
					<td><input name="name" value="<?php echo $row->name; ?>" size="55" maxlength="50">
					 <br><?php echo _FORME_BACKEND_EDITFORMS_FIELD_NAME_DESC." "; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFORMS_FIELD_TITLE." "; ?></td>
					<td><input name="title" value="<?php echo $row->title; ?>" size="55" maxlength="255" id="title"><br><?php echo _FORME_BACKEND_EDITFORMS_FIELD_TITLE_DESC." "; ?></td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFIELD_DESCRIPTION." "; ?></td>
					<td>
					<textarea name="description" cols="50" rows="5"><?php echo $row->description;?></textarea>
					<br><?php echo _FORME_BACKEND_EDITFIELD_DESCRIPTION_DESC." "; ?></td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFIELD_VALIDATION." "; ?></td>
					<td><?php echo $field_validation;?><br><?php echo _FORME_BACKEND_EDITFIELD_VALIDATION_DESC." "; ?><br/>
					<div id="validationmessage" style="display:<?php echo ($row->validation_rule=='') ? 'none':'inline';?>;"><?php echo _FORME_BACKEND_EDITFIELD_VALIDATION_MESSAGE." "; ?><br/><input type="text" name="validation_message" value="<?php echo $row->validation_message;?>" id="validationmessagefield" size="55"/></div>
					</td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFORMS_FIELD_TYPE." "; ?></td>
					<td><?php echo $field_types;?></td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFIELD_DEFAULT." "; ?></td>
					<td><textarea name="default_value" style="width:100%;height:50px;"><?php echo $row->default_value;?></textarea><br><?php echo _FORME_BACKEND_EDITFIELD_DEFAULT_DESC." "; ?></td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFIELD_PARAMS." "; ?></td>
					<td><input name="params" value="<?php echo $row->params; ?>" size="55">
					<input type="hidden" name="ordering" value="<?php echo $row->ordering;?>"/>
					<input type="hidden" name="published" value="<?php echo $row->published;?>"/>
					<br><?php echo _FORME_BACKEND_EDITFIELD_PARAMS_DESC." "; ?></td>
				</tr>
				<tr>
					<td><?php echo _FORME_BACKEND_EDITFIELD_FIELDSTYLE." "; ?></td>
					<td>
					<textarea name="fieldstyle" cols="50" rows="5"><?php echo $row->fieldstyle;?></textarea>
					<br><?php echo _FORME_BACKEND_EDITFIELD_FIELDSTYLE_DESC." "; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>
<td width="40%" valign="top">
	<table cellpadding="4" cellspacing="0" border="0" class="adminform">
    	<tr>
      		<th><?php echo _FORME_BACKEND_EDITFIELD_PREVIEW." "; ?></th>
      	</tr>
      	<tr>
      		<td align="center">
      			<table  border="0" cellpadding="2" cellspacing="0">
      			<?php echo forme_HTML::parseFields($row);?>
      			</table>
      		</td>
      	</tr>
	</table>
	<br/><br/>
	<table cellpadding="4" cellspacing="0" border="0" class="adminform">
    	<tr>
      		<th><?php echo _FORME_BACKEND_EDITFIELD_SUPPORT." "; ?></th>
      	</tr>
      	<tr>
      		<td align="center">
      			<table  border="0" cellpadding="2" cellspacing="0">
      			<div id="fieldtype"><?php echo _FORME_BACKEND_EDITFIELD_TYPE_DESC_TEXT." "; ?></div>
      			</table>
      		</td>
      	</tr>
	</table>
	<br/><br/>
	<table cellpadding="4" cellspacing="0" border="0" class="adminform">
    	<tr>
      		<th><?php echo _FORME_BACKEND_EDITFIELD_FORM_PREVIEW." "; ?></th>
      	</tr>
      	<tr>
      		<td align="center">
      			<a href="<?php echo $mainframe->getSiteURL();?>/index.php?option=com_forme&amp;fid=<?php echo $row->form_id;?>" target="_blank" style="text-decoration:none;font-size:14px;text-align:center;padding-top:4px;font-weight:bold;"><?php echo _FORME_BACKEND_EDITFIELD_FORM_PREVIEW." "; ?></a>
      		</td>
      	</tr>
	</table>
</td>
</tr>
</table>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0"/>
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="form_id" value="<?php echo $row->form_id; ?>" />
	<input type="hidden" name="task" value="" />
</form>
<script language="javascript">changeDesc();</script>
<?php
}

/**
*
*Edit Forms Layout
*
**/
function editforms(&$row, &$field_rows){

	$CONFIG = new JConfig();
	jimport('joomla.html.pane');
	
	if($row->emailfrom=='')$row->emailfrom = $CONFIG->mailfrom;
	if($row->emailto=='')$row->emailto = $CONFIG->mailfrom.',{email}';
	if($row->emailfromname=='')$row->emailfromname = $CONFIG->sitename;
	if($row->emailsubject=='')$row->emailsubject = _FORME_BACKEND_EDITFORMS_EMAIL_SUBJECT_DEFAULT;
	if($row->email=='')$row->email = _FORME_BACKEND_EDITFORMS_EMAIL_TEXT_DEFAULT;

	$tabs	=& JPane::getInstance();
	$editor =& JFactory::getEditor();

	?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancelform') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.name.value == "" || form.title.value == ""){
			//BUMP needs multilanguage support
			alert( "Form must have a name and a title" );
		} else {
			if(pressbutton!='false')submitform(pressbutton);
		}
	}
	</script>

	<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<tr>
	  		<td><img src="<?php echo JURI :: base()."components/com_forme/images/rsform.gif"; ?>" height="70" width="250" alt="RSform! Logo" align="left"></td>
	  		<td class="sectionname" align="right"><font style="color: #C24733; font-size : 18px; font-weight: bold; text-align: left;"><?php echo $row->id ? _FORME_BACKEND_EDITFORMS_EDIT_FORM : _FORME_BACKEND_EDITFORMS_ADD_FORM;?></font></td>
		</tr>
	</table>
	<table width="100%" border="0">
		<tr>
			<td width="40%" valign="top">
				<?php
				echo $tabs->startPane("content-pane");
				echo $tabs->startPanel(_FORME_BACKEND_EDITFORMS_TITLE_FORMEDIT,"form-edit");
				?>
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
		    	<tr>
		      		<th colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_HEAD." "; ?></th>
		      	</tr>
		      	<tr>
		      		<td valign="top" align="left" width="100%">
		      			<table>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_FORMS_TITLE." "; ?><br/>
		    					<input name="title" value="<?php echo $row->title; ?>" size="55"></td>
		  					</tr>
		      				<tr>
		      				  <td></td>
		   				  	</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_FORMS_NAME." "; ?><br/>
		    					<input name="name" value="<?php echo $row->name; ?>" size="55"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_FORMS_LANGUAGE; ?><br/>
		    					<input name="lang" value="<?php echo $row->lang; ?>" size="5"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_FORMS_RETURN." "; ?><br/>
		    					<input name="return_url" value="<?php echo $row->return_url; ?>" size="55"><br/>
		    					<?php echo _FORME_BACKEND_FORMS_RETURN_DESC." "; ?>
		    					</td>
		  					</tr>
		  				</table>
		  			</td>
		  		</tr>

				</table>
				<?php
				echo $tabs->endPanel();
				echo $tabs->startPanel(_FORME_BACKEND_EDITFORMS_TITLE_FORMSTYLE,"form-style");
				?>
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
		    	<tr>
		      		<th colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_STYLE_HEAD." "; ?></th>
		      	</tr>
		      		<td>
		      			<table>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_STYLE." "; ?><br/>
		    					<?php
		    					if($row->formstyle=='')$row->formstyle = _FORME_BACKEND_EDITFORMS_STYLE_DEFAULT;
		    					?>
								<textarea rows="10" cols="75" name="formstyle" style="width:100%;"><?php echo $row->formstyle;?></textarea><br/>
								<?php echo _FORME_BACKEND_EDITFORMS_STYLE_DESC." "; ?>
								</td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_FIELDSTYLE." "; ?><br/>
		    					<?php
		    					if($row->fieldstyle=='')$row->fieldstyle = _FORME_BACKEND_EDITFORMS_FIELDSTYLE_DEFAULT;
		    					?>
								<textarea rows="7" cols="75" name="fieldstyle" style="width:100%;"><?php echo $row->fieldstyle;?></textarea><br/>
								<?php echo _FORME_BACKEND_EDITFORMS_FIELDSTYLE_DESC." "; ?>
								</td>
		  					</tr>
						</table>

					</td>
				</tr>
				</table>
				<?php
				echo $tabs->endPanel();
				echo $tabs->startPanel(_FORME_BACKEND_EDITFORMS_TITLE_THANKYOU,"thank-you");
				?>
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
		    	<tr>
		      		<th colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_TY_HEAD." "; ?></th>
		      	</tr>
		      		<td>
		      			<table>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_THANKYOU." "; ?><br/>
		    					<?php
								echo $editor->display( 'thankyou',  $row->thankyou , '100%', '550', '75', '20' ) ;
								?>
								</td>
		  					</tr>
		  					<tr>
		  						<td><?php echo _FORME_BACKEND_EDITFORMS_THANKYOU_DESC." "; ?></td>
		  					</tr>
						</table>

					</td>
				</tr>
				</table>
				<?php
				echo $tabs->endPanel();
				echo $tabs->startPanel(_FORME_BACKEND_EDITFORMS_TITLE_EMAILS,"email-notify");
				?>
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
		    	<tr>
		      		<th colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_HEAD." "; ?></th>
		      	</tr>
		      	<tr>
		      		<td valign="top" align="left" width="100%">
		      			<table>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_RECIPIENTS." "; ?><br/>
		    					<input name="emailto" value="<?php echo str_replace(' ','',$row->emailto); ?>" size="55"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_FROM." "; ?><br/>
		    					<input name="emailfrom" value="<?php echo str_replace(' ','',$row->emailfrom); ?>" size="55"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_FROMNAME." "; ?><br/>
		    					<input name="emailfromname" value="<?php echo $row->emailfromname; ?>" size="55"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_SUBJECT." "; ?><br/>
		    					<input name="emailsubject" value="<?php echo $row->emailsubject; ?>" size="55"></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_MODE." "; ?><br/>
		    					<?php echo JHTML::_('select.booleanlist', 'emailmode', 'onclick="javascript:submitbutton(\'applyform\');"', $row->emailmode,_FORME_BACKEND_EDITFORMS_EMAIL_MODE_HTML,_FORME_BACKEND_EDITFORMS_EMAIL_MODE_TEXT );?></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL." "; ?><br/>
		    					<?php
		    					if($row->emailmode){
								echo $editor->display( 'email',  $row->email , '100%', '550', '75', '20' ) ;
		    					}else{?>
								<textarea rows="7" cols="75" name="email" style="width:100%;"><?php echo $row->email;?></textarea>
								<?php
		    					}
								?>
								</td>
		  					</tr>
		  					<tr>
		  						<td><?php echo _FORME_BACKEND_EDITFORMS_EMAIL_DESC." "; ?></td>
		  					</tr>
						</table>

					</td>
				</tr>
				</table>

				<?php
				echo $tabs->endPanel();
				echo $tabs->startPanel(_FORME_BACKEND_EDITFORMS_TITLE_SCRIPTS,"script-notify");
				?>
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
		    	<tr>
		      		<th colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_SCRIPTS_HEAD." "; ?></th>
		      	</tr>
		      	<tr>
		      		<td valign="top" align="left" width="100%">
		      			<table>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_SCRIPT_DISPLAY." "; ?><br/>
		    					<textarea rows="20" cols="75" name="script_display" style="width:100%;"><?php echo $row->script_display;?></textarea><br/>
		    					<?php echo _FORME_BACKEND_EDITFORMS_SCRIPT_DISPLAY_DESC." "; ?></td>
		  					</tr>
		  					<tr>
		    					<td><?php echo _FORME_BACKEND_EDITFORMS_SCRIPT_PROCESS." "; ?><br/>
		    					<textarea rows="20" cols="75" name="script_process" style="width:100%;"><?php echo $row->script_process;?></textarea><br/>
		    					<?php echo _FORME_BACKEND_EDITFORMS_SCRIPT_PROCESS_DESC." "; ?></td>
		  					</tr>
						</table>

					</td>
				</tr>
				</table>

				<?php
				echo $tabs->endPanel();
				echo $tabs->endPane();
				?>
			</td>
			<td width="60%" valign="top">
				<table cellpadding="4" cellspacing="0" border="0" class="adminform">
			    	<tr>
			      		<th colspan="8"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_HEAD." "; ?></th>
			      	</tr>

					<tr>
						<th width="7"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $field_rows ); ?>);" /></th>
						<th align="left" class="title"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_NAME." "; ?></th>
						<th align="left" class="title"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_TITLE." "; ?></th>
						<th align="left" class="title"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_TYPE." "; ?></th>
						<th align="left" class="title"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_PUBLISH." "; ?></th>
						<th align="left" class="title" colspan="2"><?php echo _FORME_BACKEND_EDITFORMS_FIELD_ORDERING." "; ?></th>
						<th width="1%"><a href="javascript: saveorder( <?php echo count( $field_rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a></th>
					</tr>
					<?php
					$k = 0;
					for ($i=0, $n=count($field_rows); $i < $n; $i++) {
						$field_row = &$field_rows[$i];
						$link 	= 'index.php?option=com_forme&task=editfield&hidemainmenu=1&cid='. $field_row->id;
			   		?>
						<tr class="<?php echo "row$k"; ?>">
							<td width="7"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $field_row->id; ?>" onclick="isChecked(this.checked);" /></td>
							<td><a href="<?php echo $link; ?>">
								<?php echo $field_row->name;?>
								</a>
							</td>
							<td>
								<?php echo $field_row->title;?>
							</td>
							<td>
								<?php echo $field_row->inputtype;?>
							</td>
							<?php
							$task = $field_row->published ? 'unpublishfield' : 'publishfield';
							$img = $field_row->published ? 'publish_g.png' : 'publish_x.png';
							$alt = $field_row->published ? 'Published' : 'Unpublished';
							?>
							<td><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" /></a></td>
							<td width="25" align="right">
								<?php		if ($i > 0) { ?>
			        			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','orderupfield')">
			        			<img src="images/uparrow.png" width="12" height="12" border="0" alt="orderup">
			        			</a>
			        			<?php		} ?>
						  	</td>
							<td width="25" align="left">
								<?php		if ($i < $n-1) { ?>
			        			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','orderdownfield')">
			        			<img src="images/downarrow.png" width="12" height="12" border="0" alt="orderdown">
			        			</a>
			        			<?php		}?>
							</td>
							<td align="center">
								<input type="text" name="order[]" size="5" value="<?php echo $field_row->ordering; ?>" class="text_area" style="text-align: center" />
							</td>
							<?php $k = 1 - $k; } ?>
						</tr>
				</table>
			</td>
		</tr>
	</table>
<br/><br/>

		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		<input type="hidden" name="option" value="com_forme" />
		<input type="hidden" name="form_id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
	</form>

<?php
}
/**
 * Display the main component control panel
 */
function controlPanel() {
    global $mainframe;

	$formeConfig = buildFormeConfig();


    $modifyRegister = JRequest::getVar('modify_register',0,'POST');
    if($modifyRegister){
    	$formeConfig['global.register.code'] = '';
    }

    ?>
    <form action="index.php" method="post" name="adminForm">
    <table class="thisform">
   		<tr class="thisform">
      		<td width="50%" valign="top" class="thisform">
      			<table width="100%" class="thisform2" border="1">
      				<tr class="thisform2">
	      				<td align="center" height="100px" width="33%" class="thisform2">
	      				<div align="center">
				            <a href="index.php?option=com_forme&task=forms" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_FORMS;?>">
				            <img src="components/com_forme/images/forms.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_FORMS;?>
				            </a>
				        </div>
						</td>
	      				<td align="center" height="100px" width="34%" class="thisform2">
				            <a href="index.php?option=com_forme&task=listdata" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_VIEWDATA;?>">
				            <img src="components/com_forme/images/viewdata.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_VIEWDATA;?>
				            </a>
						</td>
	      				<td align="center" height="100px" width="34%" class="thisform2">
				            <a href="index.php?option=com_forme&task=sample" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_ADD_SAMPLE;?>">
				            <img src="components/com_forme/images/samples.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_ADD_SAMPLE;?>
				            </a>
						</td>
					</tr>
      				<tr class="thisform2">
	      				<td align="center" height="100px" width="33%" class="thisform2">
				            <a href="index.php?option=com_forme&task=backup" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_BACKUP;?>">
				            <img src="components/com_forme/images/backup.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_BACKUP;?>
				            </a>
						</td>
	      				<td align="center" height="100px" class="thisform2">
				            <a href="index.php?option=com_forme&task=restore" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_RESTORE;?>">
				            <img src="components/com_forme/images/restore.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_RESTORE;?>
				            </a>
						</td>
	      				<td align="center" height="100px" class="thisform2">
				            <a href="index.php?option=com_forme&task=info" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_INFORMATION;?>">
				            <img src="components/com_forme/images/systeminfo.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_INFORMATION;?>
				            </a>
						</td>
					</tr>
      				<tr class="thisform2">
	      				<td align="center" height="100px" class="thisform2">
				            <a href="index.php?option=com_forme&task=update" style="text-decoration:none;" title="<?php echo _FORME_BACKEND_CPANEL_UPDATE;?>">
				            <img src="components/com_forme/images/restore.png" width="48px" height="48px" align="middle" border="0"/>
				            <br />
				            <?php echo _FORME_BACKEND_CPANEL_UPDATE;?>
				            </a>
						</td>
	      				<td align="center" height="100px" class="thisform2">&nbsp;	</td>
						<td align="center" height="100px" class="thisform2">&nbsp;	</td>
					</tr>
				</table>

			</td>
		    <td width="50%" valign="top" align="center">

			    <table border="1" width="100%" class="thisform">
					<tr class="thisform">
			            <th class="cpanel" colspan="2"><?php echo _FORME_PRODUCT . ' ' . _FORME_VERSION;?></th></td>
			         </tr>
			         <tr class="thisform"><td bgcolor="#FFFFFF" colspan="2"><br />
					  <div style="width=100%" align="center">
					  <img src="components/com_forme/images/rsform.gif" align="middle" alt="RSform! Logo"/>
					  <br /><br /></div>
					  </td>
					 </tr>
			         <tr class="thisform">
			            <td width="120" bgcolor="#FFFFFF">Installed version:</td>
			            <td bgcolor="#FFFFFF"><?php echo _FORME_VERSION;?></td>
			         </tr>
			         <tr class="thisform">
			            <td bgcolor="#FFFFFF">Copyright:</td>
			            <td bgcolor="#FFFFFF"><?php echo _FORME_COPYRIGHT;?></td>
			         </tr>
			         <tr class="thisform">
			            <td bgcolor="#FFFFFF">License:</td>
			            <td bgcolor="#FFFFFF"><?php echo _FORME_LICENSE;?></td>
			         </tr>
			         <tr class="thisform">
			            <td valign="top" bgcolor="#FFFFFF">Author:</td>
			            <td bgcolor="#FFFFFF">
			            <?php echo _FORME_AUTHOR;?>
						</td>
			         </tr>
			         <tr class="<?php echo ($formeConfig['global.register.code']==''||$formeConfig['global.register.code']=='') ? 'thisformError':'thisformOk';?>">
						<td valign="top">
							<?php echo _FORME_CODE;?>
						</td>
						<td>
							<?php echo ($formeConfig['global.register.code']=='') ? '<input type="text" name="formeConfig[global.register.code]" value=""/>':$formeConfig['global.register.code'];?>
						</td>
			         </tr>
			         <tr class="<?php echo ($formeConfig['global.register.code']==''||$formeConfig['global.register.code']=='') ? 'thisformError':'thisformOk';?>">
						<td valign="top">&nbsp;</td>
						<td>
							<?php
							if($formeConfig['global.register.code']!=''){
							?>
							<input type="submit" name="modify_register" value="<?php echo _FORME_REGISTER_MODIFY;?>" /><br/>

							<?php
							echo _FORME_REGISTER_MODIFY_NOTICE;
							}else{
							?>
							<input type="button" name="register" value="<?php echo _FORME_REGISTER;?>" onclick="javascript:submitbutton('saveRegistration');"/>
							<?php
							}
							?>
						</td>
			         </tr>
					 <tr>
						<td colspan="2">
						<p align="center"><a href="http://www.rsjoomla.com/joomla-components/joomla-security.html" target="_blank"><img src="<?php echo JURI::root(); ?>administrator/components/com_forme/images/rsfirewall-approved.gif" align="middle" alt="RSForm! Pro logo"/></a></p> 
						</td>
					 </tr>
			      </table>
		      </td>
		   </tr>
		</table> 
		<input type="hidden" name="option" value="com_forme" />
		<input type="hidden" name="task" value="" />
	</form>
<?php
}

/**
 * List Data
 *
 * @param String $option
 * @param unknown_type $rows
 * @param unknown_type $pageNav
 */
function listdata(&$rows, &$form, &$forms, &$pageNav){

	global $mainframe;

	//check if the event has a form attached
	$colspan = 4;
	if(!empty($form->fields)) $colspan = 4 + count($form->fields);
?>

<form action="index.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
	  		<td><img src="<?php echo JURI :: base()."components/com_forme/images/rsform.gif"; ?>" height="70" width="250" alt="RSform! Logo" align="left"></td>
	  		<td colspan="<?php echo $colspan-1;?>" class="sectionname" align="right"><font style="color: #C24733; font-size : 18px; font-weight: bold; text-align: left;"><?php echo _FORME_BACKEND_LISTDATA_LIST_DATA;?></font></td>
		</tr>
		<tr>
	  		<td colspan="<?php echo $colspan;?>">&nbsp;</td>
	  	</tr>
		<tr>
			<td colspan="<?php echo $colspan-1;?>">&nbsp;</td>
			<td align="right" style="white-space:nowrap">
			<?php
			echo _FORME_BACKEND_LISTDATA_LIMIT." ";
			echo $pageNav->getLimitBox();
			?>
			<?php
			$html = JHTML::_('select.genericlist', $forms, 'cid', 'size="1" class="inputbox" onchange="document.adminForm.submit();"', 'value', 'text', $form->id );
			echo $html;
			?>
			</td>
	  	</tr>
		<tr>
	  		<td colspan="<?php echo $colspan;?>">&nbsp;</td>
	  	</tr>
	  	<?php
  			echo '<tr>';
  			echo '<th width="5" align="left"><input type="checkbox" name="toggle" value="" onClick="checkAll('.count( $rows ).')" /></th>';
  			echo '<th class="title">'._FORME_BACKEND_LISTDATA_USERIP." ".'</th>';
  			echo '<th class="title">'._FORME_BACKEND_LISTDATA_DADDED." ".'</th>';
  			foreach ($form->fields as $field_name=>$field){
  				echo '<th class="title">'.$field_name.'</th>';
  			}
			echo '<th class="title" align="right" style="text-align:right;">'._FORME_BACKEND_LISTDATA_DELETE." ".'</th>';
  			echo '</tr>';
		?>

		<?php
		$k = 0;
		for($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
				?>
					<tr class="<?php echo "row$k"; ?>">
						<td><input type="checkbox" id="cb<?php echo $i;?>" name="rcid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
						<td><?php echo $row->uip;?></td>
						<td><?php echo $row->date_added;?></td>
						<?php
							//build params
							$reg_params = explode("||\n",$row->params);
							$custom_params = array();
							foreach ($reg_params as $each){
								$each = explode('=',$each,2);
								if(!isset($each[1]))$each[1] = '';
								$custom_params[$each[0]] = $each[1];
							}
							foreach ($form->fields as $field){
								if(isset($custom_params[$field->name]))	{
									if($field->inputtype == 'file upload') $custom_params[$field->name] = '<a href="'.$mainframe->getSiteURL().'/components/com_forme/uploads/'.$custom_params[$field->name].'" target="_blank">'.$custom_params[$field->name].'</a>';
									echo '<td>'.$custom_params[$field->name].'</td>';
								}else{
									echo '<td>&nbsp;</td>';
								}
							}

						?>
						<td align="right"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','deldata')"><img src="images/publish_x.png" width="12" height="12" border="0" alt="Delete" /></a></td>
					</tr>
				<?php

			$k = 1 - $k;
			} ?>

		<tr>
		  <td align="center" colspan="<?php echo $colspan;?>"><?php echo $pageNav->getPagesLinks(); ?></td>
	  	</tr>
		<tr>
		  <td align="center" colspan="<?php echo $colspan;?>"><?php echo $pageNav->getPagesCounter(); ?></td>
	  	</tr>
	</table>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="task" value="listdata" />
	<input type="hidden" name="hidemainmenu" value="0">
</form>
<?php
}

function restore(){
	?>
	<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	  <p>&nbsp;</p>
	 <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	 	<tr>
	 		<th colspan="2"><?php echo _FORME_BACKEND_RESTORE_HEAD." "; ?></th>
	 	</tr>
		<tr>
			<td align="right"><?php echo _FORME_BACKEND_RESTORE_CHOOSE_BACKUP;?></td>
			<td><input type="file" name="backupfile"></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td><input type="submit" name="submitbutton" value="<?php echo _FORME_BACKEND_RESTORE_BUTTON;?>" onclick="return confirm('<?php echo _FORME_BACKEND_RESTORE_BUTTON_CONFIRM;?>');">
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?php echo _FORME_BACKEND_RESTORE_POLICY;?></td>
		</tr>
	</table>

	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="task" value="restoreprocess" />
	<input type="hidden" name="hidemainmenu" value="0">
</form>
	<?php
}

function updateManage()
{
	global $formeConfig;
	?>
	<form action="<?php echo JURI::root(); ?>administrator/index.php?option=com_forme&task=update" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
	<table class="adminform">
            <tr>
                <th>
                    Checking for updates
                </th>
            </tr>
		    <tr>
			    <td>
				    <iframe src="http://www.rsjoomla.com/index2.php?option=com_rslicense&task=checkUpdate&sess=<?php echo forme_HTML::genKeyCode();?>&amp;revision=<?php echo _FORME_VERSION;?>&amp;version=1.5" style="border:0px solid;width:100%;height:18px;" scrolling="no" frameborder="no"></iframe>
			    </td>
		    </tr>
		</table>
		 <br />
        <table class="adminform">				
			<tr>
				<td><iframe src="http://www.rsjoomla.com/latest.html?tmpl=component" style="border:0px solid;width:100%;height:380px;" scrolling="no" frameborder="no"></iframe></td>
			</tr>
        </table>
	
	<input type="hidden" name="option" value="com_forme" />
	<input type="hidden" name="task" value="" />
	</form>
	<?php
}

}

?>