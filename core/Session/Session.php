<?php

namespace Core\Session;

use App\Helpers\S;

class Session
{

    public function __construct()
    {
        //check if session start
        //clean session

    }

	
    public  function __call($method, $arguments) {
		switch($method){
			case 'has':
				if(count($arguments) == 1) {
					return call_user_func_array(array($this, '_has_1'), $arguments);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array($this, '_has_2'), $arguments);
				}
				else if(count($arguments) == 3) {
					return call_user_func_array(array($this, '_has_3'), $arguments);
				}
            break;
            
			case 'get':
				if(count($arguments) == 1) {
					return call_user_func_array(array($this,'_get_1'), $arguments);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array($this,'_get_2'), $arguments);
				}
			break;

			case 'flush':
				if(count($arguments) == 1) {
					return call_user_func_array(array($this,'_flush_1'), $arguments);
				}
				else if(count($arguments) == 3) {
					return call_user_func_array(array($this,'_flush_3'), $arguments);
				}
			break;

			default:
		}
    }

    public static function __callStatic($method, $arguments) {
        //return call_user_func_array(array('Core\Session\Session', '_table'), $arguments);
        switch($method){
			case 'has':
				if(count($arguments) == 1) {
					return call_user_func_array(array('Core\Session\Session', '_has_1'), []);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array('Core\Session\Session', '_has_2'), $arguments);
				}
				else if(count($arguments) == 3) {
					return call_user_func_array(array('Core\Session\Session', '_has_3'), $arguments);
				}
            break;
            
			case 'get':
				if(count($arguments) == 1) {
					return call_user_func_array(array('Core\Session\Session','_get_1'), $arguments);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array('Core\Session\Session','_get_2'), $arguments);
				}
			break;

			case 'flush':
				if(count($arguments) == 1) {
					return call_user_func_array(array('Core\Session\Session','_flush_1'), $arguments);
				}
				else if(count($arguments) == 3) {
					return call_user_func_array(array('Core\Session\Session','_flush_3'), $arguments);
				}
			break;

			default:
		}
    } 


    public function checkIfActive(){
        if (isset($_SESSION[S::LAST_ACTIVITY]) && (time() - $_SESSION[S::LAST_ACTIVITY] > APP_SESSION_TIME_OUT)) {
            // request 30 minates ago
            session_destroy();
            session_unset();
            return false;
        }
        $_SESSION[S::LAST_ACTIVITY] = time(); // update last activity time
        return true;
    }

    public function flash($message, $type = S::FLASH_INFO){
        $_SESSION[S::FLASH_TAG][S::FLASH_TYPE] = $type;
        $_SESSION[S::FLASH_TAG][S::FLASH_MESSAGE] = $message;
    }

    public function _flush_1($tag){
        $data = $_SESSION[$tag];
        unset($_SESSION[$tag]);
        return $data;
    }

    //Vide l'ensemble du table association taggé par $tag en retournant le taget
    public function _flush_2($tag, $target){
        $msg = $_SESSION[$tag][$target];
        unset($_SESSION[$tag]);
        return $msg;
    }

    public function _has_1($tag){
        return (isset($_SESSION[$tag]));
    }

    public function _has_3($tag, $tag_type, $type){
        return (isset($_SESSION[$tag]) && $_SESSION[$tag][$tag_type] == $type);
    }

    public function _has_2($tag, $tag_type){
        return (isset($_SESSION[$tag]) && isset($_SESSION[$tag][$tag_type]));
    }

	//recupere le contenu des variables de session
    public static function _get_1($tag){
        return $_SESSION[$tag]??null;
    }

    public function _get_2($tag, $tag_type){
        return $_SESSION[$tag][$tag_type]??null;
    }

    public function add($tag, $value){
        return $_SESSION[$tag] = $value;
    }


}