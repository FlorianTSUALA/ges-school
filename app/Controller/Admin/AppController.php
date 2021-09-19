<?php
namespace App\Controller\Admin;

use \Core\Auth\DBAuth;
use App\Helpers\S;

use function Core\Helper\dd;

class AppController extends \App\Controller\AppController
{
    
    public function __construct()
    {
        parent::__construct();

        $auth = new DBAuth($this->app->getDB());
        if (!$auth->logged()) {         
            $auth->disconnect();
            $this->forbidden();
        }
        $_SESSION[S::LAST_ACTIVITY] = time(); // update last activity time stamp

    }
}