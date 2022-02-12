<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: DELETE"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$DeleteUtilisateur = null;
// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Fournisseur.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$DeleteUtilisateur = new Fournisseur($BDD);
$DeleteFournisseur = $DeleteUtilisateur;




try {

    if (
        isset($_GET['Uti_Id'])
    ){
        $DeleteUtilisateur->id_utilisateur  = $_GET['Uti_Id'];
    } else {
        throw new ExceptionWithStatusCode('Supression : Objet Utilisateur incomplet', 400);
    }
  
    $DeleteFournisseur->SupprimerFournisseur();
    http_response_code(201);
 

} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";

} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
}
