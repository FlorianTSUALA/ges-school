<?php

namespace Core\Controller;

use Core\BaseApp;
use Core\Session\Session;
use Spipu\Html2Pdf\Html2Pdf;
use Core\HTML\Form\FormField;
use Core\HTML\Form\BootstrapForm;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

use function Core\Helper\dd;
use function Core\Helper\vd;

abstract class BaseController
{
    /** @var String $viewPath Chemin par défaut des vues */
    protected $viewPath;

    /** @var String $template Nom du template à charger */
    protected $template;

    /** @var Object \App $app Instance du singleton App */
    public $app;

    /** @var Object $form Instance de BootstrapForm pour créer les formulaires de modif et d'ajout */
    protected $form;

    protected $session;

    /**
     * Initialise les variables pour cette application
     **/
    public function __construct(BaseApp $app_instance)
    {
        $this->template = 'default';

        $this->viewPath = ROOT . '/ressources/views/';


        $this->app = $app_instance;

        $this->form = new BootstrapForm();
        
        $this->field = new FormField();

        $this->session = new Session();
        
    }



    /**
     * Charge les Models
     *
     * @param string $modelName Nom du Model à charger
     * @return type
     * @throws conditon
     **/
    protected function loadModel(string $modelName)
    {
        $this->$modelName = $this->app->getModel($modelName);
        // dd($this->$modelName);
    }
 

    protected function renderAtLocation(string $location, String $nameView, array $variables = [], string $template = 'default')
    {
        header("HTTP/1.1 200 OK");
        header("Location: {$location}");
        
        $this->render($nameView, $variables, $template);
    }

    protected function render(String $nameView, array $variables = [], string $template = 'default')
    {
        $tmp_template = $template?? $this->template;

        ob_start();
        extract($variables);
        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
        $content = ob_get_clean();
        require ($this->viewPath . 'templates/' . $tmp_template . '.php');
    }

    protected function renderPDF(String $nameView, array $variables = [], $pdfname='')
    {
        $pdfname = ($pdfname == '')? $nameView.'_'. $this->app->ORGANISATION.'_'.date('Y-m-d') : $nameView.'_'.$this->app->ORGANISATION.'_'.date('Y-m-d');

        try 
        {
            ob_start();
            extract($variables);
            require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', 'fr');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $html2pdf->output($pdfname.'.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }


    protected function compactView(String $nameView, array $variables = [], string $template = null)
    {
        $tmp_template = $template?? $this->template;

        ob_start();
        extract($variables);
        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
        $content = ob_get_clean();
        return $content;

    }


    protected function redirect(String $nameView, array $variables = [], string $template = null)
    {
        $tmp_template = $template?? $this->template;

        ob_start();
        extract($variables);
        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
        $content = ob_get_clean();
        require ($this->viewPath . 'templates/' . $tmp_template . '.php');
    }

    protected function redirectWithFlashMessage(String $nameView, array $variables = [], string $template = null)
    {
        $tmp_template = $template?? $this->template;
        ob_start();
        extract($variables);
        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';
        $content = ob_get_clean();
        require ($this->viewPath . 'templates/' . $tmp_template . '.php');
    }

    /**
     * Appel la vue avec un template définit, lui applique les variables et l'envoie à l'application
     *
     * @param String $nameView Nom de la vue à appeler
     * @param Array $variables Variables nécessaire dans la vue pour afficher les différents éléments récupérés dans les Models
     * @return type
     **/
    protected function renderWithTemplate(string $template, String $nameView, array $variables = [])
    {
        ob_start();

        extract($variables);

        require $this->viewPath . str_replace('.', '/', $nameView) . '.php';

        $content = ob_get_clean();

        require ($this->viewPath . 'templates/' . $template . '.php');
    }


    // public function toOject($data)
    // {
    //     return json_decode($data, JSON_PRETTY_PRINT);
    // }

    // public function toJSON($data)
    // {
    //     return json_encode(Helpers::utf8_code_deep($data), JSON_PRETTY_PRINT);
    // }

    // public function toArray($data, $isAssoc = true)
    // {
    //     return json_decode(json_encode( $data), $isAssoc);
    // }


    /*

        $response = $db->store($_GET["store_id"]);

        sendResponseAndExit(true, 300, "DB_ACTION DINIED", false, $response);

        sendResponseAndExit(true, 200, "OK", false, $response);

        sendResponseAndExit(false, 400, "Bad Request");

        sendResponseAndExit(false, 404, "Not Found");

    */
    function sendResponseAndExit($JSONResponse = '', $isJSON = FALSE, $success = TRUE, $code = '200', $description = 'OK', $extraHeader= false) {
        if ($success) {
            if ($extraHeader)
                header($extraHeader);

            if ($isJSON) {
                header('Content-Type: application/json; charset=utf-8');
                header('Content-Length: ' . strlen($JSONResponse));
                header("HTTP/1.1 {$code} {$description}");
                echo $JSONResponse;
            }else{
                header('Content-Type: text/html; charset=utf-8');
                header('Content-Length: ' . strlen($JSONResponse));
                header("HTTP/1.1 {$code} {$description}");
                echo $JSONResponse;
            }

        }else {
            die();
        }
    }


	/**
	 * Permet de renvoyer vers une page 404
	 * @param none
	 * @return none
	 */
	protected function error404() {
		$this->app::abort(404, 'Page inaccessible !!!');
	}

	/**
	 * Interdit l'accès à la page quand le User n'est pas Auth
	 * @param none
	 * @return none
	 */
	protected function forbidden() {
		$this->app::abort(403, 'Accès interdit');
    }

}