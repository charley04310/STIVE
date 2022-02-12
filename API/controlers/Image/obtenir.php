<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Image.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$NewImage = new Image($BDD);



try {

    if (isset($_GET['Pro_Id'])) {

        $NewImage->id_produit  = $_GET['Pro_Id'];
        $NewImage->ObtenirImage();
        http_response_code(201);
        
        
    } else {

        throw new ExceptionWithStatusCode('Variable IMG id  inexistante', 400);
    }
} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
} catch (Exception $e) {

    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
