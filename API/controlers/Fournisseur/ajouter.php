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

        try {

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
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
    } else {
        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        throw new Exception('Objet utilisateur incomplet');
    }



    if (isset($decoded['CompAdresse'])) {
        $NewUtilisateur->comp_adresse  = $decoded['CompAdresse'];
        $NewUtilisateur->test_input($NewUtilisateur->comp_adresse);
        $NewUtilisateur->length_string($NewUtilisateur->comp_adresse);
    } else {
        $NewUtilisateur->comp_adresse  = null;
    }



    /*if($validationRequest === true){
        if($NewUtilisateur->AjouterUser()){
            http_response_code(201);
            echo 'felication felicia';
        }else{
            http_response_code(503);
        }

    }else{
        throw new Exception('Tous les champs ne sont pas remplis');
    }*/
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    echo $e->getTraceAsString();
}

/****---------------------FOURNISSEUR VALIDATION  -----------------------------*/
try {

    if ($validationRequest === true) {

        if (
            isset($decoded['NomDomaine']) &&
            isset($decoded['NomResp']) &&
            isset($decoded['TelResp']) &&
            isset($decoded['MailResp'])
        ) {



            $NewFournisseur->nomDomaine  = $decoded['NomDomaine'];

            // to do 
            $NewFournisseur->nomDomaine = $NewFournisseur->test_input($NewFournisseur->nomDomaine);

            $NewFournisseur->length_string($NewFournisseur->nomDomaine);

            $NewFournisseur->nomResp = $decoded['NomResp'];
            $NewFournisseur->test_input($NewFournisseur->nomResp);
            $NewFournisseur->length_string($NewFournisseur->nomResp);

            $NewFournisseur->telResp = $decoded['TelResp'];
            $NewFournisseur->test_input($NewFournisseur->telResp);
            $NewFournisseur->length_string($NewFournisseur->telResp);

            $NewFournisseur->mailResp = $decoded['MailResp'];
            $NewFournisseur->test_input($NewFournisseur->mailResp);
            $NewFournisseur->length_string($NewFournisseur->mailResp);

            $ValidationFournisseur = true;
        } else {
            // set response code - 400 bad request
            http_response_code(400);
            // tell the user
            throw new Exception('Objet fournisseur incomplet');
        }
    } else {

        throw new Exception('Validation request PB');
    }




    if (isset($decoded['FonctionFou'])) {
        $NewFournisseur->fonction  = $decoded['FonctionFou'];
        $NewFournisseur->test_input($NewFournisseur->fonction);
        $NewFournisseur->length_string($NewFournisseur->fonction);
    } else {
        $NewFournisseur->fonction  = null;
    }



    if ($ValidationFournisseur === true) {
        if ($NewFournisseur->AjouterFournisseur()) {
            http_response_code(201);
            echo 'Felicitation Félicia';
        } else {
            http_response_code(503);
            // throw new Exception('Probleme lors de l\'envoi de la requete');
        }
    } else {
        throw new Exception('Tous les champs ne sont pas remplis');
    }
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
