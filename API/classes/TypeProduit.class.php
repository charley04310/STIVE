<?php

class TypeProduit
{

    private $connexion;
    private $nomTable = "TypeProduit";
    public $type_libelle;
    public $id;


    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

   

    public function DeleteTypeProduit(){
    }

    public function UpdateTypeProduit(){
    }
}


?>