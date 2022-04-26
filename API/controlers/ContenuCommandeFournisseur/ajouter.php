<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/ContenuCommandeFournisseur.class.php';
include_once '../../classes/CommandeFournisseur.class.php';

include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$NewContenuCommandeFournisseur = new ContenuCommandeFournisseur($BDD);
$CommandeFournisseur = new CommandeFournisseur($BDD);



/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {

    $content = file_get_contents("php://input");
    $decoded = json_decode($content, true);



    if(isset($decoded[0]['Ccf_Cof_Id']) && $decoded[0]['Ccf_Cof_Id'] != 0){
        //mise a jour de la commande fournisseur : statut de la commande
        $CommandeFournisseur->co_etat = $decoded[0]['Eta_Id'];
        $CommandeFournisseur->id_commande = $decoded[0]['Ccf_Cof_Id'];
      
        $CommandeFournisseur->ModifierStatuCommandeFournisseur();
        http_response_code(201);

    }else{

        if(isset($decoded[0]['Cof_Fou_Id']) && isset($decoded[0]['Eta_Id'] )){
            $CommandeFournisseur->id_fournisseur = $decoded[0]['Cof_Fou_Id'];
            $CommandeFournisseur->co_etat = $decoded[0]['Eta_Id'];
            $CommandeFournisseur->AjouterCommandeFournisseur();
        
            
            }else{
                throw new Exception('Des champs manquent pour l\'ajout de de commande');
            }
        
        
            foreach ($decoded as $key => $value) {
                //var_dump($decoded);
                //echo 'Utilisateur n°' .($nb++). ' :<br>';
                foreach ($value as $c => $v) {
                    $NewContenuCommandeFournisseur->SetContenuCommande($c, $v);
                }

                $NewContenuCommandeFournisseur->RequeteSelectCourantCommande();

                if(!$NewContenuCommandeFournisseur->RequeteAjouterContenuCommandeFournisseur()){
                    throw new ExceptionWithStatusCode('Erreur lors de l\'ajout du contenu de la commande', 400);
                }
            }
           
            http_response_code(201);

    }



    
    
} catch (ExceptionWithStatusCode $ews) {

    http_response_code(400);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";

} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";

}
