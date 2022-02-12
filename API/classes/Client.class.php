<?php
include_once 'Utilisateur.class.php';

class Client extends Utilisateur
{

    private $nomTable = "dbo.Client";

    public $id;
    public $prenom;
    public $nom;
    public $dateNaissance;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
    public function constructeurClient()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Cli_Nom']) &&
            isset($decoded['Cli_Prenom'])
        ) {
            $this->nom  = $decoded['Cli_Nom'];
            $this->prenom = $decoded['Cli_Prenom'];
        } else {
            throw new ExceptionWithStatusCode('Objet Client incomplet', 400);
        }


        if (isset($decoded['Cli_DateNaissance'])) {
        } else {
            $this->dateNaissance  = null;
        }
    }

    public  function constructeurModificationClient(){

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
            isset($decoded['Cli_Nom']) &&
            isset($decoded['Cli_Prenom']) &&
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
            $this->nom = $decoded['Cli_Nom'];
            $this->prenom = $decoded['Cli_Prenom'];

            $this->validate();
    
        } else {
            // tell the user
            throw new ExceptionWithStatusCode('Modification : Objet CLIENT incomplet', 400);
        }
    
        if (isset($decoded['Cli_DateNaissance'])) {
            $this->dateNaissance  = $decoded['Cli_DateNaissance'];
            // $this->test_input($this->comp_adresse);
            // $this->length_string($this->comp_adresse);
        } else {
            $this->dateNaissance  = null;
        }

    }

    public function AjouterClient()
    {

        $this->AjouterUser();

        $Requete = "INSERT INTO dbo.Client (Cli_Nom, Cli_Prenom, Cli_DateNaissance, Cli_Rol_Id, Cli_Uti_Id)             
                VALUES (:Cli_Nom, :Cli_Prenom, :Cli_DateNaissance, 1, (SELECT Uti_Id from dbo.Utilisateur WHERE Uti_MailContact=:Uti_MailContact))";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Cli_Nom", $this->nom);
        $stmt->bindParam(":Cli_Prenom", $this->prenom);
        $stmt->bindParam(":Cli_DateNaissance", $this->dateNaissance);
        $stmt->bindParam(":Uti_MailContact", $this->mail);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution D\'ajout client');
        }
    }
    public function ObtenirClient()
    {

        $ReqClient = "SELECT * FROM dbo.View_Client WHERE Uti_Id=?";
        $id = $this->id_utilisateur;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetch();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function ObtenirTousClient()
    {

        $ReqClient = "SELECT * FROM dbo.View_Client";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, true);
    }
    public function ModifierClient()
    {



        $Requete = "UPDATE dbo.Client SET Cli_Nom=:Cli_Nom, Cli_Prenom=:Cli_Prenom, Cli_DateNaissance=:Cli_DateNaissance, Cli_Rol_Id=1  WHERE Cli_Uti_Id=:Cli_Uti_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Cli_Nom", $this->nom);
        $stmt->bindParam(":Cli_Prenom", $this->prenom);
        $stmt->bindParam(":Cli_DateNaissance", $this->dateNaissance);
        $stmt->bindParam(":Cli_Uti_Id", $this->id_utilisateur);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de CLIENT');
        }

        $this->ModifierUser();
    }

    public function SuprimerClient()
    {

        $VerifUti = "SELECT * FROM dbo.Client WHERE Cli_Uti_Id=?";
        $id = $this->id_utilisateur;
        $MailUti = $this->connexion->prepare($VerifUti);
        $MailUti->execute(array($id));

        $result = $MailUti->fetch();

        if (!$result) {
            throw new Exception('Suppression : Client a déjà été suprimé ou n\'existe pas');
        }

        $ReqFourn = "DELETE FROM dbo.Client WHERE Cli_Uti_Id=:Uti_Id";
        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Uti_Id", $this->id_utilisateur);


        if (!$MailVerif->execute()) {
            throw new Exception('Suppression : Id client incorrect');
        }

        $this->SuprimerUser();
    }
}
