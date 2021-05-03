<?php

namespace App\Helpers;

use App\Model\DBTable;
use Core\Session\Request;
use App\Helpers\HTMLHelper;
use Core\HTML\Form\FormModel;

use function Core\Helper\dd;

trait TraitCRUDController
{
    //TODO TAKE CARE OF ANNEE SCOLAIRE AND VISIBILITE IN ALL REQUEST
        // $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        // ->where('table.annee_scolaire_id', $annee_scolaire_id)
        // ->where('table.visibilite', 1)
        
    public function index()
    {
        $this->app->setTitle($this->title_page);
        $title = $this->title_home;
        $items = $this->getall();
        $fillables = $this->{$this->vairant}->fillables;
        $class_name = $this->class_name;
        $base_route = $this->base_route;
        $route = $this->base_route;
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;
        $this->render('sections.'.$this->folder_view_index, compact('route', 'items', 'class_name', 'fillables', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete'));
    }

    

    public function save()
    {
        //  var_dump("Heyyyy");
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables)); 
        $data += ['code' => $this->{$this->vairant}->genCode()];

        $result = $this->{$this->vairant}->save($data);
        if($result){
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

    public function getall(){
        // dd($this->{$this->vairant}->all());
        return $this->{$this->vairant}->all();
    }

    public function all(){
        return Helpers::toJSON($this->getall()) ;
    }

    public function list(){
        echo Helpers::toJSON($this->getall()) ;
    }

    public function show($code)
    {
        $entity = $this->{$this->vairant}->find('code', $code);
        if(is_object($entity))
            $entity = (array) $entity;
        $entity = $this->resolveId2CodeInput($entity, $this->{$this->vairant}->fillables); 
        if($entity){
            $this->sendResponseAndExit(Helpers::toJSON($entity, TRUE));
        }else{
            $this->sendResponseAndExit($entity, FALSE, 400, 'DB Error');
        }
    }


    public function detail($code)
    {
        $entity = $this->{$this->vairant}->find('code', $code);
        
        $entity = $this->resolveExternalId2Value($entity, $this->{$this->vairant}->fillables);

        if($entity){
            $html = Helpers::buildDetailModel($entity, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($html);
        }else{
            $this->sendResponseAndExit($entity, FALSE, 400, 'DB Error');
        }
    }

    public function update($code)
    {
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables)); 
        $clause = [ 'code' => $code ];

        $result = $this->{$this->vairant}->update($data, $clause);

        if($result){
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

    public function delete($code)
    {   
        $result = $this->{$this->vairant}->delete('code', $code);
        if($result){
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($code, FALSE, 400, 'DB Error');
        }
    }

    public function resolveCode2IdInput($data, $resolvables){
        foreach($resolvables as $key => $resolv){
            $code = $data[$resolv['code']];
            $model = DBTable::getModel($resolv['table']);
            
            $id = $model->select('id')->where('code', $code)->get()[0]['id'];
            $data[$resolv['code']] = $id;
        }
        return $data;
    }

    public function resolveId2CodeInput($data, $resolvables){
        foreach($resolvables as $key => $resolv){
            if(is_object($resolv))
                $resolv = (array)$resolv;
            
            if(isset($resolv) && !$resolv[FormModel::INTERNAL]){
                $id = $data[$resolv['id']];
                $model = DBTable::getModel($resolv['table']);
                
                $code = $model->select('code')->where('id', $id)->get()[0]['code'];
                $data[$resolv['id']] = $code;
            }
            
        }
        return $data;
    }


    public function resolveExternalId2Value($data, $resolvables){
            $data = Helpers::object_to_array($data);
            //$resolvables = Helpers::object_to_array($resolvables);
           
            foreach($resolvables as $key => $resolv){
                if(is_object($resolv))
                    $resolv = (array)$resolv;

                if(isset($resolv) && !$resolv[FormModel::INTERNAL]){
                    $table = $resolv[FormModel::TABLE];
                    $id = $data[$resolv[FormModel::ID]];
                    $field = $resolv[FormModel::EXTERNAL_TARGET];

                    $model = DBTable::getModel($table);
                    
                    $value = $model->select($field)->where('id', $id)->last()[$field];

                    $data[$resolv[FormModel::ID]] = $value;
                }
            }
        return $data;
        
    }

}
