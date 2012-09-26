<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//include TXParameters Helper class.
include_once(LIB_PATH.'php/tx.param.helper.php');

class TXTemplateHelper extends TXParametersHelper{
    
    var $_tpl = null;
    var $template = '';
    var $doc;
    var $browser = array();
    
    //Active parameters set
    public $temParams = array();
    
    public function __construct($template){
        parent::__construct();
        $this->_tpl = $template;
        $this->template = $template->template;
        
        $this->doc= &JFactory::getDocument();
        
        // ie browser
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER) && preg_match('/(MSIE\\s?([\\d\\.]+))/', $_SERVER['HTTP_USER_AGENT'], $matches)) {
            $this->browser['ie7'] = intval($matches[2]) == 7;
            $this->browser['ie6'] = intval($matches[2]) == 6;
        }                
    }    
    
    
   /****************************************
    *       Get all font properties 
    ****************************************/  
    public function getFonts(){
        $this->setFonts();
       return $this->arrayToObject($this->temParams['fonts']) ; 
        
    }
    /****************************************
    *    Set all font propertins in array 
    ****************************************/ 
    private function setFonts(){
        $fontsLib= $this->get('fontLibrary');
        $this->temParams['fonts']= array(
            'lib'=>$fontsLib, 
            'name'=>$this->get('fontLibrary-'.$fontsLib.'-Fonts'),
            'for'=>$this->get('fontLibrary-'.$fontsLib.'-Fonts-for')
        );
    }
    
    /****************************************
    *        Get Custom Style 
    ****************************************/ 
    public function getCustomStyle(){
        $this->setCustomStyle();
        return $this->arrayToObject($this->temParams['style']);     
    }
    /****************************************
    *       Set all Custom Template style 
    ****************************************/ 
    private function setCustomStyle(){
        $style= $this->get('tempStyle');
        $this->temParams['style']= array(
            'bg'=>$this->get('tempStyle-'.$style.'-background'),
            'featureTitle'=>$this->get('tempStyle-'.$style.'-featureTitleColor'),
            'featureText'=>$this->get('tempStyle-'.$style.'-featureTextColor'),
            'featureLink'=>$this->get('tempStyle-'.$style.'-featureLinkColor'),
            'h1'=>$this->get('tempStyle-'.$style.'-h1'),
            'bodyText'=>$this->get('tempStyle-'.$style.'-bodyTextColor'),
            'bodyLink'=>$this->get('tempStyle-'.$style.'-bodyLinkColor')
        );
        return $this->temParams['style'];
        
    }
    /****************************************
    *    Prepear and load all css style. 
    ****************************************/ 
    public function prepareCss($prop='',$val=''){
        $css ='';
        if($this->get('tempStyle')=='custom'){
            $style= $this->getCustomStyle();    
            $css.= '#tx-feature h2{ color: '.$style->featureTitle.';}'.'#tx-feature p {color: '.$style->featureText.';}'
            .'#tx-feature a{color: '.$style->featureLink.';}'.'h1{color: '.$style->h1.';}'.'#tx-mainbody p{color: '.$style->bodyText.';}'
            .'#tx-mainbody a{color: '.$style->bodyLink.';}';
        }
        if($prop!=NULL){
            $css.= $prop.'{font-family:'.str_replace('+',' ',$val).'!important;}';
        }
        
        return $css;
    }
    public function loadCss(){
        $this->doc->addStyleSheet($this->templateUrl().'/css/base.css');
        //if get custom css style then prepear css else load preset styles file.
        if($this->get('tempStyle')=='custom') $this->doc->addStyleDeclaration($this->prepareCss()) ;
        //loading preset style file located on css/styles folder
        if(isset($_SESSION['tempStyle']) && $_SESSION['tempStyle']!=NULL) $this->doc->addStyleSheet($this->templateUrl().'/css/styles/'.$_SESSION['tempStyle'].'.css');
        else $this->doc->addStyleSheet($this->templateUrl().'/css/styles/'.$this->get('tempStyle').'.css');
        
        $font= $this->getFonts();
        if($font->lib=='google'){
            $this->doc->addStyleSheet("http://fonts.googleapis.com/css?family={$font->name}");
            $this->doc->addStyleDeclaration($this->prepareCss($font->for,$font->name));       
        }
        elseif($font->lib=='custom'){
            $this->doc->addStyleDeclaration($this->prepareCss($font->for,$font->name));       
        }
        if ($this->isIe(7)) {
            $this->doc->addStyleSheet($this->templateUrl().'/css/iehacks.css');
            $this->doc->addStyleSheet($this->templateUrl().'/css/ie7.css');
        }
    }
    
    /****************************************
    *      Prepear and load all js style. 
    ****************************************/ 
    public function loadJs(){        
        $this->doc->addScript($this->templateUrl().'/lib/js/moomenu.js');
        if($this->get('jquery')){
            $this->doc->addScript($this->templateUrl().'/lib/js/jquery-1.4.2.js');    
            $this->doc->addScript($this->templateUrl().'/lib/js/jq-noconflict.js');    
        }
        
        $this->doc->addScript($this->templateUrl().'/lib/js/script.js');
        $font= $this->getFonts();
        if($font->lib=='cufon'){
            $this->doc->addScript($this->templateUrl().'/lib/js/cufon.js');
            $this->doc->addScript($this->templateUrl().'/js/'.$font->name.'.js');
            $this->doc->addScriptDeclaration($this->prepareJs($font->for,$font->name));
        }
        
    }
    
    public function prepareJs($prop='', $val=''){
        if($prop!=NULL){
            $js = "Cufon.replace('$prop', { fontFamily: '$val' });";
            return $js;
        }
    }
    
    public function getLayoutOption(){
        $this->setLayout();
        return $this->arrayToObject($this->temParams['layout']);  
        
    }
    
    private function setLayout(){
        $this->temParams['layout'] = array(
            'position'=>$this->get('layoutOption'),
            'leftGrid'=>$this->get('leftGrid'),
            'mainGrid'=>$this->get('mainGrid'),
            'rightGrid'=>$this->get('rightGrid'),
        );
        
    }
    /****************************************
    *          take a array and return
    *           as object 
    ****************************************/ 
    public function arrayToObject($array){
        $obj = new stdClass();
        if(is_array($array)){
            foreach($array as $key=>$val){
                if(!empty($key)){
                    $obj->$key = $val;
                }
            }
            return $obj;            
        }
        //return $array[0];        
    }
    
    /* Browser */
    public function isIe($version) {
        if (array_key_exists('ie'.$version, $this->browser)) {
            return $this->browser['ie'.$version];
        }
        return false;
    }
    public function baseUrl(){
        return JURI::base();
    }

    public function templateUrl(){
        return JURI::base()."templates/".$this->template;
    }

    public function basePath(){
        return JPATH_SITE;
    }

    public function templatePath(){
        return $this->basepath().DS."templates".DS.$this->template;
    }
    
    public function isFrontPage(){
        return (JRequest::getCmd( 'view' ) == 'frontpage') ;
    }

    public function sitename() {
        $config = new JConfig();
        return $config->sitename;
    }
    
    public function isContentEdit() {
        return (JRequest::getCmd( 'option' )=='com_content' && JRequest::getCmd( 'view' ) == 'article' && (JRequest::getCmd( 'task' ) == 'edit' || JRequest::getCmd( 'layout' ) == 'form'));
    }
    
    
    public function getLayout(){
        $layouts = $this->get('layoutOption');        
        $ayouts = str_replace ("<br />", "\n", $layouts);        
        if($layoutPath= $this->layout_exists($layouts)){
            return $layoutPath;
        }
    }
    
    //load tempalte layouat
    public function load($layout){
        return include($layout);
    }
    
    private function layout_exists ($layout) {
        //echo $layout;
        $layoutpath = $this->templatepath().DS.'layouts';
        if(is_file ($layoutpath.DS.$layout.'.php')) return $layoutpath.DS.$layout.'.php';
        return false;
    }
    
    public function setLayoutGrid(){
        $this->getLayoutOption();
        //$doc= &JFactory::getDocument();
        $grid = array();
        if(!$this->doc->countModules('left') && !$this->doc->countModules('right')){
            $grid['main']= $this->temParams['layout']['leftGrid']+$this->temParams['layout']['mainGrid']+$this->temParams['layout']['rightGrid'];   
            //$grid['left']= 0;
            //$grid['right']= 0;
        }
        elseif(!$this->doc->countModules('left')){
            $grid['main']= $this->temParams['layout']['leftGrid']+$this->temParams['layout']['mainGrid'];
            //$grid['left']= 0;
            $grid['right']= $this->temParams['layout']['rightGrid'];
            
        }
        elseif(!$this->doc->countModules('right')){
            $grid['main']= $this->temParams['layout']['rightGrid']+$this->temParams['layout']['mainGrid'];
            //$grid['right']= 0;
            $grid['left']= $this->temParams['layout']['leftGrid'];
        }
        else{
            $grid['main']= $this->temParams['layout']['mainGrid'];
            $grid['left']= $this->temParams['layout']['leftGrid'];
            $grid['right']= $this->temParams['layout']['rightGrid'];
        }
      return $grid;  
    }
   
    
    /*Receive a position name, if received position has any publist module return true or false*/
    function hasModule($position){
        if (!is_array($position)) $position = array($position);           
        if(is_array($position)){    
           $modcount=0;
           $modules=array();
           foreach($position as $key=>$val){
               if($this->doc->countModules($val)){
                 array_push($modules,$val);
                 $modcount++;
               } 
           }
           /*if no publish module return false.*/
            if($modcount==0){
                return false;
            }
           return $modules; 
        }
        
    }
    
    function renderModule($pos, $specialPos=''){
        $activeMod= $this->hasModule($pos);
        $count=1;
        $max= count($activeMod);
        
        //speacial postion grid calucation
        if($specialPos!=NULL){
            //get main layout grid
            $opt= $this->setLayoutGrid();
            $txgrid = round($opt['main']/count($activeMod));
        }
        else{
            $txgrid= 12/count($activeMod);    
        }
        
        if(is_array($activeMod)){
            $modules = array();
            foreach($activeMod as $key=>$val){
                if($count==1){
                    $modules[$count] = array(
                    'name'=>$val,
                    'grid'=>'tx-grid-'.$txgrid,
                    'extra-css'=> 'tx-alpha'
                    );  
                }
                elseif($count==$max){
                    $modules[$count] = array(
                    'name'=>$val,
                    'grid'=>'tx-grid-'.$txgrid,
                    'extra-css'=> 'tx-omega'
                    );  
                } 
                else{
                    $modules[$count] = array(
                    'name'=>$val,
                    'grid'=>'tx-grid-'.$txgrid,
                    'extra-css'=> ''
                    );  
                }
                
                $count++;
            }  
            return $modules;
        }
        return false;
    }
    
}
