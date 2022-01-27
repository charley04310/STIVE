<?php 
include_once 'Utilisateur.class.php';

class Fournisseur extends Utilisateur{

    public $connexion;
    private $nomTable = "dbo.Fournisseur";
    public $nomResp;
    public $telResp;
    public $mailResp;
    public $fonction;
    public $nomDomaine;

    public function __construct($BDD) {
        $this->connexion = $BDD;
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
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        
       
           
       
    }
    public function ModifierFournisseur(){

        $Requete = "UPDATE dbo.Utilisateur SET Uti_Adresse=:Uti_Adresse, Uti_CompAdresse=:Uti_CompAdresse, Uti_Cp=:Uti_Cp, Uti_Ville=:Uti_Ville, Uti_Pays=:Uti_Pays, Uti_TelContact=:Uti_TelContact, Uti_Mdp=:Uti_Mdp, Uti_MailContact=:Uti_MailContact";


    }
    

    
    public function SupprimerFournisseur(){
    }

    public function ObtenirFournisseur(){
    }

}
