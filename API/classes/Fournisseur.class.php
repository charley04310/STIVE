<?php
include_once 'Utilisateur.class.php';

class Fournisseur extends Utilisateur
{

    private $nomTable = "dbo.Fournisseur";
    public $nomResp;
    public $telResp;
    public $mailResp;
    public $fonction;
    public $nomDomaine;

    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }


    public function ObtenirFournisseur()
    {

        $ReqFourn = "SELECT * FROM dbo.View_Fournisseur WHERE Uti_Id=?";
        $id = $this->id_utilisateur;
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetch();

        if (!$result) {
            throw new Exception('Id Fournisseur incorrect');
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }


    public function ObtenirTousFournisseur()
    {

        $ReqFourn = "SELECT * FROM dbo.View_Fournisseur";
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Fournisseur incorrect');
        }
        echo json_encode($result, true);
    }


    public function AjouterFournisseur()
    {
        $this->AjouterUser();

        $Requete = "INSERT INTO dbo.Fournisseur (Fou_NomDomaine, Fou_NomResp, Fou_TelResp, Fou_MailResp, Fou_Fonction, Fou_Rol_Id, Fou_Uti_Id)             
                VALUES (:Fou_NomDomaine, :Fou_NomResp, :Fou_TelResp, :Fou_MailResp, :Fou_Fonction, 2, (SELECT Uti_Id from dbo.Utilisateur WHERE Uti_MailContact=:Uti_MailContact))";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Fou_NomDomaine", $this->nomDomaine);
        $stmt->bindParam(":Fou_NomResp", $this->nomResp);
        $stmt->bindParam(":Fou_TelResp", $this->telResp);
        $stmt->bindParam(":Fou_MailResp", $this->mailResp);
        $stmt->bindParam(":Fou_Fonction", $this->fonction);
        $stmt->bindParam(":Uti_MailContact", $this->mail);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Fournisseur');
        }

    }
    public function ModifierFournisseur()
    {

        if ($this->ModifierUser()) {

            $Requete = "UPDATE dbo.Utilisateur SET Fou_NomDomaine=:Fou_NomDomaine, Fou_NomResp=:Fou_NomResp, Fou_TelResp=:Fou_TelResp, Fou_MailResp=:Fou_MailResp, Fou_Fonction=:Fou_Fonction WHERE Fou_Uti_Id=:Uti_Id";

            // bind new values
            $stmt = $this->connexion->prepare($Requete);

            // bind values
            $stmt->bindParam(":Fou_NomDomaine", $this->nomDomaine);
            $stmt->bindParam(":Fou_NomResp", $this->nomResp);
            $stmt->bindParam(":Fou_TelResp", $this->telResp);
            $stmt->bindParam(":Fou_MailResp", $this->mailResp);
            $stmt->bindParam(":Fou_Fonction", $this->fonction);
            $stmt->bindParam(":Uti_Id", $this->id_utilisateur);

            if (!$stmt->execute()) {
                throw new Exception('Probleme lors de la requete modification de  Fournisseur');
            }
        }
    }



    public function SupprimerFournisseur()
    {
    }
}
