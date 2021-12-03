<?php 

class Fournisseur {
    
    private $connexion;
    private $nomTable = "Fournisseur";

    public $nomResp;
    public $telResp;
    public $mailResp;
    public $fonction;
    public $nomDomaine;

    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    public function AjouterFournisseur(){
    }

    public function ModifierFournisseur(){
    }
    
    public function SupprimerFournisseur(){
    }

    public function ObtenirFournisseur(){
    }

}

?>