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

	private static $singleton;

    public static function getInstance($par){

        if(is_null(self::$singleton)){

            self::$singleton = new $this ($par);

        }

        return self::$singleton;

    }
	
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

	
	public function getColumByTagValue($value, $tag='code', $selected_colum='id')
	{
		$item = $this->table_0()->select("$selected_colum")->where("$tag", $value)->where('visibilite', 1)->one();
		if(is_array($item))
			return $item["$selected_colum"];
		else
			return 0;
	}

    public function genCode(){
		return CodeSeqGenerator::getInstance()->uniqueCode($this->class);
	}
	
}