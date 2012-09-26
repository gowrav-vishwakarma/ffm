<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
//FRONTEND

DEFINE('_FORME_PRODUCT','RSform!');
DEFINE('_FORME_VERSION','1.0.6');
DEFINE('_FORME_KEY','1XKJ3KS7JO');
DEFINE('_FORME_COPYRIGHT','&copy;2007-2009 http://www.rsjoomla.com');
DEFINE('_FORME_LICENSE','GPL License');
DEFINE('_FORME_AUTHOR','<a href="http://www.rsjoomla.com" target="_blank">www.rsjoomla.com</a>');
DEFINE('_FORME_CODE','Please enter your code to receive updates');
DEFINE('_FORME_REGISTER','Update Registration');
DEFINE('_FORME_REGISTER_MODIFY','Modify Registration');
DEFINE('_FORME_REGISTER_MODIFY_NOTICE','If you are using a tryout version, <a href="index2.php?option=com_forme&task=update">click here</a> to update to full version.');
DEFINE('_FORME_DATETIME','d M Y');

//BACKEND TOOLBAR
DEFINE('_FORME_BACKEND_TOOLBAR_MAIN','RSForm');
DEFINE('_FORME_BACKEND_TOOLBAR_EDIT','Edit');
DEFINE('_FORME_BACKEND_TOOLBAR_REMOVE','Remove');
DEFINE('_FORME_BACKEND_TOOLBAR_DUPLICATE','Copy');
DEFINE('_FORME_BACKEND_TOOLBAR_PREVIEW','Preview');
DEFINE('_FORME_BACKEND_TOOLBAR_CLOSE','Close');
DEFINE('_FORME_BACKEND_TOOLBAR_EXPORT','Export');
DEFINE('_FORME_BACKEND_TOOLBAR_EXPORT_ALL','Export All');
DEFINE('_FORME_BACKEND_TOOLBAR_NEWFIELD','New Field');
DEFINE('_FORME_BACKEND_TOOLBAR_UPDATE','Update');
DEFINE('_FORME_BACKEND_TOOLBAR_REMOVE_MESSAGE','Are you sure you want to delete?');
//BACKEND CPANEL
DEFINE('_FORME_BACKEND_CPANEL_FORMS','Forms Manager');
DEFINE('_FORME_BACKEND_CPANEL_DATA','Data Manager');
DEFINE('_FORME_BACKEND_CPANEL_ADD_SAMPLE','Add Sample Data');
DEFINE('_FORME_BACKEND_CPANEL_VIEWDATA','View Data');
DEFINE('_FORME_BACKEND_CPANEL_INFORMATION','Info');
DEFINE('_FORME_BACKEND_CPANEL_UPDATE','Check for Updates');
DEFINE('_FORME_BACKEND_CPANEL_SUPPORT','Support');
DEFINE('_FORME_BACKEND_CPANEL_RESTORE','Restore Your Forms');
DEFINE('_FORME_BACKEND_CPANEL_BACKUP','Backup Your Forms');

//BACKEND SUPPORT
DEFINE('_FORME_BACKEND_SUPPORT_HEAD','Support');
DEFINE('_FORME_BACKEND_SUPPORT_TICKET_HEAD','Tickets');

//BACKEND SAVEREG
DEFINE('_FORME_BACKEND_SAVEREG_CODE','Please enter your registration code.');
DEFINE('_FORME_BACKEND_SAVEREG_SAVED','Registration Saved.');

//BACKEND UPGRADE
DEFINE('_FORME_BACKEND_UPGRADE','Version Upgrade Utility');
DEFINE('_FORME_BACKEND_UPGRADE_ACCEPT','<font color="red"><strong>Do NOT interrupt this process.</strong></font> You risk damaging your RSform! component files if you do so.<br/>I accept your terms. I want to update my version. <input type="checkbox" name="accept" value="1"/>');
DEFINE('_FORME_BACKEND_UPGRADE_CONTINUE','<input type="submit" name="submit" value="Continue"/>');
DEFINE('_FORME_BACKEND_UPGRADE_SUCCESS','<font color=green><strong>Success,</strong></font> %s <br/>');
DEFINE('_FORME_BACKEND_UPGRADE_FAIL','<font color=red><strong>Fail,</strong></font> %s <br/>');

