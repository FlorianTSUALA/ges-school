<?php

namespace Core\HTML\Form;

interface FormBuilder
{

	function input(string $id, string $name, string $label = null, array $options = []):FormBuilder;

	function select(string $id, string $name, string $label = null, array $options = [], $prefix='', $warning_msg='Velillez effecutuer une selection!!!'):FormBuilder;

	function radio(string $id, string $name, string $label = null, array $options = [], $prefix='', $warning_msg='Ce champs est obligatoire'):FormBuilder;

	function controlValidation($msg_error='Ce Champs est obligatoire', $msg_success=''):FormBuilder;

	function inFormGroup($additional_class_group, $style =''):FormBuilder;

	function withIcon($fa_class = 'fa fa-edit font-medium-5 line-height-1 text-muted icon-align'):FormBuilder;

	function button(string $name, string $class = 'btn btn-primary', $type='button', $id =''):FormBuilder;

	function show();

}