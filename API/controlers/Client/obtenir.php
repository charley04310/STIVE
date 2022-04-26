<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Client.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$NewUtilisateur = new Client($BDD);


$content = file_get_contents("php://input");
$decoded = json_decode($content, true);

/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    if (isset($decoded['Uti_Id'])){

            $NewUtilisateur->id_utilisateur  = $decoded['Uti_Id'];
            $NewUtilisateur->ObtenirClient();
            http_response_code(201);
        
    }else{
       
        throw new ExceptionWithStatusCode('Variable Uti_Id inexistante', 400);
    }

}catch(ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";

}catch (Exception $e) {

    http_response_code(503);
    echo 'Exception with reçue : ',  $e->getMessage(), "\n";
}