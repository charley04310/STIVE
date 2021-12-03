<?php 

class Role {

    private $connexion;
    private $nomTable = "Role";
    private $id;
    private $libelle;

    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    
    public function AjouterVin(){
        

    }

    public function ModifierVin(){

    }
    
    public function SupprimerVin(){

    }

    public function ObtenirLePrix(){
        // https://monsite.fr/api/controlers/vin/Prix

    }

    public function ObtenirToutesInfos(){

    }
}

?>