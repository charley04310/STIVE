<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$UpdateUtilisateur = null;
// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Fournisseur.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$UpdateUtilisateur = new Fournisseur($BDD);
$UpdateFournisseur = $UpdateUtilisateur;

$ValidationUpdate = false;

$content = file_get_contents("php://input");
$decoded = json_decode($content, true);


try {

    if (
        isset($decoded['Adresse']) &&
        isset($decoded['CodePostal']) &&
        isset($decoded['Ville']) &&
        isset($decoded['Pays']) &&
        isset($decoded['Telephone']) &&
        isset($decoded['Mdp']) &&
        isset($decoded['Mail']) &&
        isset($decoded['NomDomaine']) &&
        isset($decoded['NomResp']) &&
        isset($decoded['TelResp']) &&
        isset($decoded['MailResp']) &&
        isset($decoded['Uti_Id'])
    ) {
        $UpdateUtilisateur->adresse  = $decoded['Adresse'];
        $UpdateUtilisateur->code_postal = $decoded['CodePostal'];
        $UpdateUtilisateur->ville = $decoded['Ville'];
        $UpdateUtilisateur->pays = $decoded['Pays'];
        $UpdateUtilisateur->tel = $decoded['Telephone'];
        $UpdateUtilisateur->password = password_hash($decoded['Mdp'], PASSWORD_DEFAULT);
        $UpdateUtilisateur->mail = $decoded['Mail'];
        $UpdateUtilisateur->id_utilisateur  = $decoded['Uti_Id'];

        //$UpdateUtilisateur->mail = filter_var($decoded['Mail'], FILTER_VALIDATE_EMAIL);
        $UpdateFournisseur->nomDomaine  = $decoded['NomDomaine'];

        // to do 
        $UpdateFournisseur->nomDomaine = $UpdateFournisseur->test_input($UpdateFournisseur->nomDomaine);
        //$UpdateFournisseur->length_string($UpdateFournisseur->nomDomaine);
        $UpdateFournisseur->nomResp = $decoded['NomResp'];
        //$UpdateFournisseur->test_input($UpdateFournisseur->nomResp);
        //$UpdateFournisseur->length_string($UpdateFournisseur->nomResp);
        $UpdateFournisseur->telResp = $decoded['TelResp'];
        // $UpdateFournisseur->test_input($UpdateFournisseur->telResp);
        //$UpdateFournisseur->length_string($UpdateFournisseur->telResp);
        $UpdateFournisseur->mailResp = $decoded['MailResp'];
        //$UpdateFournisseur->test_input($UpdateFournisseur->mailResp);
        //$UpdateFournisseur->length_string($UpdateFournisseur->mailResp);
        $UpdateUtilisateur->validate();
        $ValidationUpdate = true;

    } else {
        // tell the user
        throw new ExceptionWithStatusCode('Modification : Objet Utilisateur incomplet', 400);
    }



    if (isset($decoded['CompAdresse'])) {
        $UpdateUtilisateur->comp_adresse  = $decoded['CompAdresse'];
        // $UpdateUtilisateur->test_input($UpdateUtilisateur->comp_adresse);
        // $UpdateUtilisateur->length_string($UpdateUtilisateur->comp_adresse);
    } else {
        $UpdateUtilisateur->comp_adresse  = null;
    }


    if ($ValidationUpdate === true) {

        $UpdateFournisseur->ModifierFournisseur();
        http_response_code(201);
        //echo 'top 1';

    } else {
        throw new Exception('Tous les champs de mise à jours fournisseur ne sont pas remplis');
    }
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    echo $e->getTraceAsString();
    http_response_code(503);
} catch (ExceptionWithStatusCode $ews) {

    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
    echo $ews->statusCode;
    http_response_code($ews->statusCode);
    // $protocol = $_SERVER['SERVER_PROTOCOL'];
    // header($protocol." ".$ews->statusCode." ".$ews->getMessage());
    // header("Status : 400 Bad request");

    var_dump(http_response_code());
    echo '15';
    //header("Status: 404 Not Found");

}
