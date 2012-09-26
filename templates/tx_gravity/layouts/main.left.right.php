<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="tx-main-enclose">
    <div id="tx-main-inner">
    <!--Tx mainContent Start-->
    <div id="tx-mainContent" class="tx-grid-<?php echo $layoutGrid['main']?>">
        <!--Content Top Strat-->
        <?php if($mods= $template->renderModule($pos->maintop,'maintop')):?>
                <div id="tx-content-top">
                    <?php foreach($mods as $mod):?>
                        <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                           <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                        </div>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </div>
            <?php endif;?>
        <!--Cotent Top End-->    
        <?php if(!isset($displayCom)) :?>
        <div id="tx-mainBody">
            <jdoc:include type="message" />
            <jdoc:include type="component" />
        </div>
        <div class="clear"></div>
        <?php endif;?>
        <!--Content bottom Strat-->
        <?php if($mods= $template->renderModule($pos->mainbottom,'mainbottom')):?>
                <div id="tx-content-bottom">
                    <?php foreach($mods as $mod):?>
                        <div class="<?php echo $mod['grid'].' '.$mod['extra-css']?>">
                           <jdoc:include type="modules" name="<?php echo $mod['name']?>" style="txMain" />
                        </div>
                    <?php endforeach;?>
                    <div class="clear"></div>
                </div>
            <?php endif;?>
        <!--Cotent bottom End-->    
        
    </div> 
    <!--Tx mainContent End-->

    <!--Tx left block start-->
    <?php if($this->countModules('left')):?>
    <div id="tx-left" class="tx-grid-<?php echo $layoutGrid['left']?>">
        <jdoc:include type="modules" name="left" style="txMain" />
        
        <div class="clear"></div>
    </div>
    <?php endif;?>
    <!--Tx left block end-->
        
    <!--tx Right start-->
    <?php if($this->countModules('right')):?>
    <div id="tx-right" class="tx-grid-<?php echo $layoutGrid['right']?>">
        <jdoc:include type="modules" name="right" style="txMain" />
        
        <div class="clear"></div>
    </div>
    <?php endif;?>
    <!--tx Right start-->
    <div class="clear"></div>
    </div> <!--Tx main inner end-->
    <div class="clear"></div>
</div> <!--Tx Main enclose div end-->