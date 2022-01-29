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

// CRÉATION DE L'OBJET VIN 
// $NewUtilisateur = new Utilisateur($BDD);

$validationRequest = false;
$ValidationFournisseur = false;

/*var_dump($_POST);
echo '***************************';
var_dump(file_get_contents('php://input'));
echo '***************************';
die;*/

$content = file_get_contents("php://input");
$decoded = json_decode($content, true);

/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    if (
        isset($decoded['Adresse']) &&
        isset($decoded['CodePostal']) &&
        isset($decoded['Ville']) &&
        isset($decoded['Pays']) &&
        isset($decoded['Telephone']) &&
        isset($decoded['Mdp']) &&
        isset($decoded['Mail'])
    ) {
        $NewUtilisateur->adresse  = $decoded['Adresse'];
        $NewUtilisateur->code_postal = $decoded['CodePostal'];
        $NewUtilisateur->ville = $decoded['Ville'];
        $NewUtilisateur->pays = $decoded['Pays'];
        $NewUtilisateur->tel = $decoded['Telephone'];
        $NewUtilisateur->password = password_hash($decoded['Mdp'], PASSWORD_DEFAULT);
        $NewUtilisateur->mail = $decoded['Mail'];
        //$NewUtilisateur->mail = filter_var($decoded['Mail'], FILTER_VALIDATE_EMAIL);
        $NewUtilisateur->validate();
        $validationRequest = true;
    } else {

        throw new ExceptionWithStatusCode('Objet Utilisatrice incomplet', 400);
    }



    if (isset($decoded['CompAdresse'])) {
        $NewUtilisateur->comp_adresse  = $decoded['CompAdresse'];
        //$NewUtilisateur->test_input($NewUtilisateur->comp_adresse);
        //$NewUtilisateur->length_string($NewUtilisateur->comp_adresse);
    } else {
        $NewUtilisateur->comp_adresse  = null;
    }

    /****---------------------FOURNISSEUR VALIDATION  -----------------------------*/


    if ($validationRequest === true) {

        if (
            isset($decoded['NomDomaine']) &&
            isset($decoded['NomResp']) &&
            isset($decoded['TelResp']) &&
            isset($decoded['MailResp'])
        ) {

            $NewFournisseur->nomDomaine  = $decoded['NomDomaine'];

            // to do 
            // $NewFournisseur->nomDomaine = $NewFournisseur->test_input($NewFournisseur->nomDomaine);

            //$NewFournisseur->length_string($NewFournisseur->nomDomaine);

            $NewFournisseur->nomResp = $decoded['NomResp'];
            // $NewFournisseur->test_input($NewFournisseur->nomResp);
            //$NewFournisseur->length_string($NewFournisseur->nomResp);

            $NewFournisseur->telResp = $decoded['TelResp'];
            //$NewFournisseur->test_input($NewFournisseur->telResp);
            //$NewFournisseur->length_string($NewFournisseur->telResp);

            $NewFournisseur->mailResp = $decoded['MailResp'];
            //$NewFournisseur->test_input($NewFournisseur->mailResp);
            //$NewFournisseur->length_string($NewFournisseur->mailResp);

            $ValidationFournisseur = true;
        } else {

            throw new ExceptionWithStatusCode('Objet fournisseur incomplet', 400);
        }
    } else {

        throw new Exception('Validation request False');
    }


    if (isset($decoded['FonctionFou'])) {
        $NewFournisseur->fonction  = $decoded['FonctionFou'];
        //$NewFournisseur->test_input($NewFournisseur->fonction);
        //$NewFournisseur->length_string($NewFournisseur->fonction);
    } else {
        $NewFournisseur->fonction  = null;
    }


    if ($ValidationFournisseur === true) {
        $NewFournisseur->AjouterFournisseur();
        http_response_code(201);
    } else {
        throw new Exception('Tous les champs ne sont pas remplis');
    }

} catch (ExceptionWithStatusCode $ews) {

    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
    echo $ews->statusCode;
    http_response_code(400);
   // $protocol = $_SERVER['SERVER_PROTOCOL'];
   // header($protocol." ".$ews->statusCode." ".$ews->getMessage());
   // header("Status : 400 Bad request");

    var_dump(http_response_code());
    echo '15';
    //header("Status: 404 Not Found");

} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    http_response_code(503);
}
