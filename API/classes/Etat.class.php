<?php 

class Etat {

    private $connexion;
    private $nomTable = "Etat";

    public $id;
    public $libelle;

    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    
    public function AjouterEtat(){
        

    }

    public function ModifierEtat(){

    }
    
    public function SupprimerEtat(){

    }

}

?>