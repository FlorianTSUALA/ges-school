<?php

namespace Core\HTML\Form;

class InputType
{
	const TEXT = 'text';
	const EMAIL = 'email';
	const PASSWORD = 'password';
	const HIDDEN = 'hidden';
	const NUMBER = 'number';
	const FILE = 'file';
	const DATE = 'date';
	const DATE_YEAR = 'date_year';
	const DATE_MONTH = 'date_month';
	const DATE_DAY = 'date_day';
	const DATE_TIME_LOCAL = 'datetime-local';
	const TIME = 'time';
	const TEL = 'tel';
	const COLOR = 'color';
	const CHECKBOX = 'checkbox';
	//@TODO FILE/ISBN format


	const TEXTAREA = 'textarea';
	
	const SUBMIT = 'submit';
	const RESET = 'reset';

	const RADIO = 'radio';
	/*
		[
			'id' => id,
			'value' => value
		]	
	*/
	const SELECT = 'select';
	const SELECT2 = 'select2';

}