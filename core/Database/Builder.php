<?php

namespace Core\Database;

use Core\Config;

class Builder
{
    private static $_instance;

    private static function new_instance()
    {
        if(self::$_instance == null){
            $config = Config::getInstance("config/config.php");
            if (empty(self::$_instance))
            {
                $_db_instance_hydrahon = new HydrahonDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_host'), $config->get('db_pass'));
            }
            self::$_instance = $_db_instance_hydrahon->builder();
        }
		return self::$_instance;
    }

    public static function get(){
        return self::new_instance();
    }    
    
}