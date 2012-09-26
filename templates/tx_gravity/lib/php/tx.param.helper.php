<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
  
class TXParametersHelper {
    
    //parameters
    public $params = array();
    
    public function __construct(){
        $file= dirname(dirname(dirname(__FILE__))).DS.'params.ini'  ;
        $this->loadFile($file);
    }
    
    public function loadFile($file){
        if (is_file($file)) {
            $handle = fopen($file, 'r');
            if ($handle !== false) {
                while ($all = fgets($handle)) {
                    if (preg_match('/^#/', $all) == false) {
                        if (preg_match('/^(.*?)=(.*?)$/', $all, $matchs)) {
                            $this->params[$matchs[1]] = $matchs[2];
                        }
                    }
                }
                @fclose($handle);
            }
        }
    }
    
    public function get($key, $default=''){
        if(array_key_exists($key, $this->params)){
            return $this->params[$key];
        }
        return $default;
    }
    
    public function set($key, $value){
        $this->params[$key] = $value;
    }
    
}