<?php

namespace App\Controller;

use App\Model\Classe;
use App\Model\DBTable;
use App\Model\SalleClasse;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class SalleClasseController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::SALLE_CLASSE;
        $this->folder_view_index = 'salle_classe.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'salle_classe';
        $this->class_name = 'salle_classe';

        $this->title_page = 'Gestion des salles de classes - ' . $this->organisation;
        $this->title_home = 'Gestion des salles de classes';
        $this->create_title = "Creation d'une salle de classe";
        $this->view_title = "Information d'une salle de classe";
        $this->update_title = "Mise à jour d'une salle de classe";
        $this->delete_title = "Suppression d'une salle de classe";
        $this->msg_delete = "Attention, la suppression d'une salle de clase entrainera la non visibilité des affectations de salle de classe associé à cette salle de classe";
                            "Mais aussi de touts les entités auquelle elle est rattachée !!!Voulez-vous vraiment supprimer la salle de classe ";
    }

        
    public function get_all(){
        $model = SalleClasse::table();
        $results = $model->select(' classe.libelle as classe_id, salle_classe.code as external_target, salle_classe.code as code, salle_classe.libelle as libelle')
                    ->where('classe.visibilite', 1)
                    ->where('salle_classe.visibilite', 1)
                    ->join('classe', 'salle_classe.classe_id', '=', 'classe.id')->get();
        return $results;
    }

}
