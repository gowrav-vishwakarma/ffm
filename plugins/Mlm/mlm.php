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

class plgMlmMlm extends JPlugin {
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for
     * plugins because func_get_args ( void ) returns a copy of all passed arguments
     * NOT references. This causes problems with cross-referencing necessary for the
     * observer design pattern.
     */
    var $_plugin;
    var $_params;
    
    function plgmlmmlm(&$subject) {
        parent::__construct($subject);
       
// load plugin parameters
        $this->_plugin = JPluginHelper::getPlugin('Mlm', 'mlm');
        $this->_params = new JParameter($this->_plugin->params);
        
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

    function onxmlmNewJoining(&$cd) {
        global $mainframe;
//        $emsg = "Someone has flagged your shout/post on shoutnlove.com <br/> your shout which was flagged was <br/>" . $s->Shout;
//        $sms = "Some one has flagged your shout/post on shoutnlove.com";
        if ($this->_params->get("send_email") == "1") {
            $this->sendemail($s->creator->email,$sms ,$emsg);
        }
        if ($this->_params->get("send_sms") == "1") {
            $this->sendsms($s->creator->detail->CurrentMobileNo,$sms);
        }
//        echo $cd->detail->Name;
        return true;
    }

    

}