<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/ContenuCommandeClient.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$NewUtilisateur = new ContenuCommandeClient($BDD);



/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    if (isset($_GET['Ccc_Coc_Id'])){

            $NewUtilisateur->id_commande_client = $_GET['Ccc_Coc_Id'];
            $NewUtilisateur->ObtenirContenuCommandeClientParIDCommandeClient();
            http_response_code(201);
        
    }else{
        
        $NewUtilisateur->ObtenirContenuCommandeClient();
        http_response_code(201);
    }

}catch(ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";

}catch (Exception $e) {

    http_response_code(503);
    echo 'Exception with reçue : ',  $e->getMessage(), "\n";
}
