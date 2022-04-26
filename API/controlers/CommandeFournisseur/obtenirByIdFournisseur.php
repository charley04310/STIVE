<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/CommandeFournisseur.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$GetCommandeFournisseur = new CommandeFournisseur($BDD);


/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {
    if(isset($_GET['Cof_Fou_Id'])){
        $GetCommandeFournisseur->id_fournisseur = $_GET['Cof_Fou_Id'];
        $GetCommandeFournisseur->ObtenirCommandeParIDFournisseur();
        http_response_code(201);     
    }else{
        throw new Exception('Id Fournisseur incorrect ou vide');
    }
   
   
} catch (Exception $e) {

    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";


}
