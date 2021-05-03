<?php

namespace App\Controller;

use App\Report\FactureVersement;



class PrinterController
{
    const SCOLARITE = 'scolarite';
    // https://github.com/spipu/html2pdf
    public function index($model)
    {
        switch($model){
            case self::SCOLARITE:
                 $facture = new FactureVersement;
                 $facture->index();
            break;

        }
    }


}