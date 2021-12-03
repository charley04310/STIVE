<?php 

class CommandeFournisseur {

    private $connexion;
    private $nomTable = "CommandeFournisseur";
    
    public $dateCrea;
    public $dateMaj;
    public $id;


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