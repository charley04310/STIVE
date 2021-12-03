<?php

class Image
{

    private $connexion;
    private $nomTable = "Image";

    public $id;
    public $adresse;
    public $nom;
    
    // on construit l'objet à partir de la BDD 
    public function __construct($BDD)
    {
        $this->connexion = $BDD;
    }


    public function AddImage()
    {
        try{
        // on Try une Requete pour ajouter un message

        }
        catch(InputVideException $e){ 
            // on capture l'exception personnalisé si il y en a une
             $error = 'Input Vide';
        }
        catch(Exception $e){ 
         $error= $e->getMessage();
        }
    }

    public function DeleteImage()
    {
    }

}
