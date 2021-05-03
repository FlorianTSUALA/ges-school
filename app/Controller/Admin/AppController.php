<?php
namespace App\Controller\Admin;

use \Core\Auth\DBAuth;

class AppController extends \App\Controller\AppController
{
    
    public function __construct()
    {
        parent::__construct();

        $auth = new DBAuth($this->app->getDB());

        if (!$auth->logged()) {
            $this->forbidden();
        }
    }
}