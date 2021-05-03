<?php

namespace App\Controller;

class RegisterController extends AppController
{
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $this->app->setTitle('Inscription - ges-school');

        $this->render('auth.register', [], "layout-auth");
    }

    /**
     * permet la connexion d'utilisateur à la BD
     **/
    public function postLogin()
    {
        $this->render('home');
    }

}