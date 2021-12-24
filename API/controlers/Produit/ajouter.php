<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD ET CLASS
include_once '../config/dbConnect.php';
include_once '../classes/TypeProduit.class.php';
include_once '../classes/exceptions/APIException.class.php';


// CRÉATION DE L'OBJET VIN 
$TypeProduit = new TypeProduit($BDD);

// exemple de controle
if (isset($_POST['NewTypePorduit'])) {

    //On range le nom du vin dans l'attribut de l'objet qui lui fait reférence 
    $TypeProduit->$type_libelle  = $_POST['NewTypePorduit'];

    if ($TypeProduit->AddTypeProduit($type_libelle)) {

        http_response_code(201);
        echo json_encode(array("message" => "Produit Ajouté"));

    } else {

        throw new Exception($e);
    }
}else{
    throw new InputVideException($e);

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