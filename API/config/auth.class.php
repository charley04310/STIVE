<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    throw new Exception($e, 'invalid method');
}

if(isset($_SERVER['Authorization'])){
    $token = trim($_SERVER['Authorisation']);
}elseif(isset($_SERVER['HTTP_AUTHORIZATION'])){
    $token = trim($_SERVER['HTTP_AUTHORIZATION']);
}elseif(function_exists('apache_request_headers')){
    $requestHeaders = apache_request_headers();
    if(isset($requestHeaders['Authorization'])){
        $auth = trim($requestHeaders['Authorization']);
    }
}

if(!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)){

    http_response_code(400);
    throw new Exception($e, 'token introuvable');
    
}

// On extrait le token 

$token = str_replace('Bearer', '', $token);


$jwt = new JWT($BDD);

if(!$jwt->isValide($token)){
    http_response_code(400);
    throw new Exception('Probleme lors de la requete Modification de  Fournisseur');

}
/*if($jwt->check($token, SECRET)){
    http_response_code(403);
    throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
}*/
/*if($jwt->isExpired($token)){
    http_response_code(400);
    throw new Exception('Probleme lors de la requete Modification de  Fournisseur');

}*/


?>