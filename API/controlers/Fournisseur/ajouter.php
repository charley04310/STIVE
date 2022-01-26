<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/Fournisseur.class.php';
include_once '../Utilisateur/ajouter.php';

$ValidationFournisseur = false;

$NewFournisseur = new Fournisseur($BDD);



try{

    if($validationRequest === true){

        if( 
            isset($_POST['NomDomaine']) &&
            isset($_POST['NomResp']) &&
            isset($_POST['TelResp']) &&
            isset($_POST['MailResp'])
        ){

            try{

                $NewFournisseur->nomDomaine  = $_POST['NomDomaine'];
                $NewFournisseur->test_input($NewFournisseur->nomDomaine);
                $NewFournisseur->length_string($NewFournisseur->nomDomaine);

                $NewFournisseur->nomResp = $_POST['NomResp'];
                $NewFournisseur->test_input($NewFournisseur->nomResp);
                $NewFournisseur->length_string($NewFournisseur->nomResp);

                $NewFournisseur->telResp = $_POST['TelResp'];
                $NewFournisseur->test_input($NewFournisseur->telResp);
                $NewFournisseur->length_string($NewFournisseur->telResp);

                $NewFournisseur->mailResp = $_POST['MailResp'];
                $NewFournisseur->test_input($NewFournisseur->mailResp);
                $NewFournisseur->length_string($NewFournisseur->mailResp);

                $ValidationFournisseur = true;

            }catch(Exception $e){
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
            }
            

        }else{
            // set response code - 400 bad request
            http_response_code(400);
            // tell the user
            throw new Exception('Objet fournisseur incomplet');
        }


    }else{

        throw new Exception('Probleme code reponse');
    }

   


    if(isset($_POST['FonctionFou'])){
        $NewFournisseur->fonction  = $_POST['FonctionFou'];
        $NewFournisseur->test_input($NewFournisseur->fonction);
        $NewFournisseur->length_string($NewFournisseur->fonction);

    }else{
        $NewFournisseur->fonction  = null;
    }


    try{
        if($ValidationFournisseur === true){
            if($NewFournisseur->AjouterFournisseur()){
                http_response_code(201);
                echo 'Felicitation Félicia';
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

}catch(Exception $e){
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
