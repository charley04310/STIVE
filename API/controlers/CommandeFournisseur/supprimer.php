<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: DELETE"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/CommandeFournisseur.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$DeleteCommandeFournisseur = new CommandeFournisseur($BDD);




try {

    if (isset($_GET['Cof_Id'])){

        $DeleteCommandeFournisseur->id_commande = $_GET['Cof_Id'];

    } else {
        throw new ExceptionWithStatusCode('Supression : Objet Utilisateur incomplet', 400);
    }
  
    $DeleteCommandeFournisseur->SupprimerCommandeFournisseur();
    http_response_code(201);
 

} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";

} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
}
