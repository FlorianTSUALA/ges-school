<?php

namespace Core\HTML\Form;

use App\Helpers\HTMLHelper;

use function PHPSTORM_META\type;

class FormModel
{
	
	const INTERNAL = 'internal';
	const TABLE = 'table';
	const LABEL = 'label';
	const FIELDTYPE = 'fieldType';
	const ID = 'id';
	const NAME = 'name';
	const TYPE = 'type';
	const DATA = 'data';
	const ICON = 'icon';
	const CLASS_CSS = 'class';
	const PLACEHOLDER = 'placeholder';
	const WARNING_MSG = 'warning_msg';
	const REQUIRED = 'required';
	const EXTERNAL_TARGET = 'external_target';
	const EXTERNAL_TYPE = 'external_type';
	
	public $internal = true; 
	public $table; 
	public $fieldType; 
	public $label; 
	public $id; 
	public $name; 
	public $type = 'text'; 
	public $data = [];
	public $icon = '';
	public $class = '';
	public $placeholder = ''; 
	public $warning_msg = 'Ce champs est obligatoire'; 
	public $required = true;
	public $external_target = '';
	public $external_type = InputType::TEXT;

	public function __construct($internal = true, $field, $label='', $type='text', $data=[], $placeholder='', 
													$warning_msg='', $required=true, $class='', $icon='', $id='', $table='', $external_target='libelle', $external_type =InputType::TEXT)
	{
		$this->internal = $internal;
		$this->name = strtolower($field) ;
		$this->label = ($label === '')? HTMLHelper::formatFieldTable($field) : $label;
		$this->type = $type;
		$this->data = $data;
		$this->placeholder = $placeholder;
		$this->warning_msg = ($warning_msg === '')? $this->warning_msg : $warning_msg;
		$this->required = $required;
		$this->class = $class;
		$this->icon = $icon;
		$this->id = ($id === '')? $this->name : $id;
		$this->fieldType = $this->initFieldType($this->type);
		$this->table = ($table === '')? str_replace('_id', '', $this->name) : $table;
		$this->external_target = ($internal)? '' : $external_target;
		$this->external_type = ($internal)? $type : $external_type;
	}

	private function initFieldType($type){
		switch($type){
			case InputType::CHECKBOX:
				return FieldType::CHECKBOX;
			break;
			case InputType::TEXTAREA:
				return FieldType::TEXTAREA;
			break;
			case FieldType::RADIO:
				return FieldType::RADIO;
			break;
			case InputType::SUBMIT:
			case InputType::RESET:
				return FieldType::BUTTON;
			break;
			case InputType::SELECT:
				return FieldType::SELECT;
			case InputType::SELECT2:
				return FieldType::SELECT;
			break;
			default:
				return FieldType::INPUT;
			/*case InputType::TEXT:
			case InputType::EMAIL:
			case InputType::PASSWORD:
			case InputType::HIDDEN:
			case InputType::NUMBER:
			case InputType::FILE:
			case InputType::DATE:
			case InputType::DATE_TIME_LOCAL:
			case InputType::TIME:
				return FieldType::INPUT;
			break;*/
		}
	}

}