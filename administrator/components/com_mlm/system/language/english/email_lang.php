<?php
/*------------------------------------------------------------------------
# com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
# ------------------------------------------------------------------------
# author    Xavoc International / Gowrav Vishwakarma
# copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.xavoc.com
# Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?><?php

$lang['email_must_be_array'] = "The email validation method must be passed an array.";
$lang['email_invalid_address'] = "Invalid email address: %s";
$lang['email_attachment_missing'] = "Unable to locate the following email attachment: %s";
$lang['email_attachment_unreadable'] = "Unable to open this attachment: %s";
$lang['email_no_recipients'] = "You must include recipients: To, Cc, or Bcc";
$lang['email_send_failure_phpmail'] = "Unable to send email using PHP mail().  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_sendmail'] = "Unable to send email using PHP Sendmail.  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_smtp'] = "Unable to send email using PHP SMTP.  Your server might not be configured to send mail using this method.";
$lang['email_sent'] = "Your message has been successfully sent using the following protocol: %s";
$lang['email_no_socket'] = "Unable to open a socket to Sendmail. Please check settings.";
$lang['email_no_hostname'] = "You did not specify a SMTP hostname.";
$lang['email_smtp_error'] = "The following SMTP error was encountered: %s";
$lang['email_no_smtp_unpw'] = "Error: You must assign a SMTP username and password.";
$lang['email_failed_smtp_login'] = "Failed to send AUTH LOGIN command. Error: %s";
$lang['email_smtp_auth_un'] = "Failed to authenticate username. Error: %s";
$lang['email_smtp_auth_pw'] = "Failed to authenticate password. Error: %s";
$lang['email_smtp_data_failure'] = "Unable to send data: %s";
$lang['email_exit_status'] = "Exit status code: %s";


/* End of file email_lang.php */
/* Location: ./system/language/english/email_lang.php */