<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Utilisateur.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();
// CRÉATION DE L'OBJET VIN 
$NewUtilisateur = new Utilisateur($BDD);

$validationRequest = false;

try{

    if( 
        isset($_POST['Adresse']) &&
        isset($_POST['CodePostal']) &&
        isset($_POST['Ville']) &&
        isset($_POST['Pays']) &&
        isset($_POST['Telephone']) &&
        isset($_POST['Mdp']) &&
        isset($_POST['Mail']) 
    ){

        try{

            $NewUtilisateur->adresse  = $_POST['Adresse'];
            $NewUtilisateur->test_input($NewUtilisateur->adresse);
            $NewUtilisateur->length_string($NewUtilisateur->adresse);


            $NewUtilisateur->code_postal = $_POST['CodePostal'];
            $NewUtilisateur->test_input($NewUtilisateur->code_postal);
            $NewUtilisateur->length_string($NewUtilisateur->code_postal);

            $NewUtilisateur->ville = $_POST['Ville'];
            $NewUtilisateur->test_input($NewUtilisateur->ville);
            $NewUtilisateur->length_string($NewUtilisateur->ville);

            $NewUtilisateur->pays = $_POST['Pays'];
            $NewUtilisateur->test_input($NewUtilisateur->pays);
            $NewUtilisateur->length_string($NewUtilisateur->pays);


            $NewUtilisateur->tel = $_POST['Telephone'];
            $NewUtilisateur->test_input($NewUtilisateur->tel);
            $NewUtilisateur->length_string($NewUtilisateur->tel);


            $NewUtilisateur->password = password_hash($_POST['Mdp'], PASSWORD_DEFAULT);
            $NewUtilisateur->test_input($NewUtilisateur->password);

            $NewUtilisateur->mail = $_POST['Mail'];
            $NewUtilisateur->mail = filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL);
            $NewUtilisateur->test_input($NewUtilisateur->mail);
            $NewUtilisateur->length_string($NewUtilisateur->mail);

            $validationRequest = true;

        }catch(Exception $e){
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
        

    }else{
        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        throw new Exception('Objet incomplet');
    }



    if(isset($_POST['CompAdresse'])){
        $NewUtilisateur->comp_adresse  = $_POST['CompAdresse'];
        $NewUtilisateur->test_input($NewUtilisateur->comp_adresse);
        $NewUtilisateur->length_string($NewUtilisateur->comp_adresse);

    }else{
        $NewUtilisateur->comp_adresse  = null;
    }



    if($validationRequest === true){
        if($NewUtilisateur->AjouterUser()){
            http_response_code(201);
            echo 'felication felicia';
        }else{
            http_response_code(503);
            throw new Exception('Probleme lors de l\'envoi de la requete');
        }

    }else{
        throw new Exception('Tous les champs ne sont pas remplis');
    }

}catch(Exception $e){
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
