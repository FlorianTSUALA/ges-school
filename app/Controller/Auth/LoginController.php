<?php

namespace App\Controller\Auth;

use App\App;
use App\Helpers\S;
use Core\Auth\DBAuth;
use App\Controller\AppController;

use function Core\Helper\dd;

class LoginController extends AppController
{
    /**
     * Permet l'authentification de l'utilisateur
     **/
    public function login()
    {
        $error = "Aucune valeur saisie";
        if (!empty($_POST)) {

            $auth = new DBAuth($this->app->getDBInstance());
            
            if ($auth->login($_POST['user-name'], $_POST['user-password'])) {
                $this->home();
            } else {
                $error = "Nom d'utilisateur ou mot de passe invalid";
            }
        }

        $this->render('auth.login', compact('error'), "layout-auth");
    }

    /**
     * Permet l'authentification de l'utilisateur
     **/
    public function logout()
    {
        $auth = new DBAuth($this->app->getDb());
        $auth->disconnect();
        $this->app->setTitle('Connexion - Ges-School');
        header("HTTP/1.1 200 OK");
        $root = App::base_url();
		header("Location: {$root}");
        $this->render('auth.login', [], "layout-auth");
    }


    public function index()
    {
        $auth = new DBAuth($this->app->getDBInstance());
        if ($auth->logged()) {
            $this->home();
        }else{
            $this->app->setTitle('Connexion - Ges-School');
            $this->render('auth.login', [], "layout-auth");
        }

    }

    /**
     * permet la connexion d'utilisateur à la BD
     **/
    public function home()
    {
        $this->app->setTitle('accueil - Ges-School');
        
        $this->session->flash("Hello  ".$this->session->get(S::PERS_NOM)."!!!<br> Nous sommes ravis de vous revoir!!!");

        header("HTTP/1.1 200 OK");
        header('Location: accueil');
        
    }

     /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
    }

  
}