<?php

class Image
{

    private $connexion;
    private $nomTable = "Image";

    public $id;
    public $adresse;
    public $nom;

    public function __construct($BDD)
    {
        $this->connexion = $BDD;
    }


    public function AddImage()
    {
    }

    public function DeleteImage()
    {
    }

}
