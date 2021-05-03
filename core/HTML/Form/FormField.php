<?php

namespace Core\HTML\Form;

use App\Helpers\HTMLHelper;

class FormField implements FormBuilder
{
	/** @var array $data Tableau de données pour récupérer les éléments en POST et les mettre dans les formulaires */
	protected $data;
	
	protected $input;
	
	protected $select;
	
	protected $textarea;
	
	protected $radio;

	protected $html = '';

	private $olabel = '';
	private $oname = '';
	private $ohasSubClass = '';
	private $osubClass = '';
	private $otype = '';
	private $oclass = '';
	private $orows = '';
	private $oselected = '';
	private $oicon = '';
	private $orequired = '';

	public function __construct($post = [])
	{
		$this->data = $post;
	}

	private function prepareFields(string $id, string $name, string $label = null, array $options = [], bool $dataCallable = true)
	{
		if ($label === null) {
			$label = $name;
		}
		
		$this->oname = $name;
		$this->oid = $id;
		$this->olabel = ucfirst($label);
		$this->ohasSubClass = (isset($options['hasSubClass']) && ($options['hasSubClass'] !=='')) ? $options['hasSubClass'] : false;
		$this->oplaceholder = (isset($options['placeholder'])) ? $options['placeholder'] : '' ;
		$this->osubClass = (isset($options['subClass']) && ($options['subClass'] !=='')) ? $options['subClass'] : 'col-8';
		$this->otype = (isset($options['type'])  && ($options['type'] !=='')) ? $options['type'] : 'text';
		$this->orequired = (isset($options['required']) && ($options['required'] !=='')) ? (($options['required'])? 'required' : '') : '';
		$this->oclass = (isset($options['class']) && ($options['class'] !=='')) ? $options['class'] : 'form-control';
		$this->orows = (isset($options['rows'])  && ($options['rows'] !=='')) ? $options['rows'] : '10';
		$this->oselected = isset($options['selected'])? $options['selected'] : '';
		
		$data = (isset($options['data'])) ? $options['data'] : NULL;
		if ($dataCallable && $data === NULL) {
			if (is_object($this->data)) {
				$data = $this->data->$name;
			} else {
				$data = (isset($this->data[$name])) ? $this->data[$name] : null;
			}
		}
		$this->data = ($data === [])? '' : $data;
	}

	public function input(string $id, string $name, string $label = null, array $options = [], $prefix=''):FormBuilder
	{
		$this->prepareFields($id, $name, $label, $options);
		$required = $this->orequired?HTMLHelper::required_input_text():'';
		$html = "<label for='".$prefix.$this->oid."'>{$this->olabel} {$required}  :</label>";
		$html .= "<input type='{$this->otype}' name='{$this->oname}' id='".$prefix.$this->oid."' class='{$this->oclass}' placeholder='{$this->oplaceholder}' value='{$this->data}' {$this->orequired}/>";

		if($this->ohasSubClass){
			$html = '<div class="' .$this->osubClass. '">'.$html.'</div>';
		}	
		$this->html = $html;
		return $this;
						
	}
	
