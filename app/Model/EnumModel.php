<?php
namespace App\Model;

class EnumModel{
    const PERIODE = ['JOUR', 'SEMAINE', 'MOIS', 'ANNEE'];

    const STATUT_DOCUMENT_DISPONIBLE = 'DISPONIBLE';
    const STATUT_DOCUMENT_NON_DISPONIBLE = 'NON_DISPONIBLE';
    const STATUT_DOCUMENT_EMPRUNTE = 'EMPRUNTE';
    const STATUT_DOCUMENT =  ['DISPONIBLE', 'NON_DISPONIBLE', 'EMPRUNTE'];

}

class EnumPeriode{
    const PERIODE = ['JOUR', 'SEMAINE', 'MOIS', 'ANNEE'];
}

class EnumStatutDocument{
    const STATUT =  ['DISPONIBLE', 'NON_DISPONIBLE', 'EMPRUNTE'];

    const DISPONIBLE = 'Non disponible';
    const NON_DISPONIBLE = 'Non disponible';
    const EMPRUNTE = 'Non disponible';
}