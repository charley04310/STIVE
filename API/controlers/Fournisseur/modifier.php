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

$validationRequest = false;

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
        isset($decoded['Mail']) &&
        isset($decoded['NomDomaine']) &&
        isset($decoded['NomResp']) &&
        isset($decoded['TelResp']) &&
        isset($decoded['MailResp']) && 
        isset($decoded['id'])   ) {

        try {

            $UpdateUtilisateur->adresse  = $decoded['Adresse'];
            $UpdateUtilisateur->code_postal = $decoded['CodePostal'];
            $UpdateUtilisateur->ville = $decoded['Ville'];
            $UpdateUtilisateur->pays = $decoded['Pays'];
            $UpdateUtilisateur->tel = $decoded['Telephone'];
            $UpdateUtilisateur->password = password_hash($decoded['Mdp'], PASSWORD_DEFAULT);
            $UpdateUtilisateur->mail = $decoded['Mail'];
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
        $UpdateUtilisateur->comp_adresse  = $decoded['CompAdresse'];
       // $UpdateUtilisateur->test_input($UpdateUtilisateur->comp_adresse);
        // $UpdateUtilisateur->length_string($UpdateUtilisateur->comp_adresse);
    } else {
        $UpdateUtilisateur->comp_adresse  = null;
    }



    if($validationRequest === true){
        if($UpdateUtilisateur->AjouterUser()){
            http_response_code(201);
            echo 'felication felicia';
        }else{
            http_response_code(503);
        }

    }else{
        throw new Exception('Tous les champs ne sont pas remplis');
    }

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



            $UpdateFournisseur->nomDomaine  = $decoded['NomDomaine'];

            // to do 
            $UpdateFournisseur->nomDomaine = $UpdateFournisseur->test_input($UpdateFournisseur->nomDomaine);

            $UpdateFournisseur->length_string($UpdateFournisseur->nomDomaine);

            $UpdateFournisseur->nomResp = $decoded['NomResp'];
            $UpdateFournisseur->test_input($UpdateFournisseur->nomResp);
            $UpdateFournisseur->length_string($UpdateFournisseur->nomResp);

            $UpdateFournisseur->telResp = $decoded['TelResp'];
            $UpdateFournisseur->test_input($UpdateFournisseur->telResp);
            $UpdateFournisseur->length_string($UpdateFournisseur->telResp);

            $UpdateFournisseur->mailResp = $decoded['MailResp'];
            $UpdateFournisseur->test_input($UpdateFournisseur->mailResp);
            $UpdateFournisseur->length_string($UpdateFournisseur->mailResp);

            $ValidationUpdate = true;
        } else {
            // set response code - 400 bad request
           // http_response_code(400);
            // tell the user
            throw new Exception('Objet fournisseur incomplet');
        }
    } else {

        throw new Exception('Validation request PB');
    }




    if (isset($decoded['FonctionFou'])) {
        $UpdateFournisseur->fonction  = $decoded['FonctionFou'];
        $UpdateFournisseur->test_input($UpdateFournisseur->fonction);
        $UpdateFournisseur->length_string($UpdateFournisseur->fonction);
    } else {
        $UpdateFournisseur->fonction  = null;
    }



    if ($ValidationUpdate === true) {

        $UpdateFournisseur->ModifierFournisseur();
        http_response_code(201);
    
    } else {
        throw new Exception('Tous les champs de mise à jours fournisseur ne sont pas remplis');
    }
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    http_response_code(503);

}
