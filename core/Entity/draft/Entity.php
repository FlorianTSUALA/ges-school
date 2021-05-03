<?php

namespace Core\Entity;

/**
* Classe mère de toutes les entity
*/
class Entity
{
	/** @var string $url URL récupéré pour afficher les articles en single ou par category */
	protected $url;

	/** @var string $modifyURL URL pour la modification des Posts */
	protected $modifyURL;

	/** @var string $entity Nom de l'Entity */
	protected $entity;

	/**
	 * Initialise l'attribut entity
	 */
	public function __construct() {
		$this->entity = strtolower(str_replace('Entity', '', end(explode('\\', get_class($this)))));

		if ($this->entity === 'post') {
			$this->url = 'index.php?p=posts.show&id=' . $this->id;
		} elseif ($this->entity === 'category') {
			$this->url = 'index.php?p=posts.category&id=' . $this->id;
		}

		if ($this->entity === 'post') {
			$this->modifyURL = 'index.php?p=admin.posts.edit&id=' . $this->id;
		} elseif ($this->entity === 'category') {
			$this->modifyURL = 'index.php?p=admin.categories.edit&id=' . $this->id;
		}
	}

	/**
	 * Méthode magique pour récupérer tous les éléments avec des getters sans les écrire
	 * 
	 * @param string $key Nom de l'attribut qu'on veut récupérer
	 * @return string $this->$key qui est le getter
	 */
	public function __get(string $key) {
		$method = 'get' . ucfirst($key);
		$this->$key = $this->$method();
		return $this->$key;
	}

	/**
	 * Récupère l'id de l'élement pour en faire un URL
	 * 
	 * @return string $url Retourne l'URL de l'entity
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Getter pour l'URL de modification
	 * 
	 * @return string URL de modification
	 **/
	public function getModifyUrl()
	{
		return $this->modifyURL;
	}
}