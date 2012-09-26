<?php

/**
 * @version		$Id: example.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.event.plugin');

class plgSnlSnl extends JPlugin {
    var $fbsession;
    var $fbme;
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for
     * plugins because func_get_args ( void ) returns a copy of all passed arguments
     * NOT references. This causes problems with cross-referencing necessary for the
     * observer design pattern.
     */
    function plgsnlsnl(&$subject) {
        parent::__construct($subject);
        global $fbsession;
        global $fbme;
// load plugin parameters
        $this->_plugin = JPluginHelper::getPlugin('snl', 'snl');
        $this->_params = new JParameter($this->_plugin->params);
        $this->fbsession=$fbsession;
        $this->me=$fbme;
    }

    function sendemail($to, $subject, $body) {
//        $x=10;
//        return;
        $config = & JFactory::getConfig();
        $sender = array(
            $config->getValue('config.mailfrom'),
            $config->getValue('config.fromname'));

        $mailer = JFactory::getMailer();
        $mailer->setSender($sender);
        $mailer->addRecipient($to);
        $mailer->setSubject($subject);
        $mailer->setBody($body);
        $mailer->isHTML(true);
        if(!$mailer->send())
                echo $mailer->ErrorInfo;
    }

    function sendsms($to,$sms){
        return;
    }

    /**
     * Plugin method with the same name as the event will be called automatically.
     */

    function onxFlaged(&$s) {
        global $mainframe;
        $emsg = "Someone has flagged your shout/post on shoutnlove.com <br/> your shout which was flagged was <br/>" . $s->Shout;
        $sms = "Some one has flagged your shout/post on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($s->creator->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($s->creator->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxVoted(&$s){
        global $mainframe;
        $emsg = "Someone has voted your shout/post on shoutnlove.com <br/> your shout which was voted was <br/>" . $s->Shout;
        $sms = "Some one has voted your shout/post on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($s->creator->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($s->creator->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxCommented(&$s){
        global $mainframe;
        $emsg = getNameOfShouter($s). " has Commented on your shout/post on shoutnlove.com <br/> your shout or post which was commented was <br/>" . $s->Shout;
        $sms = getNameOfShouter($s). " has commented your shout/post on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($s->commentto->creator->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($s->creator->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxWallPost(&$s){
        global $mainframe;
        $emsg = getNameOfShouter($s). " has Posted on your wall on shoutnlove.com and said ..<br/> " . $s->Shout;
        $sms = getNameOfShouter($s). " has Posted on your wall on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($s->postfor->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($s->postfor->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxMessageSend(&$ml){
        global $mainframe;
        if($ml->DiscloseSender == 1){
            $name=$ml->sender->detail->FirstName;
        }else{
            $name="Someone";
        }
        $emsg = $name. " has sent you a message on shoutnlove.com as comment to <br/> " . $ml->Message;
        $sms = $name. " has sent you a message on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($ml->receiver->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($ml->receiver->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxFriendRequestSent(&$m, &$f){
        global $mainframe;
        $emsg = $m->detail->FirstName. " has sent you a friend request on shoutnlove.com ";
        $sms = $m->detail->FirstName. " has sent you a friend request on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($f->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($f->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxFriendRequestApproved(&$m,&$f){
        global $mainframe;
        $emsg = $m->detail->FirstName. " has accepetd your a friend request on shoutnlove.com ";
        $sms = $m->detail->FirstName. " has accepted your a friend request on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($f->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($f->detail->CurrentMobileNo,$sms);
        }
        return true;
    }

    function onxTargetCreated(&$t){
        global $mainframe;
        $emsg = $t->FirstName. " your target has been created on shoutnlove.com ";
        $sms = $t->FirstName. " your target has been created on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($t->Emails,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($t->ContactNumbers,$sms);
        }
        return true;
    }

}
