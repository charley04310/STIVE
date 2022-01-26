<?php 

class Utilisateur {

    public $connexion;
    private $nomTable = "dbo.Utilisateur";


    public $nom;
    public $token;
    public $prenom;
    public $adresse;
    public $comp_adresse;
    public $tel;
    public $mail;
    public $code_postal;
    public $pays;
    public $password;
    public $verifyPassword;
    public $ville;
    public $dateCreation;


    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    function test_input($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    function length_int($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_int($data) === false){
                throw new Exception('Float attendu');
            }else{
                return $data;
            }
        }
    }


    function length_string($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_string($data) === false){
                throw new Exception('String attendu');
            }else{
                return $data;
            }
        }
        
    }


    function length_float($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_float($data) === false){
                throw new Exception('Float attendu');
            }else{
                return $data;
            }
        }
        
    }


    public function AjouterUser(){

        try{
        $MailReq = "SELECT * FROM dbo.Utilisateur WHERE Uti_MailContact=?";
        $mail = $this->mail;
        $MailVerif = $this->connexion->prepare($MailReq);
        $MailVerif->execute(array($mail));
        }catch(Exception $e){
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }

        if($MailVerif->fetch()){
            throw new Exception('Mail deja pris');

        }else{
                $Requete = "INSERT INTO dbo.Utilisateur (Uti_Adresse, Uti_CompAdresse, Uti_Cp, Uti_Ville, Uti_Pays, Uti_TelContact, Uti_Mdp, Uti_MailContact)
                VALUES (:Uti_Adresse, :Uti_CompAdresse, :Uti_Cp, :Uti_Ville, :Uti_Pays, :Uti_TelContact, :Uti_Mdp, :Uti_MailContact) ";

            // prepare query
            $stmt = $this->connexion->prepare($Requete);

            // bind values
            $stmt->bindParam(":Uti_Adresse", $this->adresse);
            $stmt->bindParam(":Uti_CompAdresse", $this->comp_adresse);
            $stmt->bindParam(":Uti_Cp", $this->code_postal);
            $stmt->bindParam(":Uti_Ville", $this->ville);
            $stmt->bindParam(":Uti_Pays", $this->pays);
            $stmt->bindParam(":Uti_TelContact", $this->tel);
            $stmt->bindParam(":Uti_Mdp", $this->password);
            $stmt->bindParam(":Uti_MailContact", $this->mail);       
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
       
           
       
    }
    public function ModifierUser(){

        $Requete = "UPDATE dbo.Utilisateur SET Uti_Adresse=:Uti_Adresse, Uti_CompAdresse=:Uti_CompAdresse, Uti_Cp=:Uti_Cp, Uti_Ville=:Uti_Ville, Uti_Pays=:Uti_Pays, Uti_TelContact=:Uti_TelContact, Uti_Mdp=:Uti_Mdp, Uti_MailContact=:Uti_MailContact";


    }
    
    public function SupprimerUser(){

    }

    public function ObtenirUser(){ 

        $MailReq = "SELECT * FROM dbo.Utilisateur WHERE Uti_MailContact=?";
        $mail = $this->mail;
        $MailVerif = $this->connexion->prepare($MailReq);
        $MailVerif->execute(array($mail));


    }

}