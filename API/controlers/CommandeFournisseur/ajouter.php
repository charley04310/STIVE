<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/CommandeFournisseur.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$CommandeFournisseur = new CommandeFournisseur($BDD);



/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    
    $content = file_get_contents("php://input");
    $decoded = json_decode($content, true);
    
    if(isset($decoded['Cof_Fou_Id']) && isset($decoded['Cof_Eta_Id'] )){
    $CommandeFournisseur->id_fournisseur = $decoded['Cof_Fou_Id'];
    $CommandeFournisseur->co_etat = $decoded['Cof_Eta_Id'];
    $CommandeFournisseur->AjouterCommandeFournisseur();
    http_response_code(201);
    
    }else{
        throw new Exception('Des champs manquent pour l\'ajout de de commande');
    }


} catch (ExceptionWithStatusCode $ews) {

    http_response_code(400);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";

} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";

}
