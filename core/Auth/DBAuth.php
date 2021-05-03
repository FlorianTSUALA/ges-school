<?php

namespace Core\Auth;

use App\Helpers\Helpers;
use App\Helpers\S;
use App\Model\Personnel;
use Core\Database\Database;
use App\Model\DBTable;

/**
* Gère l'authentification par extraction des Users de la DB
**/
class DBAuth
{
	/** @var Object \PDO $db Connection à la DB **/
	protected $db;

	/**
	 * Initialise la connexion à la DB (injection de dépendance)
	 * @param Object \Core\Databse
	 **/
	public function __construct(Database $db) {
		$this->db = $db;
	}

	/**
	 * Permet au User de se connecter
	 * @param string $login
	 * @param string $password
	 * @return bool Selon si le User peut se connecter ou non
	 **/
	public function login(string $login, string $password) {
		$model = Personnel::table();
        $results = $model->select('type_personnel.libelle as type_personnel_id, type_personnel.code as external_target, 
                pays.libelle as pays_id, pays.code as external_target_1, 
                personnel.code as code,
                personnel.nom,
                personnel.prenom,
                personnel.sexe,
                personnel.photo,
                personnel.telephone,
                personnel.email,
                personnel.adresse,
                personnel.login,
                personnel.password,
                personnel.date_prise_service,
                personnel.date_fin_carriere,
                personnel.bibliographie')
            ->where('personnel.visibilite', 1)
            ->where('personnel.login', $login)
            ->join('type_personnel', 'personnel.type_personnel_id', '=', 'type_personnel.id')
            ->join('pays', 'personnel.pays_id', '=', 'pays.id')->one();
       

		$user =  (object)($results);
		
		if ($user) {
			if ( isset($user->password) && ($user->password === Helpers::passwordEncrypt($password)) ) {
				$_SESSION['auth'] = $user->code;
				$_SESSION[S::PERS_CODE] = $user->code;
				$_SESSION[S::PERS_TYPE_PERSONNEL] = $user->type_personnel_id;
				$_SESSION[S::PERS_PAYS] = $user->pays_id;
				$_SESSION[S::PERS_NOM] = $user->nom;
				$_SESSION[S::PERS_PRENOM] = $user->prenom;
				$_SESSION[S::PERS_SEXE] = $user->sexe;
				$_SESSION[S::PERS_PHOTO] = $user->photo;
				$_SESSION[S::PERS_TELEPHONE] = $user->telephone;
				$_SESSION[S::PERS_EMAIL] = $user->email;
				$_SESSION[S::PERS_ADRESSE] = $user->adresse;
				$_SESSION[S::PERS_LOGIN] = $user->login;
				$_SESSION[S::PERS_DATE_PRISE_SERVICE] = $user->date_prise_service;
				$_SESSION[S::PERS_DATE_FIN_CARRIERE] = $user->date_fin_carriere;
				$_SESSION[S::PERS_BIBLIOGRAPHIE] = $user->bibliographie;
				$_SESSION[S::PERS_DATE_HEURE_CONNEXION] =  date('U');
				// $_SESSION[S::PERS_IP] = $user->ip;


				$annee_scolaire = DBTable::getModel('annee_scolaire')
				->select(['id'=>'id', 'libelle' => 'libelle', 'debut_annee' => 'debut_annee', 'fin_annee' => 'fin_annee'])
				->where('visibilite', '=', 1)
				->where('statut', '=', 1)
				->orderBy('date_creation', 'desc')
				->one();
				// vd(S::ANNEE_SCOLAIRE);
				// dd(S::ANNEE_SCOLA_ID);
				// $_SESSION[S::ANNEE_SCOLA_ID] = $annee_scolaire['id'];

				$_SESSION[S::ANNEE_SCOLAIRE] = $annee_scolaire['id'];
					
				return true;
			}
		}

		return false;
	}
	

	public function getUserId()
	{
		if($this->logged()) {
			return $_SESSION['auth'];
		} else {
			return false;
		}
	}

	public function logged() {
		return isset($_SESSION['auth']);
	}

	public function disconnect()
	{
		if ($this->logged()) {
			unset($_SESSION[S::PERS_CODE]);
			unset($_SESSION[S::PERS_TYPE_PERSONNEL]);
			unset($_SESSION[S::PERS_PAYS]);
			unset($_SESSION[S::PERS_NOM]);
			unset($_SESSION[S::PERS_PRENOM]);
			unset($_SESSION[S::PERS_SEXE]);
			unset($_SESSION[S::PERS_PHOTO]);
			unset($_SESSION[S::PERS_TELEPHONE]);
			unset($_SESSION[S::PERS_EMAIL]);
			unset($_SESSION[S::PERS_ADRESSE]);
			unset($_SESSION[S::PERS_LOGIN]);
			unset($_SESSION[S::PERS_DATE_PRISE_SERVICE]);
			unset($_SESSION[S::PERS_DATE_FIN_CARRIERE]);
			unset($_SESSION[S::PERS_BIBLIOGRAPHIE]);
			unset($_SESSION[S::PERS_DATE_HEURE_CONNEXION]);
			unset($_SESSION[S::PERS_IP]);
			unset($_SESSION[S::DATA_TRANSPORT]);
			unset($_SESSION['auth']);
		}
	}
}