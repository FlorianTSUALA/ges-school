<?php 

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Document extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const DOMAINE_ID = "domaine_id";
    // const NUMERO_ENREGISTREMENT = "numero_enregistrement";
    const NUMERO_ISBN = "numero_isbn";
    const TITRE = "titre";
    const COUVERTURE = "couverture";
    const AUTEUR = "auteur";
    const EDITION = "edition";
    const RESUME = "resume";
    const NOMBRE_PAGE = "nombre_page";
    const DATE_PUBLICATION = "date_publication";
    const MAISON_EDITION = "maison_edition";

    public function __construct(){
        parent::__construct();

        $domaines = DBTable::getModel(DBTable::DOMAINE)->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', '=', 1)->get();

        $this->fillables =
            [
                new FormModel(false,self::DOMAINE_ID , 'Domaine', InputType::SELECT2, $domaines, '', 'Choisir un domaine', true, 'select2 form-control'),
                // new FormModel(true, self::CODE_ENREGISTREMENT , 'Numéro d\'enregistrement', InputType::NUMBER),
                new FormModel(true, self::NUMERO_ISBN , 'Code isbn', InputType::TEXT),
                new FormModel(true, self::TITRE ),
                // new FormModel(true, self::COUVERTURE ),
                new FormModel(true, self::AUTEUR ),
                new FormModel(true, self::NOMBRE_PAGE , 'Nombre de page', InputType::NUMBER),
                new FormModel(true, self::DATE_PUBLICATION , 'Date de publication', InputType::DATE, [], '', '', false),    
                new FormModel(true, self::MAISON_EDITION , 'Maison d\'edition', InputType::TEXT, [], '', '', false),

            ];

    }
}