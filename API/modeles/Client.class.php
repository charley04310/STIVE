<?php 

class Client {

    private $connexion;
    private $nomTable = "Client";
    
    public $nom;
    public $prenom;
    public $dateNaissance;


    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    
    public function AjouterClient(){
        

    }

    public function ModifierClient(){

    }
    
    public function SupprimerClient(){

}
}
?>