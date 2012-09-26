<?php
/**
 * @package   ZOE Template Framework by ThemExpert
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2010 ThemExpert LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * 
 * This Framework uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 * 
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//define tamplate base path
define("TEMPLATEPATH", dirname(__FILE__));
define("LIB_PATH", TEMPLATEPATH.DS.'lib'.DS);

require_once(TEMPLATEPATH.DS."config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->language; ?>">
<head>
<jdoc:include type="head" />
<?php JHTML::_('behavior.mootools'); ?>
<link rel="stylesheet" href="<?php echo $template->baseurl(); ?>templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $template->baseurl(); ?>templates/system/css/general.css" type="text/css" />

</head>

<body class="<?php echo(isset($background))? $background:'';?>">
    <div id="tx-encloser">
        <div class="tx-container">
                
        <!--Tx-roof Strat-->
        <?php if($mods= $template->renderModule($pos->roof)):?>
                <div id="tx-roof">
                    <?php foreach($mods as $mod):?>
                        <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                           <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                        </div>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </div>
            <?php endif;?>
        <!--Tx-roof End-->
            
        <!--Logo Area Start-->
            <?php if(isset($logo)):?>
                <div class="tx-grid-4">
                    <h1><a href="<?php echo $template->baseUrl();?>"><?php echo $logoText;?></a></h1>
                    <span class="slogan"> <?php echo $logoSlogan;?></span>
                    
                    <div class="clear"></div>
                </div>
            <?php else: ?>
                <h1 id="logo"><a href="<?php echo $template->baseUrl();?>"><?php echo $template->sitename();?></a></h1>
            <?php endif;?>
        <!--Logo Area End-->
        
        <?php if(isset($date) || isset($login)):?>
        <!--Tx-tools Strat-->
        <div id="tx-tools">
            <div class="tx-grid-3">
                <p class="date"><?php echo $date;?></p>
            </div>
            
            <?php if(isset($login)):?>
            <!--Login areat start-->
            <div class="login tx-grid-6">
            <?php if($this->countModules('login')):?>                    
                <span id="login_btn"><a href="#">Login</a></span>                
                
                <div id="popup_login">
                    <div id="close_button_login"></div>
                    
                    <div class="login-enclose">
                        <jdoc:include type="modules" name="login" style="txMain" />
                        <div class="clear"></div>
                    </div> <!--login enclose end-->
                </div>  <!--Popup login box end-->
                <?php endif; ?>
            </div> <!--Login div end-->
           <!-- Login area end-->
           <?php endif;?>
        <div class="clear"></div>
        </div> <!--tx-tools DIV end-->
        <?php endif;?>
        <!--Tx-tools END-->
        
        <!--Tx-Header Start-->
        <?php if($mods= $template->renderModule($pos->head)):?>
                <div id="tx-header">
                    <?php foreach($mods as $mod):?>
                        <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                           <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                        </div>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </div>
        <?php endif;?>
        <!--Tx-header end-->    
        
        <!--Mainmenu Start-->
        <?php if($mods= $template->renderModule($pos->menu)):?>
            <div id="tx-navigation">
                <?php foreach($mods as $mod):?>
                    <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                        <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                    </div>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        <?php endif;?>
        <!--Tx-top end-->
        
        <!--Tx-top Start-->
        <?php if($mods= $template->renderModule($pos->top)):?>
            <div id="tx-top">
                <?php foreach($mods as $mod):?>
                    <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                        <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                    </div>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        <?php endif;?>
        <!--Tx-top end-->    
        
        <!--Tx-Feature Start-->
        <?php if($mods= $template->renderModule($pos->feature)):?>
            <div id="tx-feature">
                <?php foreach($mods as $mod):?>
                    <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                        <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                    </div>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        <?php endif;?>
        <!--Tx-feature end-->
        
            <!--Main Body layout start-->
            <?php $layout= $template->getLayout();($layout)?include($layout):'';?>
            <!--Main body layout end-->
            
        <!--Tx-Bottom Start-->
        <?php if($mods= $template->renderModule($pos->bottom)):?>
            <div id="tx-bottom">
                <?php foreach($mods as $mod):?>
                    <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                        <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                    </div>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        <?php endif;?>
        <!--Tx-Bottom end-->
        
        <?php if($mods= $template->renderModule($pos->footer)):?>
        <!--Tx-Footer Start-->
            <div id="tx-footer">
                <?php foreach($mods as $mod):?>
                    <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                        <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                    </div>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        <!--Tx-Footer end-->
        <?php endif;?>
        
        </div> <!--Container div end-->
        
        <?php if(isset($copyright)):?>
        <!--Tx-Copyright Start-->
        <div id="tx-copyright">
            <p class="copyrightText"><?php echo $copyright; ?></p>
            <a class="scroll" href="#logo">Top</a>
        </div>
        <!--Tx-Copyright End-->
        <?php endif;?>
        
    </div> <!--Encloser div end-->
<?php if(isset($analytics)):?>    
<!-- Google Analytics Code start -->
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        try {
        var pageTracker = _gat._getTracker("UA-<?php echo $analyticsID; ?>");
        pageTracker._trackPageview();
        } catch(err) {}
    </script>        
<!-- Google Analytics code end -->
<?php endif;?>
</body>
</html>