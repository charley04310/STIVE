<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Fournisseur.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$NewUtilisateur = new Fournisseur($BDD);
$NewFournisseur = $NewUtilisateur;


$content = file_get_contents("php://input");

/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    if (
        isset($_GET['Uti_Id'])
    ) {

            $NewUtilisateur->id  = $_GET['Uti_Id'];
            $NewUtilisateur->ObtenirFournisseur();
            http_response_code(201);
        
    }else{
        throw new Exception('Objet Uti_id null');
    }

} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    http_response_code(503);
    echo $e->getTraceAsString();
}
