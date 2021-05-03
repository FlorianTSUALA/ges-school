<?php

namespace Core\Session;

use App\Helpers\S;

trait FlashMessage
{
        
    
    public  function __call($method, $arguments) {
		switch($method){
			case 'table':
				if(count($arguments) == 0) {
					return call_user_func_array(array($this, 'table_0'), []);
				}
				else if(count($arguments) == 1) {
					return call_user_func_array(array($this, 'table_1'), $arguments);
				}
			break;
			case 'where':
				if(count($arguments) == 2) {
					return call_user_func_array(array($this,'where_2'), $arguments);
				}
				else if(count($arguments) == 3) {
					return call_user_func_array(array($this,'where_3'), $arguments);
				}
			break;

			case 'delete':
				if(count($arguments) == 1) {
					return call_user_func_array(array($this,'delete_default'), $arguments);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array($this,'delete_with_condition'), $arguments);
				}
			break;

			case 'find':
				if(count($arguments) == 1) {
					return call_user_func_array(array($this,'find_default'), $arguments);
				}
				else if(count($arguments) == 2) {
					return call_user_func_array(array($this,'find_with_condition'), $arguments);
				}
			break;
			
			case 'all':
				if(count($arguments) == 0) {
					return call_user_func_array(array($this,'all1'), $arguments);
				}
			break;
			default:
		}
    }

    public static function __callStatic($method, $arguments) {
		switch($method){
			case 'table':
				if(count($arguments) == 0) {
					$class_name = call_user_func_array(array('Core\Model\Model' , 'class_name'), array(__CLASS__));
					return call_user_func_array(array('Core\Model\Model' , '_table'), array($class_name));
				}
				else if(count($arguments) == 1) {
					return call_user_func_array(array('Core\Model\Model', '_table'), $arguments);
				}
			break;

			
			default:
		}
    } 


    /*
        $this->session->set_flashdata('success', 'User Updated successfully');
        $this->session->set_flashdata('error', 'Something is wrong.');
        $this->session->set_flashdata('warning', 'Something is wrong.');
        $this->session->set_flashdata('info', 'User listed bellow');
    */
    public function set_flashdata($message, $type = S::FLASH_INFO){
        $_SESSION[S::FLASH_TYPE] = $type;
        $_SESSION[S::FLASH_MESSAGE] = $message;
    }
//$request->session()->flash('success', 'Post created successfully.');

    /*
        $notification = array(
            'message' => 'Post created successfully!',
            'alert-type' => 'success'
        );
    */


    public function flash_data(){
        $msg = $_SESSION[S::FLASH_MESSAGE];
        unset($_SESSION[S::FLASH_TYPE]);
        unset($_SESSION[S::FLASH_MESSAGE]);
        return $msg;
	}
	


}