<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Model\PensionClasse;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class PensionClasseController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::PENSION_CLASSE;
        $this->folder_view_index = 'pension_classe.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'pension_classe';
        $this->class_name = 'pension_classe';

        $this->title_page = 'Gestion des pension des classes - Ges-School';
        $this->title_home = 'Gestion des pension des classes';
        $this->create_title = "Creation d'une pension de la classe";
        $this->view_title = "Information d'une pension de la classe";
        $this->update_title = "Mise à jour d'une pension de la classe";
        $this->delete_title = "Suppression d'une pension de la classe";
        $this->msg_delete = "Voulez-vous vraiment supprimer la pension de la classe ";
    }

    
    public function getall(){
        $model = PensionClasse::table();
        $results = $model->select(' 
                                    type_pension.libelle as type_pension_id,
                                    type_pension.code as type_pension_code,
                                    classe.code as classe_code,
                                    classe.libelle as classe_id,
                                    pension_classe.code as code,
                                    pension_classe.montant as montant,
                                    pension_classe.mensualite as mensualite,
                                    pension_classe.est_mensuel as est_mensuel,
                                    pension_classe.optionnel as optionnel')
                    ->where('pension_classe.visibilite', 1)
                    ->join('type_pension', 'pension_classe.type_pension_id', '=', 'type_pension.id')
                    ->join('classe', 'pension_classe.classe_id', '=', 'classe.id')->get();
                    return $results;
    }


}
