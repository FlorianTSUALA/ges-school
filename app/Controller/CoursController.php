<?php

namespace App\Controller;

use App\Model\Cours;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Helpers\TraitCRUDController;
use ClanCats\Hydrahon\Query\Expression as Ex;
use App\Controller\Admin\AppController;

class CoursController extends AppController
{
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();
        
        $this->vairant = DBTable::COURS;
        $this->folder_view_index = 'cours.affectation_cours';

        $this->loadModel($this->vairant);
        $this->base_route = 'cours';
        $this->class_name = 'cours';

        $this->title_page = 'Gestion des cours - Ges-School';
        $this->title_home = 'Gestion des cours dispensés les salles';
        $this->create_title = "Creation d'un cours";
        $this->view_title = "Information d'un cours";
        $this->update_title = "Mise à jour d'un cours";
        $this->delete_title = "Suppression d'un cours";
        $this->msg_delete = "Voulez-vous vraiment supprimer le cours ";

    }

    public function index()
    {
        $this->app->setTitle($this->title_page);
        $title =$this->title_home;
        $items = $this->getall();
        $fillables = $this->{$this->vairant}->fillables;
        $class_name = $this->class_name;
        $base_route = $this->base_route;
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;
        
        $cours = Helpers::toJSON(
            Cours::table()
                ->select([  
                            'classe.code' => 'classe_id', 
                            // 'classe.libelle' => 'classe_value',
                            'matiere.code' => 'matiere_id', 
                            // 'matiere.libelle' => 'matiere_value',
                            // 'classe.libelle' => 'classe_value',
                            'salle_classe.code' => 'salle_classe_id', 
                            'personnel.code' => 'personnel_id', 
                            // 'salle_classe.libelle' => 'salle_classe_value',
                            'cours.code' => 'id', 
                            'cours.libelle' => 'libelle',
                            'cours.volume_horaire' => 'volume_horaire', 
                            'cours.coefficient' => 'coefficient'
                        ])
                ->join('classe', 'classe.id', '=', 'cours.classe_id')
                ->join('salle_classe', 'salle_classe.id', '=', 'cours.salle_classe_id')
                ->join('matiere', 'matiere.id', '=', 'cours.matiere_id')
                ->join('personnel', 'personnel.id', '=', 'cours.personnel_id')
                ->where('cours.visibilite', '=', 1)
                ->get()
            );

        $cycles = Helpers::toJSON(DBTable::getModel('cycle')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $classes = Helpers::toJSON(DBTable::getModel('classe')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());

        $matieres = Helpers::toJSON(DBTable::getModel('matiere')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());

        // $classes = Helpers::toJSON(DBTable::getModel('classe')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());

        $salle_classes = Helpers::toJSON(DBTable::getModel('salle_classe')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
            //var_dump( $classes);
            //print_r( DBTable::getModel('salle_classe')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
            //die();
        $personnels = Helpers::toJSON(DBTable::getModel('personnel')
                        ->select(
                            [   'personnel.code' => 'id',  
                                'type_personnel.code' => 'type_personnel_id', 
                                new Ex("concat(nom,' ',prenom) as value")
                            ])
                        ->join('type_personnel', 'type_personnel.id', '=', 'personnel.type_personnel_id')
                        ->where('personnel.visibilite', '=', 1)
                        ->get());

        $type_personnels = Helpers::toJSON(DBTable::getModel('type_personnel')->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        
        $this->render('sections.cours.affectation_cours', compact('class_name', 'fillables', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete', 
                        'title', 'cours', 'matieres', 'cycles', 'classes', 'personnels', 'salle_classes', 'type_personnels'));
    }


    public function list(){
        $this->sendResponseAndExit($this->getall());
      
    }

    public function getall(){
        $cours = Helpers::toJSON(
            Cours::table()
                ->select([  
                            'classe.code' => 'classe_id', 
                            // 'classe.libelle' => 'classe_value',
                            'matiere.code' => 'matiere_id', 
                            // 'matiere.libelle' => 'matiere_value',
                            // 'classe.libelle' => 'classe_value',
                            'salle_classe.code' => 'salle_classe_id', 
                            'personnel.code' => 'personnel_id', 
                            // 'salle_classe.libelle' => 'salle_classe_value',
                            'cours.code' => 'id', 
                            'cours.libelle' => 'libelle',
                            'cours.volume_horaire' => 'volume_horaire', 
                            'cours.coefficient' => 'coefficient'
                        ])
                ->join('classe', 'classe.id', '=', 'cours.classe_id')
                ->join('salle_classe', 'salle_classe.id', '=', 'cours.salle_classe_id')
                ->join('matiere', 'matiere.id', '=', 'cours.matiere_id')
                ->join('personnel', 'personnel.id', '=', 'cours.personnel_id')
                ->where('cours.visibilite', '=', 1)
                ->get()
            );
        return $cours;
    }

    
    public function update($code)
    {
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables)); 
        $clause = [ 'code' => $code ];

        $result = $this->{$this->vairant}->update($data, $clause);

        if($result){
            $this->sendResponseAndExit($this->getall());
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

    public function delete($code)
    {   
        $result = $this->{$this->vairant}->delete('code', $code);
        if($result){
            $this->sendResponseAndExit($this->getall());
        }else{
            $this->sendResponseAndExit($code, FALSE, 400, 'DB Error');
        }
    }
}