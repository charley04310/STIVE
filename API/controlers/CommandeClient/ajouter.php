<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/CommandeClient.class.php';
include_once '../../classes/ContenuCommandeClient.class.php';
include_once '../../classes/exceptions/APIException.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$CommandeClient = new CommandeClient($BDD);

$ContenuCommandeClient = new ContenuCommandeClient($BDD);



/****--------------------- UTILISATEUR VALIDATION  -----------------------------*/

try {


    $content = file_get_contents("php://input");
    $decoded = json_decode($content, true);


    if (isset($decoded[0]['Uti_MailContact'])) {

        $CommandeClient->constructeurCommandeClient($decoded);


        if ($CommandeClient->obtenirUtilisateur()) {


            if (isset($decoded[0]['Uti_CompAdresse'])) {
                $CommandeClient->comp_adresse =  $decoded[0]['Uti_CompAdresse'];
            }

            $CommandeClient->ModifierUser();

            if (isset($decoded[0]['Coc_Cli_Id'])) {

                $CommandeClient->id_client = $decoded[0]['Coc_Cli_Id'];

                if (isset($decoded[0]['Coc_Id'])) {

                    if ($decoded[0]['Coc_Id'] == 0) {
                        
                        $CommandeClient->AjouterCommandeClient();

                        $ContenuCommandeClient->ObtenirDerniereCommandeClient();
                        $ContenuCommandeClient->AjouterContenuCommandeClient($decoded);

                      

                    } else {

                        if (isset($decoded[0]['Coc_Eta_Id'])) {
                            $CommandeClient->id_commande_client = $decoded[0]['Coc_Id'];
                            $CommandeClient->etat_commande_client = $decoded[0]['Coc_Eta_Id'];
                            $CommandeClient->ModifierStatuCommandeClient();

                        } else {
                            throw new ExceptionWithStatusCode('Objet Coc_Eta_Id incomplet', 400);
                        }
                    }
                }
            } else {

                $CommandeClient->ObtenirIdClient();
                $CommandeClient->AjouterCommandeClient();

                $ContenuCommandeClient->ObtenirDerniereCommandeClient();
                $ContenuCommandeClient->AjouterContenuCommandeClient($decoded);
            }
        } else {

            if (!isset($decoded[0]['Uti_CompAdresse'])) {
                $CommandeClient->comp_adresse = null;
            }

            $CommandeClient->AjouterUser();
            $CommandeClient->AjouterClient();

            $CommandeClient->obtenirUtilisateur();

            $CommandeClient->ObtenirIdClient();
            $CommandeClient->AjouterCommandeClient();
          


            $ContenuCommandeClient->ObtenirDerniereCommandeClient();
            $ContenuCommandeClient->AjouterContenuCommandeClient($decoded);
        }
    } else {

        throw new Exception('Mail inexistant merci de renseigner tous les champs');
    }
} catch (ExceptionWithStatusCode $ews) {

    http_response_code(400);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
} catch (Exception $e) {
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
