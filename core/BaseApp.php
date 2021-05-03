<?php

namespace Core;

use Core\Config;
use Core\Database\Builder;
use Core\Database\Database;
use Core\Helper\BaseHelpers;

use function Core\Helper\dd;
use function Core\Helper\vd;

use Core\Database\HydrahonDatabase;

/**
 * Va stocker les informations nécessaires à plusieurs éléments de l'Application afin de les réutiliser un peu partout
 * @package App
 */
class BaseApp
{

	protected $title = 'Bienvenue aux Ges-School';
	const TEAM = 'ges-school';
	public $ORGANISATION = '';
	
	private static $_instance = null;
	private static $db_instance_mysql = null;

	/**
	 * Instancie une nouvelle connection à la bdd
	 * @param none
	 * @return none
	 */
	public function __construct() {
		$this->config = Config::getInstance(ROOT . '/config/config.php');
		$this->ORGANISATION = $this->config->get('ORGANISATION');
	}

    public  function __call($method, $arguments) {
		switch($method){
			case 'render':
				if(count($arguments) == 0) {
					return call_user_func_array(array($this, 'table_0'), []);
				}
			case 'getDBInstance':
				if(count($arguments) == 0) {
					return call_user_func_array(array($this, 'getDB'), []);
				}
			break;
			default:
		}
    }

    public static function __callStatic($method, $arguments) {
		switch($method){
			case 'render':
				if(count($arguments) == 0) {
					$class_name = call_user_func_array(array('Core\Model\Model' , 'class_name'), array(__CLASS__));
					return call_user_func_array(array('Core\Model\Model' , '_table'), array($class_name));
				}
			break;
			case 'getDBInstance':
				if(count($arguments) == 0) {
					return call_user_func_array(array('Core\BaseApp' , 'getDBStaticIntance'), []);
				}
			break;
			default:
		}
    }

	/**
	 * Envoie une instance unique de l'App pour créer un singleton
	 * @param none
	 * @return object App Renvoie l'instance unique de App
	 */
	public static function getAppInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Charge l'Autoloader afin de gérer le reste des Classes et lance une session
	 * @param none
	 * @return none
	 */
	public static function load() {
		session_start();
		require '../vendor/autoload.php';
	}

	/**
	 * Factory pour les Modèles
	 * @param string $model Nom du modèle qu'on va charger
	 * @return object Retourne le modèle demandé
	 */
	public function getModel(string $model) {
		$className = 'App\Model\\' . BaseHelpers::toPascalCase($model);
		return	new $className($model);
	}

	/**
	 * Factory pour la bdd
	 * @param none
	 * @return object Database Retourne un singleton de Database
	 */
	public static function getDBStaticIntance():Database
    {
        $config = Config::getInstance('config/config.php');
        if (self::$db_instance_mysql === null)
        {
            self::$db_instance_mysql = new HydrahonDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_host'), $config->get('db_pass'));
		}
        return self::$db_instance_mysql;
    }

	/**
	 * Factory pour la bdd
	 * @param none
	 * @return object Database Retourne un singleton de Database
	 */
	public function getDB(): Database
    {
        return self::getDBStaticIntance();
    }

	public static function table(string $model) {
		return Builder::get()->table($model);
	}

	/* Setters Getters */

	/**
	 * Renvoie le $title
	 * @param none
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Modifie le $title
	 * @param string $title Nouveau titre
	 * @return none
	 */
	public function setTitle(string $title) {
		$this->title = $title;
	}


	public static function abort($code, $message = '')
	{
		if ($code == 403) {
			header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden');
			$page = '403_forbidden';
		}

		if ($code == 404) {
			header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
			$page = '404_not_found';
		}

		if ($code == 502) {
			header($_SERVER["SERVER_PROTOCOL"].' 502 Bad Gateway ou Proxy Error');
			$page = '502_not_connexion';
		}
		exit(require (dirname (__DIR__). APP_DIR_ABORT . $page . '.php'));
	}

	/**
 	*	echo base_url(NULL, NULL, FALSE);
	*	print_r( base_url(NULL, NULL, TRUE));
	*	Default  :: public static function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE)
	* 	https://stackoverflow.com/questions/2820723/how-do-i-get-the-base-url-with-php
	*/
	public static function base_url($atRoot=NULL, $atCore=NULL, $parse=FALSE){
		if (isset($_SERVER['HTTP_HOST'])) {
			$http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$hostname = $_SERVER['HTTP_HOST'];
			$dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

			$core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
			$core = $core[0];

			$tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
			$end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
			$base_url = sprintf( $tmplt, $http, $hostname, $end );
		}
		else $base_url = 'http://localhost/';

		if ($parse) {
			$base_url = parse_url($base_url);
			if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
		}

		return $base_url;
	}

	public static function full_url(){
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
}