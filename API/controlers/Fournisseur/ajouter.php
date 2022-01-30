<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$NewUtilisateur = null;
// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Fournisseur.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$NewUtilisateur = new Fournisseur($BDD);
$NewFournisseur = $NewUtilisateur;


/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    $NewUtilisateur->constructeurUtilisateur();
    $NewFournisseur->constructeurFournisseur();   
    $NewFournisseur->AjouterFournisseur();
    http_response_code(201);
    
} catch (ExceptionWithStatusCode $ews) {

    http_response_code(400);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";

} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";

}
