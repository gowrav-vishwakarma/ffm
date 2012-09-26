<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Module chrome for rendering module
 */
function modChrome_txMain($module, &$params, &$attribs){
    
    // create title
    $pos   = JString::strpos($module->title, ' ');
    $title = ($pos !== false) ? JString::substr($module->title, 0, $pos).'<span class="color">'.JString::substr($module->title, $pos).'</span>' : $module->title;
    
    $modSuffix= $params->get('moduleclass_sfx');
    
    //$suffix= explode(' ',$modSuffix);
   /* $tst= strpos($modSuffix,'header');
    echo $tst;
    $pos= strpos($modSuffix, ' ');
    echo $pos;
    */
    if(preg_match('/(header)-(.*?)\s/',$modSuffix, $match)) $headerColor= $match[2];
    if(preg_match('/(icon)-(.*?)$/',$modSuffix, $match))    $icon= $match[2];
    if(preg_match('/(badge)-(.*?)\s/',$modSuffix, $match))  $badge= $match[2];
    if(preg_match('/(color)-(.*?)\s/',$modSuffix, $match))  $color= $match[2];
    
    ?>
    <div class= "tx-block <?php echo $modSuffix ?>">
        <div class="module-encloser">
            <?php if ($module->showtitle != 0) : ?>
                <div class="module-title <?php //echo (isset($headerColor)? $headerColor:'')?>">
                    <?php if(isset($icon)): ?>
                        <span class="icon-<?php echo $icon?>"></span>
                    <?php endif;?>
                    <h3 class="title"><?php echo $title; ?></h3>                
                    <?php if(isset($badge)):?>
                        <span class="badge-<?php echo $badge;?>"></span>
                    <?php endif;?>
                    
                </div> <!--module title end-->    
            <?php endif;?>
            
            <div class="mod-content-encloser">
                <div class="module-content">
                    <?php echo $module->content; ?>    
                </div> <!--module content end-->
                <div class="clear"></div>
            </div> <!--mod-content-encloser-->
            
        </div><!--module encloser end-->
    </div> <!--tx-block end-->   
<?php }
?>