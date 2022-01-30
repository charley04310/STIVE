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

$ValidationDelete = false;

$content = file_get_contents("php://input");
$decoded = json_decode($content, true);


try {

    if (
        isset($decoded['Uti_Id'])
    ){
        $DeleteUtilisateur->id_utilisateur  = $decoded['Uti_Id'];
        $ValidationDelete = true;

    } else {
        throw new ExceptionWithStatusCode('Supression : Objet Utilisateur incomplet', 400);
    }


    if ($ValidationDelete === true) {
        $DeleteFournisseur->SupprimerFournisseur();
        http_response_code(201);
    } 

} catch (Exception $e) {
    http_response_code(503);
   echo 'Exception reçue : ',  $e->getMessage(), "\n";

} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
}
