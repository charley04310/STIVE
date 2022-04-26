<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/ContenuInventaire.class.php';
include_once '../../classes/exceptions/APIException.class.php';

$Database = new Database();
$BDD = $Database->getConnexion();

$Inventaire = new ContenuInventaire($BDD);

try {


    $content = file_get_contents("php://input");
    $decoded = json_decode($content, true);

    // verifier si le coi_inv_id du decoded est null si oui créer un inventaire
    if ($Inventaire->getCoi_inv_id($decoded)) {

        $Inventaire->AjouterInventaire();

        foreach ($decoded as $key => $value) {
            //var_dump($decoded);
            //echo 'Utilisateur n°' .($nb++). ' :<br>';
            foreach ($value as $c => $v) {

                $Inventaire->constructeurContenuInventaire($c, $v);
            }

            $Inventaire->AjouterContenuIventaire();
        }

    } else {

        foreach ($decoded as $key => $value) {
             
         
            foreach ($value as $c => $v){
          
                $Inventaire->constructeurContenuInventaire($c, $v);

                if($c == "Coi_Pro_Id"){
                    $Inventaire->SupprimerContenuInventaire();
                }
           }

           $Inventaire->addContenuInventaire();   
             
        }
    }

    // boucle for each qui englobe la method ajouter contenu inventaire



    //$ContenuInventaire->AjouterContenuIventaire();
    //http_response_code(201);



} catch (ExceptionWithStatusCode $ews) {

    http_response_code(400);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
