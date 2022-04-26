<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Produit.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$NewProduit = new Produit($BDD);


/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    foreach ($_GET as $key => $value) {
        switch ($key) {
            case 'Pro_Id':

                $NewProduit->id_produit  = $_GET['Pro_Id'];
                $NewProduit->ObtenirProduit();
                http_response_code(201);
                break;

            case 'Pro_Fou_Id':

                $NewProduit->id_fournisseur  = $_GET['Pro_Fou_Id'];
                $NewProduit->ObtenirProduitByIdFournisseur();
                http_response_code(201);
                break;

            default:
            throw new ExceptionWithStatusCode('Variable Uti_Id ou Pro_Fou_Id inexistante', 400);
            break;
        }
    }


} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
} catch (Exception $e) {

    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}