DEFINE('_FORME_BACKEND_UPDATESMANAGE_UPDATE_TITLE','Upload Package File');
DEFINE('_FORME_BACKEND_UPGRADE_ERROR_DIR','<font color=red><strong>Error</strong></font>, your <strong>%s</strong> directory is NOT WRITABLE<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_ERROR_REMOTE','<font color=red><strong>Error</strong></font>, invalid code or remote file %s not available<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_ERROR_LOCAL','<font color=red><strong>Error</strong></font>, could not open local file %s for writing<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_ERROR_WRITE','<font color=red><strong>Error</strong></font>, could not write into local file %s<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_ERROR_DELETE','<font color=red><strong>Error</strong></font>, could not delete the local file %s<br/>');

DEFINE('_FORME_BACKEND_UPGRADE_STATUS_DIR','<font color=green><strong>Check OK</strong></font>, your <strong>"%s"</strong> is WRITABLE<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_STATUS_REMOTE','<font color=green><strong>Check OK</strong></font>, remote XML update file %s loaded<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_STATUS_NOUPDATE','<font color=green><strong>Check OK,</strong></font> There is no update available.<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_STATUS_WRITE','<font color=green><strong>Update OK,</strong></font> The file %s was updated.<br/>');
DEFINE('_FORME_BACKEND_UPGRADE_STATUS_DELETE','<font color=green><strong>Delete OK,</strong></font> The file %s was deleted.<br/>');
DEFINE('_FORME_BACKEND_UPDATESMANAGE_PERMISSIONS','Please set writable permissions to the folders above and their enclosed items. You must make the folders writable.');
DEFINE('_FORME_BACKEND_UPDATESMANAGE_UPDATE_FILE','Package File:');
DEFINE("_FORME_BACKEND_UPDATESMANAGE_BUTTON","Update");
DEFINE('_FORME_BACKEND_UPDATESMANAGE_INSTRUCTIONS','<h2>Updates Instructions</h2>
<ul>
	<li>Whenever we release a new update, you are able to download it directly from this screen. Save the file on your computer, then click on Browse, and then install the update.</li>
</ul>');
DEFINE('_FORME_BACKEND_UPDATECHECK_STATUS_FORMEUPDATE','The component was updated.');
DEFINE('_FORME_BACKEND_UPDATECHECK_OK','Success');
DEFINE('_FORME_BACKEND_UPDATECHECK_NOINSTALL','Please select a valid file.');
DEFINE('_FORME_BACKEND_UPDATECHECK_BADFILE','The file you selected is not valid.');

//BACKEND RESTORE
DEFINE('_FORME_BACKEND_RESTORE_HEAD','Restore your Forms');
DEFINE('_FORME_BACKEND_RESTORE_CHOOSE_BACKUP','Select your Restore File.');
DEFINE('_FORME_BACKEND_RESTORE_BUTTON','Restore');
DEFINE('_FORME_BACKEND_RESTORE_BUTTON_CONFIRM','By confirming this message, you agree our terms and conditions.');
DEFINE('_FORME_BACKEND_RESTORE_MSG','%s Queries Executed Successfully.');
DEFINE('_FORME_BACKEND_RESTORE_POLICY','<font color="red"><strong>Attention! This procedure will erase the current forms, fields and the data stored and will replace them with the backup data.</strong></font><hr/>You expressly acknowledge and agree that use of the Software is at your sole risk. The Software is provided "AS IS" and without warranty of any kind and pimpmyjoomla.com expressly disclaims all warranties, express and implied, including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose. RSform! does not warrant that the features contained in the software will meet Your requirements, or that the operation of the software will be uninterrupted or error-free, or that defects in the software will be corrected. The entire risk as to the results and performance of the software is assumed by You. Furthermore, pimpmyjoomla.com does not warrant or make any representations regarding the use or the results of the use of the Software or related documentation in terms of their correctness, accuracy, reliability, currentness, or otherwise. No oral or written information or advice given by RSform! or RSform!\'s authorized representative shall create a warranty or in any way increase the scope of this warranty.<br/><br/>');

//BACKEND LIST FORMS
DEFINE('_FORME_BACKEND_FORMS_MANAGE_FORMS','::Manage Forms::');
DEFINE('_FORME_BACKEND_FORMS_TITLE','Form Title');
DEFINE('_FORME_BACKEND_FORMS_NAME','Form Name');
DEFINE('_FORME_BACKEND_FORMS_RETURN','Return URL');
DEFINE('_FORME_BACKEND_FORMS_RETURN_DESC','You can set up a Return URL where the user will be redirected after submitting the data. If thank you is enabled (not empty), the user will first see the thank you message and then click continue to be redirected.<br/><br/> The return URL can be customized with your fields. So if you have a radio choice in your form, you can add {radiofield}.html as return url. This way, if a user selects the first option, it will be redirected to firstoption.html, otherwise to secondoption.html.');
DEFINE('_FORME_BACKEND_FORMS_PUBLISHED','Published');
DEFINE('_FORME_BACKEND_FORMS_DATA','Data');
DEFINE('_FORME_BACKEND_FORMS_LINK','Form Link');
DEFINE('_FORME_BACKEND_FORMS_PREVIEW','Preview');
DEFINE('_FORME_BACKEND_FORMS_ID','Form ID');
DEFINE('_FORME_BACKEND_FORMS_TODAY','Today: ');
DEFINE('_FORME_BACKEND_FORMS_MONTH','This Month: ');
DEFINE('_FORME_BACKEND_FORMS_ALL','All: ');
DEFINE('_FORME_BACKEND_FORMS_SEARCH','Search:');
DEFINE('_FORME_BACKEND_FORMS_SEARCH_LIMIT','Page limit:');

//BACKEND EDIT FORM
DEFINE('_FORME_BACKEND_EDITFORMS_EDIT_FORM','::Edit Form::');
DEFINE('_FORME_BACKEND_EDITFORMS_ADD_FORM','::Add Form::');

DEFINE('_FORME_BACKEND_EDITFORMS_TITLE_FORMEDIT','Form Edit');
DEFINE('_FORME_BACKEND_EDITFORMS_TITLE_FORMSTYLE','Form Style');
DEFINE('_FORME_BACKEND_EDITFORMS_TITLE_THANKYOU','Thank You');
DEFINE('_FORME_BACKEND_EDITFORMS_TITLE_EMAILS','Emails');
DEFINE('_FORME_BACKEND_EDITFORMS_TITLE_SCRIPTS','Scripts');

DEFINE('_FORME_BACKEND_FORMS_LANGUAGE','Form Language ISO(for multilanguage support).If you want to enable multiple language forms you must have at least two forms with the same Form Name, but with different Form Language ISO.');
DEFINE('_FORME_BACKEND_EDITFORMS_HEAD','Form Editor');
DEFINE('_FORME_BACKEND_EDITFORMS_STYLE_HEAD','Form Style');
DEFINE('_FORME_BACKEND_EDITFORMS_TY_HEAD','Thank You Message');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_HEAD','Notification Email');
DEFINE('_FORME_BACKEND_EDITFORMS_SCRIPTS_HEAD','PHP Scripts');
DEFINE('_FORME_BACKEND_EDITFORMS_THANKYOU','Thank You Message');
DEFINE('_FORME_BACKEND_EDITFORMS_THANKYOU_DESC','The Thank You message appears after the user fills the form. It can be customized with your form\'s fields ids. For instance you could use something like: <br/><br/><strong>&laquo;Dear {firstname} {lastname},<br/><br/>Your information has been successfully stored and you will be contacted shortly.&raquo;</strong> <br/><br/>Where firstname, lastname are field ids in your form.<br/><br/>Global variables are available too: {sitename},{siteurl}');

DEFINE('_FORME_BACKEND_EDITFORMS_STYLE','Edit the form style: (<font color="red">Do not touch this unless you know what you do</font>):');
DEFINE('_FORME_BACKEND_EDITFORMS_STYLE_DESC','<font color="red">In order to make your form work properly, make sure you have the following code in your form style:<br/>
'.'
...yourcontent...<br/>
'.htmlentities('<form name="{formname}" id="{formname}" method="post" action="{action}" {enctype}>').'<br/>
...yourcontent...<br/>
{formfields}<br/>
...yourcontent...<br/>'.htmlentities('</form>').'
</font><br/><br/>
If your form is not working nomore, just delete all the code from the Form Style field, and save the form. (this way it will return to it\'s default value)');
DEFINE('_FORME_BACKEND_EDITFORMS_STYLE_DEFAULT','
<div align="left" style="width:100%" class="componentheading">{formtitle}</div>
<form name="{formname}" id="{formname}" method="post" action="{action}" {enctype}>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="forme">
	{formfields}
	</table>
</form>');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELDSTYLE','Edit the field style: (<font color="red">Do not touch this unless you know what you do</font>):');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELDSTYLE_DESC','<font color="red">In order to make your form work properly, make sure you have the following code in your field style:<br/>
'.'...yourcontent...{field}...yourcontent...<br/></font><br/><br/>
If your form is not working nomore, just delete all the code from the Form Style field and the Field Style , and save the form. (this way it will return to it\'s default value)');

DEFINE('_FORME_BACKEND_EDITFORMS_FIELDSTYLE_DEFAULT','
<tr>
	<td align="right" valign="top">{fieldtitle}{validationsign}</td>
	<td valign="top">{field}</td>
	<td valign="top">{fielddesc}</td>
</tr>
');

DEFINE('_FORME_BACKEND_EDITFORMS_SCRIPT_DISPLAY','Script called on form display');
DEFINE('_FORME_BACKEND_EDITFORMS_SCRIPT_DISPLAY_DESC','Add your script without &lt;php ?&gt;');

DEFINE('_FORME_BACKEND_EDITFORMS_SCRIPT_PROCESS','Script called on form process');
DEFINE('_FORME_BACKEND_EDITFORMS_SCRIPT_PROCESS_DESC','Add your script without &lt;php ?&gt;');


DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_RECIPIENTS','<strong>Email Form data to:</strong> <br/>Use comma(,) to add multiple recipients. You can add {email} too (if you previously added email as a field of your form. This way the user will receive a confirmation via email of the data he submitted.)');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_FROM','<strong>Email Form data FROM:</strong> <br/>Add the email address from which the email is being sent.(You can use your business e-mail here)');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_FROMNAME','<strong>Email From Name:</strong> <br/>Add the name from which the e-mail is being sent.(You can use your business name here)');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_SUBJECT','<strong>Email Subject:</strong>');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_MODE','<strong>Email Mode(Text/HTML):</strong>');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_MODE_TEXT','Text');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_MODE_HTML','HTML');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL','<strong>Email Text:</strong>');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_DESC','You can add the form fields to this message if you enclose them in {}. Example:<br/>Dear {fullname}, thank you for your visit.');

DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_SUBJECT_DEFAULT','Thank you for the submission');
DEFINE('_FORME_BACKEND_EDITFORMS_EMAIL_TEXT_DEFAULT','You can add the form fields to this message if you enclose them in {}. Example:<br/>Dear {fullname}, thank you for your visit.');




DEFINE('_FORME_BACKEND_EDITFORMS_EDIT_FIELD','::Edit Field::');
DEFINE('_FORME_BACKEND_EDITFORMS_ADD_FIELD','::Add Field::');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_HEAD','Form Fields');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_TITLE','Field Title');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_NAME','Field Id');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_TYPE','Field Type');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_PUBLISH','Publish');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_ORDERING','Order');

DEFINE('_FORME_BACKEND_SUC_PUBL_FORM',' Form(s) successfully Published.');
DEFINE('_FORME_BACKEND_SUC_UNPUBL_FORM',' Form(s) successfully Unpublished.');

DEFINE('_FORME_BACKEND_DEL_FORM',' Form(s) successfully Deleted.');
DEFINE('_FORME_BACKEND_FORM_NAME_EMPTY',' Please type a form name.');
DEFINE('_FORME_BACKEND_FORMS_SAVE',' Form Saved.');
DEFINE('_FORME_BACKEND_FORMS_DEL',' Form(s) Deleted.');



