<?php

namespace App\Report;

class Report{

    protected $path_res;

    public function __construct()
    {
        $this->path_res = dirname(dirname(__DIR__)).'/ressources/uploads/';
    }

}