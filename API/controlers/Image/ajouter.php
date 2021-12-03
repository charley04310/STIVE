<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ON INCLUT CONNEXION BDD /  CLASSES / EXCEPTIONS
include_once '../config/dbConnect.php';
include_once '../classes/Image.class.php';
include_once '../classes/exceptions/APIException.class.php';



// CRÉATION DE L'OBJET VIN 
$image = new Image($BDD);

// exemple de controle
if (isset($_POST['NewImage'])) {

    //On range le nom du vin dans l'attribut de l'objet qui lui fait reférence 
    $image->$nom  = $_POST['NewImage'];

    if ($TypeProduit->AddImage()) {

        http_response_code(201);
        echo json_encode(array("message" => "Ajouté"));

    } else {
        // On se jete une petite excepetion si jamais y'a un probleme avec la requete SQL
        throw new Exception($error);
    }
}else{
        // On se jete une petite excepetion si jamais y'a un probleme le input
        throw new InputVideException($error);
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
