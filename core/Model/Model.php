<?php

namespace Core\Model;

use Core\BaseApp;
use Core\Table\Table;
use App\Helpers\Helpers;
use Core\Database\Builder;
use Core\Model\HydrahonModel;

use function Core\Helper\dd;
use function Core\Helper\vd;

/**
* Classe mère de tous les appels à la bd
*/
class Model 
{	
	
	use Table, HydrahonModel;
	/** @var string $table Nom de la Table en ligne */
	protected $table;

	/** @var string $class Nom de la Classe */
	protected $class;

	//Represente la classe qui permettra de caster les resultats renvoyés dans les requetes de la bd
	protected $entity;

	/** @var string $class Nom de la Classe */
	public $has_table = false;


	/** @var Object \Core\Database $db Instance de la DB */
	protected $db;
	
	public $fillables = [];

	/**
	 * Initialise le nom de la table
	 * 
	 * @param none
	 * @return none
	 */
	public function __construct($modelName = NULL) {
		$this->has_table = true;
		if($modelName == NULL)
			$this->init_table_name(get_class($this));
		else
			$this->init_table_name($modelName);

		$this->db = BaseApp::getDBInstance();
	}
	
	public static function _table($table_name) {
		// vd($table_name);
		return Builder::get()->table($table_name);
	}
	

	public function table_0() {
		if($this->table !== '' || $this->table !== null)
			return Builder::get()->table($this->table);
		return null;
	}

	public function table_1($table_name) {
		return Builder::get()->table($table_name);
	}
	
	private function init_table_name($full_class_name){
		if ($this->table === null) {
			$this->class = $this->class_name($full_class_name);
			$this->table = $this->class;
			
			//$this->table = str_replace('ry', 'rie', $this->class) . 's';
		}
		$this->table = $this->has_table? $this->table : null;
		
		return $this->table;
	}

	//Renvoie le nom de la table suivant les conventions définies
	public static function class_name($full_class_name){
			$tmp = explode('\\', $full_class_name);
			return (Helpers::toCamelCase(end($tmp)));
	}

	public function query(string $statement, array $attributes = [], bool $onlyOne = false) {
		if($this->entity instanceof Model)
			$this->entity = null;
		if (empty($attributes)) {
			return $this->db->query($statement, $this->entity, $onlyOne);
		} else {
			return $this->db->prepareSQL($statement, $attributes, $this->entity, $onlyOne);
		}
	}

    public function genCode(){
		//Sleep because we must want that date must be unique
		usleep ( 1 );// sleep 1 micro second 
		//Date('u') get current micro second
		//Date('U') get second since 1970
        return strtoupper(substr( $this->class, 0, 4)."_".Date('U').Date('u'));
	}

	public static function generateCode(){
		//Sleep because we must want that date must be unique
		usleep ( 3 );// sleep 1 micro second 
		//Date('U') get second since 1970
		//Date('u') get current micro second
        return strtoupper(substr( __CLASS__, 0, 4)."_".Date('U').Date('u'));
	}
	
}