	public function select(string $id, string $name, string $label = null, array $options = [], $prefix='', $warning_msg='Velillez effecutuer une selection!!!'):FormBuilder
	{	
		$this->prepareFields($id, $name, $label, $options);
		$required = $this->orequired?HTMLHelper::required_input_text():'';
		$html = "<label for='".$prefix.$this->oid."'>{$this->olabel} {$required}  :</label>";
		$html .= "<select name='".$this->oname."' id='".$prefix.$this->oid."' class='{$this->oclass}' $this->orequired>";

		// $html .= ' <option value="" disabled>- Choissisez le type de pension concerné -</option>';

		foreach ($options['data'] as $select) {
			$html .=	"
						";
			
			$html .= $this->selectOption($select['value']??"", $select['id'], $this->oselected);
		}

		//$html .= '<div class="invalid-feedback">'.$warning_msg.'</div>';
		$html .= '</select>';

		if($this->ohasSubClass){
			$html = '<div class="' .$this->osubClass. '">'.$html.'</div>';
		}
		
		$this->html = $html;
		return $this;
	}
	public function radio(string $id, string $name, string $label = null, array $options = [], $prefix='', $warning_msg='Ce champs est obligatoire'):FormBuilder
	{
		$this->prepareFields($id, $name, $label, $options);
			
		$html = '<label class="form-check-label" >'. $label .' '.($this->orequired?HTMLHelper::required_input_text():'') .':</label>
				 <div class="row form-check-inline">';
		foreach ($this->data as $item) {
			$html .= "<div class='col-4'>".
				 "<label class='form-check-label' for='".$prefix.$item['id']."'>".$item['value']."</label>	".
				 "<input type='radio' name='".$name."' id='".$prefix.$item['id']."' class='form-check-input' value='".$item['id']."'  ".$this->orequired."/>
				 <div class='invalid-feedback'> ".($this->orequired? $warning_msg:'')." </div>".
			"</div>";
		}
		$html .= '</div>' .'<label id="'.$name.'-error" class="error" for="'.$name.'"></label>';
		if($this->ohasSubClass){
			$html = '<div class="' .$this->osubClass. '">'.$html.'</div>';
		}
		$this->html = $html;
		return $this;
	}

	public function radiov2(string $id, string $name, string $label = null, array $options = [], $prefix='',$warning_msg='Ce champs est obligatoire') 
	{
		$this->prepareFields($id, $name, $label, $options);
			
		$html = '<label class="form-check-label" >'. $label .' '.($this->orequired?HTMLHelper::required_input_text():'') .':</label>
				 <div class="row form-check-inline">';
		$i = 0;
		foreach ($this->data as $item) {
			$html .= "<div class='col-4'>".
				 "<label class='form-check-label' for='".$id.++$i."'>".$item['value']."</label>	".
				 "<input type='radio' name='".$name."' id='".$id.$i."' class='form-check-input' value='".$item['id']."'  ".$this->orequired."/>
				 <div class='invalid-feedback'> ".($this->orequired? $warning_msg:'')." </div>".
			"</div>";
		}
		$html .= '</div>' .'<label id="'.$name.'-error" class="error" for="'.$name.'"></label>';
		if($this->ohasSubClass){
			$html = '<div class="' .$this->osubClass. '">'.$html.'</div>';
		}
		$this->html = $html;
		return $this;
	}

	private function selectOption(string $value, string $id, string $defaultId):string
	{
		$value = ucfirst($value);

		if ($id === $defaultId) {
			$selected = 'selected';
		} else {
			$selected = NULL;
		}

		return "<option value='{$id}' {$selected}>{$value}</option>";
	}

	public function controlValidation($msg_error='ce Champs est obligatoire', $msg_success=''):FormBuilder
	{
		$this->html .= '<div class="valid-feedback"> '.$msg_success.'</div>
						<div class="invalid-feedback">'.$msg_error.'</div>' ;
		return $this;
	}

	public function inFormGroup($additional_class_group, $style =''):FormBuilder
	{
		$this->html = 	'
						<div class="form-group '.$additional_class_group.' " style="'.$style.'">
						'.$this->html.'</div>' ;
		return $this;
	}

	public function withIcon($fa_class = 'fa fa-edit font-medium-5 line-height-1 text-muted icon-align'):FormBuilder
	{
		$this->html .= '<div class="form-control-position">
							<i class="'.$fa_class.'"></i>
						</div>
		' ;
		return $this;
	}

	public function button(string $name, string $class = 'btn btn-primary', $type='button', $id =''):FormBuilder
	{
		$name = ucfirst($name);
		if($type === 'button'){
			$this->html = "<button type='submit' class='{$class}' id='{$id}'>{$name}</button>";
		}else{
			$this->html = "<input type='{$type}' id='{$id}' class='{$class}>{$name}</input>";
		}
		return $this;
	}

	public function show()
	{
		echo $this->html;
	}

	public function html()
	{
		return $this->html;
	}
}