<?php

namespace Core\Model;

class CodeSeqGenerator 
{	

	private static $instance = null;
	private $compteur;

	private function __construct()
	{
	  $this->compteur = random_int(1, 9) + Date('u');
	}
	
	public static function getInstance()
	{
	  if(!self::$instance)
	  {
		self::$instance = new CodeSeqGenerator();
	  }
	  return self::$instance;
	}
	
	public function uniqueCode($class_name)
	{
		usleep ( 7 );
		return(strtoupper(substr( $class_name, 0, 4)."_".Date('U') .(++$this->compteur) . substr(uniqid(), 7, 13)) );
	}
}