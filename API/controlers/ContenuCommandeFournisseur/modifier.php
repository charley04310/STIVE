<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT"); // On renseigne le type de requete autorisé
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ON INCLUT CONNEXION BDD ET CLASS
include_once '../../config/dbConnect.class.php';
include_once '../../classes/ContenuCommandeFournisseur.class.php';
include_once '../../classes/exceptions/APIException.class.php';
require_once '../../classes/Jwt.class.php';


$Database = new Database();
$BDD = $Database->getConnexion();

$UpdateContenuCommandeFournisseur = new ContenuCommandeFournisseur($BDD);

$jwt = new JWT();



try {


   /* if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        http_response_code(405);
        throw new Exception('Méthode incorrect');
    }

    if (isset($_SERVER['Authorization'])) {
        $token = trim($_SERVER['Authorisation']);
      
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $token = trim($_SERVER['HTTP_AUTHORIZATION']);
     
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        if (isset($requestHeaders['Authorization'])) {
            $token = trim($requestHeaders['Authorization']);          
        }
    }

    if (!isset($token) || !preg_match('/Bearer\s(\S+)/',$token,$matches)) {

       // http_response_code(400);
        throw new Exception('Token introuvable');
    }
  
    $token = str_replace('Bearer', '', $token);
    $token = str_replace(' ', '', $token);
   


    if(!$jwt->check($token, SECRET)){
        throw new Exception('SIGNATURE API NON VALIDE');
       // http_response_code(403);
    }

   // echo json_encode($jwt->getPayload($token));*/


    $UpdateContenuCommandeFournisseur->SetUpdateContenuCommande();
    http_response_code(201);

} catch (Exception $e) {
    //echo $e->getTraceAsString();
    http_response_code(503);
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
} catch (ExceptionWithStatusCode $ews) {

    http_response_code($ews->statusCode);
    echo 'Exception with status reçue : ',  $ews->getMessage(), "\n";
}
