<?php
include_once 'Utilisateur.class.php';

class Fournisseur extends Utilisateur
{
    private $nomTable = "dbo.Fournisseur";
    public $nomResp;
    public $id_fournisseur;
    public $telResp;
    public $mailResp;
    public $fonction;
    public $nomDomaine;

    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
    public function constructeurFournisseur()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Fou_NomDomaine']) &&
            isset($decoded['Fou_NomResp']) &&
            isset($decoded['Fou_TelResp']) &&
            isset($decoded['Fou_MailResp'])
        ) {
            $this->nomDomaine  = $decoded['Fou_NomDomaine'];
            $this->nomResp = $decoded['Fou_NomResp'];
            $this->telResp = $decoded['Fou_TelResp'];
            $this->mailResp = $decoded['Fou_MailResp'];
 

        } else {
            throw new ExceptionWithStatusCode('Objet fournisseur incomplet', 400);
        }
        if (isset($decoded['Fou_Fonction'])) {
            $this->fonction  = $decoded['Fou_Fonction'];
            //$this->test_input($this->fonction);
            //$this->length_string($this->fonction);
        } else {
            $this->fonction  = null;
        }
    }
    public  function constructeurModificationFournisseur(){

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Uti_Adresse']) &&
            isset($decoded['Uti_Cp']) &&
            isset($decoded['Uti_Ville']) &&
            isset($decoded['Uti_Pays']) &&
            isset($decoded['Uti_TelContact']) &&
            isset($decoded['Uti_Mdp']) &&
            isset($decoded['Uti_MailContact']) &&
            isset($decoded['Fou_NomDomaine']) &&
            isset($decoded['Fou_NomResp']) &&
            isset($decoded['Fou_TelResp']) &&
            isset($decoded['Fou_MailResp']) &&
            isset($decoded['Uti_Id']) 
        ) {
            $this->adresse  = $decoded['Uti_Adresse'];
            $this->code_postal = $decoded['Uti_Cp'];
            $this->ville = $decoded['Uti_Ville'];
            $this->pays = $decoded['Uti_Pays'];
            $this->tel = $decoded['Uti_TelContact'];
            $this->password = password_hash($decoded['Uti_Mdp'], PASSWORD_DEFAULT);
            $this->mail = $decoded['Uti_MailContact'];
            $this->id_utilisateur  = $decoded['Uti_Id'];
            //$this->mail = filter_var($decoded['Mail'], FILTER_VALIDATE_EMAIL);
            $this->nomDomaine  = $decoded['Fou_NomDomaine'];
            $this->nomResp = $decoded['Fou_NomResp'];
            $this->telResp = $decoded['Fou_TelResp'];
            $this->mailResp = $decoded['Fou_MailResp'];

            $this->validate();
    
        } else {
            // tell the user
            throw new ExceptionWithStatusCode('Modification : Objet Utilisateur incomplet', 400);
        }
    
        if (isset($decoded['Uti_CompAdresse'])) {
            $this->comp_adresse  = $decoded['Uti_CompAdresse'];
            // $this->test_input($this->comp_adresse);
            // $this->length_string($this->comp_adresse);
        } else {
            $this->comp_adresse  = null;
        }

        if (isset($decoded['Fou_Fonction'])) {
            $this->fonction  = $decoded['Fou_Fonction'];
            // $this->test_input($this->comp_adresse);
            // $this->length_string($this->comp_adresse);
        } else {
            $this->fonction  = null;
        }
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

            $Requete = "UPDATE dbo.Fournisseur SET Fou_NomDomaine=:Fou_NomDomaine, Fou_NomResp=:Fou_NomResp, Fou_TelResp=:Fou_TelResp, Fou_MailResp=:Fou_MailResp, Fou_Fonction=:Fou_Fonction WHERE Fou_Uti_Id=:Uti_Id";

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
                throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
            }

            $this->ModifierUser();
    }
    public function SupprimerFournisseur()
    {

        $VerifFourn = "SELECT * FROM dbo.Fournisseur WHERE Fou_Uti_Id=:Uti_Id";
        $id = $this->id_utilisateur;
        $IdFourn = $this->connexion->prepare($VerifFourn);
        $IdFourn->bindParam(":Uti_Id", $this->id_utilisateur);
        $IdFourn->execute(array($id));

        $resultat = $IdFourn->fetch();

        if (!$resultat) {
            throw new Exception('Suppression : Le founisseur a déjà été suprimé ou n\'existe pas');
        }

        $ReqFourn = "DELETE FROM dbo.Fournisseur WHERE Fou_Uti_Id=:Uti_Id";

        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Uti_Id", $this->id_utilisateur);


        if (!$MailVerif->execute()) {
            throw new Exception('Suppression : probleme lors de l\'execution');
        }

        $this->SuprimerUser();
    }
}
