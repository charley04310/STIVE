<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD ET CLASS
include_once '../config/dbConnect.php';
include_once '../modeles/Vin.class.php';

// CONNEXION BASE DE DONNÉES
$Database = new Database();
$BDD = $Database->SeConnecter();

// CRÉATION DE L'OBJET VIN 
$vin = new Vin($BDD);

if (isset($_POST['NewVin']) && isset($_POST['NameVin'])) {

    //On range le nom du vin dans l'attribut de l'objet qui lui fait reférence 
    $vin->$nom = $_POST['NameVin'];

    if ($vin->ajouterVin()) {

        http_response_code(201);
        echo json_encode(array("message" => "Panier créé"));

    } else {

        http_response_code(503);
        echo json_encode(array("message" => "Impossible de créer le Panier!"));
    }
}



//------------------------------------------ Ou une autre méthode de gérer les $_POST['']----------------------------------------//

$addVin = $_POST[$var];

switch ($var) {
    
    case 'Blanc':
        echo "i égal 0";
        break;
    case 'Rouge':
        echo "i égal 1";
        break;
    case 'Rose':
        echo "i égal 2";
        break;
}


?>