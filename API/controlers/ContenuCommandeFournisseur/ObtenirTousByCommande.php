<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/ContenuCommandeFournisseur.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$GetCommandeFournisseur = new ContenuCommandeFournisseur($BDD);


/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    $GetCommandeFournisseur->GetContenuCommandeByIdCommande();
    http_response_code(201);     
   
} catch (Exception $e) {

    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";


}