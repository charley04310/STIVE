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

    public function AddTypeProduit(int $type_libelle){
        try{

        } 
        catch(InputVideException $e){ 
            // on capture l'exception personnalisé si il y en a une
             $error = 'Input Incorrect';
        }
        catch(Exception $e){

        }
        
    }

    public function DeleteTypeProduit(){
    }

    public function UpdateTypeProduit(){
    }
}


?>