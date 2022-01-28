<?php 
include_once 'Utilisateur.class.php';

class Fournisseur extends Utilisateur{

    public $connexion;
    private $nomTable = "dbo.Fournisseur";
    public $id;
    public $nomResp;
    public $telResp;
    public $mailResp;
    public $fonction;
    public $nomDomaine;

    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    
    public function ObtenirFournisseur(){

        $ReqFourn = "SELECT * FROM dbo.View_Fournisseur WHERE Uti_Id=?";
        $id = $this->id;
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetch();

        if(!$result){
            throw new Exception('Id Fournisseur incorrect');    
        }
        echo json_encode($result, JSON_PRETTY_PRINT);

    }


    public function ObtenirTousFournisseur(){

        $ReqFourn = "SELECT * FROM dbo.View_Fournisseur";
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if(!$result){
            throw new Exception('Id Fournisseur incorrect');    
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }


    public function AjouterFournisseur(){
        
        $ReqFourn = "SELECT * FROM dbo.Utilisateur WHERE Uti_MailContact=?";
        $mail = $this->mail;
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->execute(array($mail));

        if($MailVerif->fetch()){
            throw new Exception('Mail Fournisseur deja pris');
        }
            
        try{
                $this->AjouterUser();
                }catch(Exception $e){
                    echo 'Exception reçue : ',  $e->getMessage(), "\n";
                }
                $Requete = "INSERT INTO dbo.Fournisseur (Fou_NomDomaine, Fou_NomResp, Fou_TelResp, Fou_MailResp, Fou_Fonction, Fou_Rol_Id, Fou_Uti_Id)             
                VALUES (:Fou_NomDomaine, :Fou_NomResp, :Fou_TelResp, :Fou_MailResp, :Fou_Fonction, (SELECT Rol_Id from dbo.role WHERE Rol_Libelle='Fournisseur'), (SELECT Uti_Id from dbo.Utilisateur WHERE Uti_MailContact=:Uti_MailContact))";

            // prepare query
            $stmt = $this->connexion->prepare($Requete);

            // bind values
            $stmt->bindParam(":Fou_NomDomaine", $this->nomDomaine);
            $stmt->bindParam(":Fou_NomResp", $this->nomResp);
            $stmt->bindParam(":Fou_TelResp", $this->telResp);
            $stmt->bindParam(":Fou_MailResp", $this->mailResp);
            $stmt->bindParam(":Fou_Fonction", $this->fonction);
            $stmt->bindParam(":Uti_MailContact", $this->mail);    

            if(!$stmt->execute()){
                throw new Exception('Probleme lors de excecution de requete Fournisseur');
            }
        
       
    }
    public function ModifierFournisseur(){

        try{
            if($this->ModifierUser()){

                $Requete = "UPDATE dbo.Utilisateur SET Fou_NomDomaine=:Fou_NomDomaine, Fou_NomResp=:Fou_NomResp, Fou_TelResp=:Fou_TelResp, Fou_MailResp=:Fou_MailResp, Fou_Fonction=:Fou_Fonction WHERE Fou_Uti_Id=:Uti_Id";

                // bind new values
                $stmt = $this->connexion->prepare($Requete);
        
                    // bind values
                    $stmt->bindParam(":Fou_NomDomaine", $this->nomDomaine);
                    $stmt->bindParam(":Fou_NomResp", $this->nomResp);
                    $stmt->bindParam(":Fou_TelResp", $this->telResp);
                    $stmt->bindParam(":Fou_MailResp", $this->mailResp);
                    $stmt->bindParam(":Fou_Fonction", $this->fonction);
                    $stmt->bindParam(":Uti_Id", $this->id);

                    if($stmt->execute()){
                        return true ;
                    }
                    return false;
            }
        }catch(Exception $e){
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }       

    }
    

    
    public function SupprimerFournisseur(){
    }

    

}