//BACKEND COPY FIELDS
DEFINE('_FORME_BACKEND_FIELDSCOPY_HEAD','Copy Fields To');
DEFINE('_FORME_BACKEND_FIELDSCOPY_TITLE','Copy %s to: <br/>');
DEFINE('_FORME_BACKEND_FIELDSCOPY_NONE','Please select at least a field.');
DEFINE('_FORME_BACKEND_FIELDSCOPY_DONE','Fields Copied.');

//BACKEND COPY FORMS
DEFINE('_FORME_BACKEND_FORMSSCOPY_DONE','Forms Copied.');
DEFINE('_FORME_BACKEND_FORMSSCOPY_NONE','Please select at least a form.');

//BACKEND EDIT FIELD
DEFINE('_FORME_BACKEND_EDITFIELD_PREVIEW','Field preview');
DEFINE('_FORME_BACKEND_EDITFIELD_FORM_PREVIEW','Form preview');
DEFINE('_FORME_BACKEND_EDITFIELD_SUPPORT','Field Notes');
DEFINE('_FORME_EDITFIELD_ERROR_NAME','Field ID missing.');

DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_NAME_DESC','This is the field identifier. Use only letters for this. No spaces or other special characters.');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_TITLE_DESC','This is the field Caption.');
DEFINE('_FORME_BACKEND_EDITFIELD_DESCRIPTION','Description');
DEFINE('_FORME_BACKEND_EDITFIELD_DESCRIPTION_DESC','Here you can insert additional info explaining the field. It will come out on the right side of the field.');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION','Validation');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_DESC','Validation rule for your field if any.');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_MESSAGE','Validation Message:');
DEFINE('_FORME_BACKEND_EDITFIELD_DEFAULT','Default value');
DEFINE('_FORME_BACKEND_EDITFIELD_DEFAULT_DESC','This is the default field value. ');
DEFINE('_FORME_BACKEND_EDITFORMS_FIELD_TYPE_DESC','What type of field you want to add.');
DEFINE('_FORME_BACKEND_EDITFIELD_PARAMS','Additional attributes');
DEFINE('_FORME_BACKEND_EDITFIELD_PARAMS_DESC','You can add here additional field attributes such as &laquo;<strong>style="width:100%;"</strong>&raquo; or &laquo;<strong>onclick="doSomething();"</strong>&raquo;');
DEFINE('_FORME_BACKEND_EDITFIELD_FIELDSTYLE','Field Style<br/><font color="red">Experts Only</font>');
DEFINE('_FORME_BACKEND_EDITFIELD_FIELDSTYLE_DESC','You can alter the default form field style.<br/><font color="red">In order to make your form work properly, make sure you have the following code in your field style:<br/>
'.'...yourcontent...{field}...yourcontent...<br/></font<br/>
If your form is not working anymore, just delete all the code from the Form Style field and the Field Style , and save the field. (this way it will return to it\'s default value)');

DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_NONE','--none--');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_EMAIL','email');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_NUMBER','numeric(0-9)');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHANUM','alphanumeric(0-9,a-z,A-Z)');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHA','alpha(a-z,A-Z)');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_MANDATORY','mandatory');

DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_EMAIL_MESS','%s is not a valid e-mail address.');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_NUMBER_MESS','%s is not a number.');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHANUM_MESS','%s must contain only 0-9,a-z,A-Z characters');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_ALPHA_MESS','%s must contain only a-z,A-Z characters');
DEFINE('_FORME_BACKEND_EDITFIELD_VALIDATION_MANDATORY_MESS','Please add a value for %s.');


//BACKEND EDIT FIELD DESCRIPTION MESSAGES
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_TEXT','Adds a Text Input Field<br/>Add as Default Value the value you want to be displayed by default in this text field.<br/>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_PASSWORD','Adds a Password Input Field<br/>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_RADIO','Adds a Group of Radio buttons<br/>Add as Default Value the value|Description of the radio buttons separated by coma(,). <br/>Example: <strong>radio1|First Description,radio2|Second Description,radio3|Third Description</strong><br/>If you want a default selected Radio, add {checked} after the value of the radio like this: <br/><strong>radio1|First Description,radio2{checked}|Second Description,radio3|Third Description</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_CHECKBOX','Adds a Group of Checkboxes<br/>Add as Default Value the value|Description of the check boxes separated by coma(,). <br/>Example: <strong>check1|First Description,check2|Second Description,check3|Third Description</strong><br/>If you want default selected Checkboxes, add {checked} after the value of the Checkbox like this: <br/><strong>check1{checked}|First Description,check2{checked}|Second Description,check3|Third Description</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_CALENDAR','Adds a Calendar Input. <br/>Add as Default Value the date format.<br/>Keys: <br/>m - 1..12<br/>M - Jan..Dec<br/>mm - 01..12<br/>d - 1..31<br/>dd - 01..31<br/>D - Mon - Sun<br/>y - xxxx<br/>Example: <strong>m/d/y</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_TEXTAREA','Adds a Textarea Field.<br/>Add as Default Value the text you want to be displayed by default in the textarea(if any).<br/>Add as Additional Attributes, the cols and rows parameters of the textarea.<br/> Example: <strong> Additional Attributes: cols="70" rows="10"</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_SELECT','Adds a Select Box.<br/>Add as Default Value the value|Description of the options separated by coma(,).<br/>Example: <strong>value1|Description 1,value2|Description 2,value3|Description 3</strong>.<br/> Add as Additional Attributes <strong>multiple</strong> if you want to enable multiple choices, and <strong>size="10"</strong> to make the Multiple Select Box 10 options long.');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_BUTTON','Adds a Normal Button(not submit)<br/>Add as Default Value the label you want to see on your button<br/>Example: <strong>Open Popup</strong><br/>Add as Additional Attributes the javascript function you want to call on click(if any): <strong> onclick="window.open(\'popup.html\',\'\',\'width=700,height=400\')";</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_SUBMIT_BUTTON','Adds a Form Submit Button. <br/>Add as Default Value the label you want to see on your submit button<br/>Example: <strong>Submit Form</submit>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_RESET_BUTTON','Adds a Form Reset Button. <br/>Add as Default Value the label you want to see on your Reset button<br/>Example: <strong>Reset Form</submit>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_IMAGE_BUTTON','Adds an Image Submit Button.<br/>Add as Default Value the url to your image.<br/>Example: <strong>http://www.rsjoomla.com/images/stories/formelogo.gif</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_FILE_UPLOAD','Adds a File Upload Field.<br/>Add as Default Value the file types accepted. Use the <a href="components/com_forme/help/mimetype.html" target="_blank">mimetypes table</a> to find what types you want to grant.<br/>Be sure to add ALL the types for a certain format. <br/> Example for jpeg and gif: <strong>image/jpeg,image/pjpeg,image/gif</strong><br/>If you want to limit the file size, add to the default value the following syntax <strong>image/jpeg,image/pjpeg,image/gif,size/500</strong>. This will limit the uploads to 500K(kilobytes). Note that php limits by default uploads to 2MB.');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_HIDDEN','Adds a Hidden Input Field.<br/>Add as Default Value the value you want to see when the form is submitted.<br/>Example: <strong>Value 1</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_FREE_TEXT','Adds a Free Text Label. This is not a field, therefore will not be saved.<br/>Add as Default Value the content you want to display. <br/>Example: <strong> &lt;h3&gt;This is a new section of the form&lt;/h3&gt;</strong>');
DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_TICKET_NUMBER','Adds a Hidden Input Field which generates a random number/character string. <br/>Add as Default Value the Length of the Ticket Number.<br/>This can be used for Ticket Number Applications, to keep track of the Client Request<br/>Example: <strong>10</strong> will generate something like this <strong>KAS48S93LS</strong>');

