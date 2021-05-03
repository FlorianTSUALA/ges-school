<?php

namespace Core\Model;

trait HydrahonModel{
    
    
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


}