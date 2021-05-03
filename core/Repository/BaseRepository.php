<?php

namespace Core\Repository;

use Core\BaseApp;
use Core\Model\Model;
use Core\Database\HydrahonDatabase;

abstract class BaseRepository extends HydrahonDatabase
{

    /** @var String $viewPath Chemin par défaut des vues */
    protected $model;

    //Check if BaseApp or App
    public function __construct() {
        $this->db = BaseApp::getDBInstance();
    }

    
	public function execute(string $statement, array $attributes = [], bool $onlyOne = false, $className = null) {
		
		if($className instanceof Model)
			$className = null;
		if (empty($attributes)) {
			return $this->query($statement, $className, $onlyOne);
		} else {
			return $this->prepareSQL($statement, $attributes, $className, $onlyOne);
		}
	}

}