DEFINE('_FORME_BACKEND_EDITFIELD_TYPE_DESC_CAPTCHA','Adds a Captcha Challenge Field. <br/>This is used for spam protection. <br/>When someone fills the form, he has to add the random generated letters.<br/>This field is not saved in your data table. It is used for antispam purposes only.');

DEFINE('_FORME_BACKEND_SUC_PUBL_FIELD',' Field(s) successfully Published.');
DEFINE('_FORME_BACKEND_SUC_UNPUBL_FIELD',' Field(s) successfully Unpublished.');

DEFINE('_FORME_BACKEND_FIELDS_SAVE',' Field(s) saved.');
DEFINE('_FORME_BACKEND_FIELDS_NAME_EMPTY',' Please type a filed name.');

DEFINE('_FORME_BACKEND_FIELDS_DEL',' Field(s) Deleted.');


//BACKEND LIST DATA
DEFINE('_FORME_BACKEND_LISTDATA_LIST_DATA','::List Data::');
DEFINE('_FORME_BACKEND_LISTDATA_LIMIT','Page limit:');
DEFINE('_FORME_BACKEND_LISTDATA_USERNAME','User');
DEFINE('_FORME_BACKEND_LISTDATA_USERIP','Ip');
DEFINE('_FORME_BACKEND_LISTDATA_DADDED','Date Added');
DEFINE('_FORME_BACKEND_LISTDATA_DELETE','Delete');
DEFINE('_FORME_BACKEND_LISTDATA_FORMS','Select Form');

