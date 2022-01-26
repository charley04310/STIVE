<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Produit.class.php';
include_once '../../classes/exceptions/APIException.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();
// CRÉATION DE L'OBJET VIN 
$NewProduit = new Produit($BDD);

$validationRequest = false;
try{

    if( 
        isset($_POST['NameNewProduit']) &&
        isset($_POST['FournisseurNewProduit']) &&
        isset($_POST['PrixNewProduit']) &&
        isset($_POST['QuantiteNewProduit']) 
    ){
        $NewProduit->nom  = $_POST['NameNewProduit'];
        $NewProduit->test_input($NewProduit->nom);
        $NewProduit->length_string($NewProduit->nom);


        $NewProduit->fournisseur = $_POST['FournisseurNewProduit'];
        $NewProduit->test_input($NewProduit->fournisseur);
        $NewProduit->length_string($NewProduit->fournisseur);

        $NewProduit->prix = $_POST['PrixNewProduit'];
        $NewProduit->test_input($NewProduit->prix);
        $NewProduit->length_float($NewProduit->prix);

        $NewProduit->$quantite = $_POST['QuantiteNewProduit'];
        $NewProduit->test_input($NewProduit->quantite);
        $NewProduit->length_float($NewProduit->quantite);

       return $validationRequest = true;


    }else{
        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }



    if(isset($_POST['ReferenceNewProduit'])){
        $NewProduit->reference  = $_POST['ReferenceNewProduit'];
        $NewProduit->test_input($NewProduit->reference);
        $NewProduit->length_string($NewProduit->reference);

    }else{
        $NewProduit->reference  = null;
    }


    if(isset($_POST['CepageNewProduit'])){ 

        $NewProduit->cepage = $_POST['CepageNewProduit'];
        $NewProduit->test_input($NewProduit->cepage);
        $NewProduit->length_string($NewProduit->cepage);
    }else{
        $NewProduit->cepage = null;

    }

    if(isset($_POST['AnneNewProduit'])){ 
        $NewProduit->anne = $_POST['AnneNewProduit'];
        $NewProduit->test_input($NewProduit->anne);
        $NewProduit->length_int($NewProduit->anne);

    }else{
        $NewProduit->anne = null;

    }


    if(isset($_POST['PrixLitreNewProduit'])){
        $NewProduit->prixlitre = $_POST['PrixLitreNewProduit'];
        $NewProduit->test_input($NewProduit->prixlitre);
        $NewProduit->length_int($NewProduit->prixlitre);
    }else{
        $NewProduit->prixlitre = null;

    }

    if(isset($_POST['SeuilNewProduit'])){
        $NewProduit->seuil = $_POST['SeuilNewProduit'];
        $NewProduit->test_input($NewProduit->seuil);
        $NewProduit->length_float($NewProduit->seuil);
    }else{
        $NewProduit->seuil = null;

    }

    if(isset($_POST['VolumeNewProduit'])){
        $NewProduit->seuil = $_POST['SeuilNewProduit'];
        $NewProduit->test_input($NewProduit->volume);
        $NewProduit->length_float($NewProduit->volume);
    }else{
        $NewProduit->volume = null;

    }

    if(isset($_POST['DescriptionNewProduit'])){
        $NewProduit->description = $_POST['DescriptionNewProduit'];
        $NewProduit->test_input($NewProduit->description);
        $NewProduit->length_string($NewProduit->description);
    }else{
        $NewProduit->description = null;

    }

    if($validationRequest === true){
        if($NewProduit->AjouterProduit()){
            http_response_code(201);
            throw new Exception('Produit pas ajouté');
        }else{
            http_response_code(503);
            echo json_encode(array("message" => "Impossible de créer le Produit!"));
        }

    }else{
        echo 'validate ntm';
    }

}catch(Exception $e){
    $e->getMessage();
}
