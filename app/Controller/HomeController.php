<?php

namespace App\Controller{

use App\Controller\Admin\AppController;

class HomeController extends AppController
{
    /**
     * Initialise les Models qu'on charge dans ce controller
    **/
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $this->app->setTitle('accueil - Ges-School');
        $this->render('home');
    }

   
}

}