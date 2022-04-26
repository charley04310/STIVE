<?php
// on crée le header
const SECRET = 'KOkjBJHonj98HBgbvf7666JJIKJJBBHGzzze87766yh';
    
class JWT {

    public function GenerateToken(array $header, array $payload, string $secret /*int $validity = 86400*/) : string {

        /*if($validity > 0){
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;

        }*/
            // on encode en base 64
            
            $base64header = base64_encode(json_encode($header));
            $base64payload = base64_encode(json_encode($payload));
            
            // on nettoie les valeurs encodés
            
            $base64header = str_replace(['+','/','='], ['-', '_', ''], $base64header);
            $base64payload = str_replace(['+','/','='], ['-', '_', ''], $base64payload);
            
            
            // On génère la signature 
            $secret = base64_encode(SECRET);
            $signature = hash_hmac('sha256', $base64header . '.' . $base64payload, $secret, true);
            
            $signature = str_replace(['+','/','='], ['-', '_', ''], base64_encode($signature));
            // On crée le token 
            $token = array();
            $token = $base64header . '.' . $base64payload . '.' . $signature;

            return $token;
    }


    public function check(string $token, string $secret) : bool{

        // on recupere le header du token
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // on genere un token de verification
        $verifToken = $this->GenerateToken($header, $payload, $secret);
       

        return $token === $verifToken;
    }

    public function getHeader(string $token){
        // démontage token 
        $array = explode('.', $token);
        // on decode le header
        $header = json_decode(base64_decode($array[0]), true);
        return $header;
    }
   
    public function getPayload(string $token){
             // démontage token 
             $array = explode('.', $token);
             // on decode le header
             $payload = json_decode(base64_decode($array[1]), true);
             return $payload;
        
    }

    public function isExpired(string $token) : bool{
        
        $payload = $this->getPayload($token);
        $now = new DateTime();
        return $payload['exp'] < $now->getTimestamp();

    }

    public function isValide(string $token): bool {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }
}