DEFINE('_FORME_BACKEND_DATA_DEL',' Rows deleted');


//FRONTEND THANKYOU
DEFINE('_FORME_FRONTEND_THANKYOU_BUTTON','Continue');

//FRONTEND PROCESSFORM
DEFINE('_FORME_FRONTEND_REGISTRA_NUMERIC','%s must be numeric');
DEFINE('_FORME_FRONTEND_REGISTRA_SIZE','File size exceeds limit. Max %s KB.');
DEFINE('_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY','%s cannot be empty');
DEFINE('_FORME_FRONTEND_REGISTRA_FILE_CANNOT_EMPTY','Please upload a file');
DEFINE('_FORME_FRONTEND_REGISTRA_ALPHANUMERIC','%s must be alphanumeric');
DEFINE('_FORME_FRONTEND_REGISTRA_EMAIL','Please enter a valid e-mail address.');
DEFINE('_FORME_FRONTEND_REGISTRA_ALPHA','%s must contain only a-z, A-Z characters');
DEFINE('_FORME_FRONTEND_REGISTRA_CAPTCHA','Please enter the 4 letter security code you see in the box.');
DEFINE('_FORME_FRONTEND_REGISTRA_SUCCESS','The form has been submitted successfully. Thank you!');

DEFINE('_FORME_FRONTEND_REGISTRA_NOT_ALLOWED','This file format is not allowed for upload.');
DEFINE('_FORME_FRONTEND_REGISTRA_NOT_POSSIBLE',' Could not upload the file.');

DEFINE('_FORME_FRONTEND_EMAIL_SUBJECT','Email Contact');
?>