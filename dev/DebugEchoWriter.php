<?php
require_once 'Zend/Log/Writer/Abstract.php';

class DebugEchoWriter extends Zend_Log_Writer_Abstract {
    /**
     * @var DebugEchoWriter the instance
     */
    private static $instance = null;

    protected function _write($event) {
		if(is_array($event)){
			if(isset($event['message'])){
				print_r($event['message']);
			} else {
				print_r($event);
			}
		} else {
			echo $event;
		}
    }
    
    
    private function __construct() {} //singleton
    
    
    public static function factory($config = null){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

?>
