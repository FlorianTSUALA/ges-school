<?php

namespace Core\Table;

use App\Model\DBTable;
use PDO;

use Exception;
use Core\Routing\URL;
use IteratorIterator;
use Core\Table\SQLTraits\Find;
use Core\Table\SQLTraits\Delete;
use Core\Table\SQLTraits\Insert;
use Core\Table\SQLTraits\Update;

use function Core\Helper\dd;

/**
* Classe mère de tous les appels à la bd
*/
trait Table 
{
	use Find, Update, Insert, Delete;

	
	
	 /**
	 * Appelle tous les éléments du modèle passé en paramètre
	 * 
	 * @return array Tableau avec tous les éléments à renvoyer
	 */
	public function allArray() {
		return $this->query('SELECT * FROM ' . $this->table);
	}
    
    /**
	 * Appelle tous les éléments du modèle passé en paramètre
	 * 
	 * @return array Tableau avec tous les objets à renvoyer
	 */
	

	public function toObject($data) {
		return json_decode(json_encode($data));
	}


	public function id(string $code, string $field="code") {
		$id = $this->query('SELECT id FROM ' . $this->table . ' WHERE '.$field.'=? LIMIT 1', array($code), true);
		return ($id == false)? $id : $id->id;
	}

	public static function getId(string $table, string $code, string $field="code") {
		$id = DBTable::getModel($table)->select(['id'])->find($code, $field)['id'];
		return $id;
	}

	public function code(string $id, string $field="id") {
		$entity = $this->query('SELECT code FROM ' . $this->table . ' WHERE '.$field.'=? LIMIT 1', array($id), true);
		return  ($entity == false)? $entity : $entity->code;
	}

	public function all() {
		return json_decode(json_encode($this->query('SELECT * FROM ' . $this->table))) ;
	}
	
	public function where_2(string $field, string $value) {
		return $this->query('SELECT * FROM ' . $this->table . ' WHERE '.$field.'=?', array($value), true)[0];
	}

	public function where_3(string $field, string $comparator, string $value) {
		return $this->query('SELECT * FROM ' . $this->table . ' WHERE '.$field.'=?', array($value), true)[0];
	}

	public function lastItem(string $field="id") {
		return $this->query('SELECT '.$field.' FROM ' . $this->table . ' ORDER BY DESC LIMIT 1', array($field), true)[0];
	}

	public function exists(string $code, string $field="code") {
		return ($this->query('SELECT id FROM ' . $this->table . ' WHERE '.$field.'=?', array($code), true)[0] != null);
	}

	/**
	 * Lance la méthode query ou prepare de Database selon les paramètres qu'elle reçoit
	 * 
	 * @param string $statement Ligne de code SQL qui gère la requête
	 * @param array $attributes = [] Tableau des données pour récupérer l'Entity
	 * @param bool $onlyOne = false Indique si on souhaite un ou plusieurs éléments
	 * @return object PDOStatement
	 */
	public function query(string $statement, array $attributes = [], bool $onlyOne = false) {
		if (empty($attributes)) {
			return $this->db->query($statement, $this->entity, $onlyOne);
		} else {
			return $this->db->prepareSQL($statement, $attributes, $this->entity, $onlyOne);
		}
		
	}

	public function paginate($current_page, $per_page = 6){
		try {

			// Find out how many items are in the table
			$total = $this->query(' SELECT COUNT(*) FROM '.$this->table)->fetchColumn();
		
			// How many items to list per page
			$limit = $per_page;
		
			// How many pages will there be
			$pages = ceil($total / $limit);
		
			// What page are we currently on?
			$page = min($pages, $current_page);
		
			// Calculate the offset for the query
			$offset = ($page - 1)  * $limit;
		
			// Some information to display to the user
			$start = $offset + 1;
			$end = min(($offset + $limit), $total);
		
			// The "back" link
			$prevlink = ($page > 1) ? '<a href="'.URL::link("page=1").'" title="1 er page">&laquo;</a> <a href="'.URL::link("page='. ($page - 1) . '").'" title="Page suivante">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
			// $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
		
			// The "forward" link
			$nextlink = ($page < $pages) ? '<a href="'.URL::link("page='. ($page + 1) . '").'" title="Page suivante">&rsaquo;</a> <a href="'.URL::link("page='. $pages . '").'" title="Derniere page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
			// $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
		
			// Display the paging information
			//TEMPLATE OF PAGE INFORMATION
			echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
		
			// Prepare the paged query
			$stmt = $this->db->prepare('
				SELECT
					*
				FROM
					table
				ORDER BY
					name
				LIMIT
					:limit
				OFFSET
					:offset
			');
		
			// Bind the query params
			$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
			$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
			$stmt->execute();
		
			// Do we have any results?
			if ($stmt->rowCount() > 0) {
				// Define how we want to fetch the results
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$iterator = new IteratorIterator($stmt);
		
				// Display the results
				//TEMPLATE OF RESULT
				foreach ($iterator as $row) {
					echo '<p>', $row['name'], '</p>';
				}
		
			} else {
				echo '<p>No results could be displayed.</p>';
			}
		
		} catch (Exception $e) {
			echo '<p>', $e->getMessage(), '</p>';
		}
	}



	private function get_pdo_type($value)
    {
        switch (true) {
            case is_bool($value):
                $dataType = PDO::PARAM_BOOL;
                break;
            case is_int($value):
                $dataType = PDO::PARAM_INT;
                break;
            case is_null($value):
                $dataType = PDO::PARAM_NULL;
                break;
            default:
                $dataType = PDO::PARAM_STR;
        }
        return $dataType;
	}

    public function UniqCode($prefix="ZX",$length=8)
    {
        return substr(strtoupper(uniqid($prefix)), 0, $length);
    }
}