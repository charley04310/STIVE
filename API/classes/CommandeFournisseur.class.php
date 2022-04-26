<?php
include_once 'Fournisseur.class.php';


class CommandeFournisseur extends Fournisseur
{

    public $connexion;
    public $co_etat;
    public $co_dateCrea;
    public $co_dateMaj;

    public $id_commande;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }

    public function SetModificationCommandeFournisseur(){

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Cof_Id']) &&
            isset($decoded['Cof_Fou_Id']) &&
            isset($decoded['Cof_Eta_Id']) 
        ) {
            $this->id_commande = $decoded['Cof_Id'];
            $this->id_fournisseur = $decoded['Cof_Fou_Id'];
            $this->co_etat= $decoded['Cof_Eta_Id'];
        }else{
            throw new Exception('Objet Contenu commande fournisseur imcomplet : SetModifCCF');

        }

    }

    public function AjouterCommandeFournisseur()
    {

        $Requete = "INSERT INTO dbo.CommandeFournisseur (Cof_Fou_Id, Cof_Eta_Id)   
        VALUES (:Cof_Fou_Id, :Cof_Eta_Id) ";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Cof_Fou_Id", $this->id_fournisseur);
        $stmt->bindParam(":Cof_Eta_Id",  $this->co_etat);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Produit');
        }
    }

    public function ObtenirCommandeParIDFournisseur()
    {

        $ReqClient = "SELECT * FROM dbo.View_CommandeFournisseur WHERE Cof_Fou_Id=?";
        $id = $this->id_fournisseur;
        $MailVerif = $this->connexion->prepare($ReqClient);-
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function ObtenirToutesCommandesFournisseur()
    {

        $ReqClient = "SELECT * FROM dbo.View_CommandeFournisseur";
        $MailVerif = $this->connexion->prepare($ReqClient);


        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function ObtenirCommandeParIDCommande()
    {

        $ReqClient = "SELECT * FROM dbo.CommandeFournisseur WHERE Cof_Id=?";
        $id = $this->id_commande;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function SupprimerCommandeFournisseur(){

        $ReqCommandeFournisseur = "DELETE FROM dbo.ContenuCommandeFournisseur WHERE Ccf_Cof_Id=:Ccf_Cof_Id";
        
        $ConnCommandeFournisseur = $this->connexion->prepare($ReqCommandeFournisseur);
        $ConnCommandeFournisseur->bindParam(":Ccf_Cof_Id", $this->id_commande);
        $ConnCommandeFournisseur->execute();

        $ReqFourn = "DELETE FROM dbo.CommandeFournisseur WHERE Cof_Id=:Cof_Id";

        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Cof_Id", $this->id_commande);

        if (!$MailVerif->execute()) {
            throw new Exception('Suppression produit : probleme lors de l\'execution');
        }
    }

    public function ModifierStatuCommandeFournisseur(){
       
        $Requete = "UPDATE dbo.CommandeFournisseur SET Cof_Eta_Id=:Cof_Eta_Id WHERE Cof_Id=:Cof_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Cof_Eta_Id", $this->co_etat);
        $stmt->bindParam(":Cof_Id", $this->id_commande);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
        }



    }
}
