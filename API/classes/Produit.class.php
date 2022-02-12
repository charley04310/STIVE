<?php
include_once 'Fournisseur.class.php';

class Produit extends Fournisseur
{

    public $connexion;
    private $nomTable = "dbo.Produit";

    public $id_produit;
    public $pro_nom;
    public $type_id;
    public $reference;
    public $fournisseur;
    public $pro_cepage;
    public $pro_anne;
    public $pro_prix;
    public $pro_prixlitre;
    public $pro_seuil;
    public $pro_quantite;
    public $pro_volume;
    public $pro_description;
    public $pro_CommandeAuto;

    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }

    public function constructeurProduit()
    {



        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Pro_Nom']) &&
            isset($decoded['Pro_Typ_Id']) &&
            isset($decoded['Pro_Fou_Id']) &&
            isset($decoded['Pro_Quantite']) &&
            isset($decoded['Pro_CommandeAuto']) &&
            isset($decoded['Pro_Prix'])

        ) {
            $this->nom  = $decoded['Pro_Nom'];
            $this->type_id = $decoded['Pro_Typ_Id'];
            $this->id_fournisseur = $decoded['Pro_Fou_Id'];
            $this->quantite = $decoded['Pro_Quantite'];
            $this->pro_CommandeAuto = $decoded['Pro_CommandeAuto'];
            $this->prix = $decoded['Pro_Prix'];
        } else {
            throw new ExceptionWithStatusCode('Objet Produit incomplet', 400);
        }

        // ameliorer les répétitions !!!!! 

        if (isset($decoded['Pro_Ref'])) {
            $this->reference  = $decoded['Pro_Ref'];
        } else {
            $this->reference  = null;
        }

        if (isset($decoded['Pro_PrixLitre'])) {
            $this->prixlitre  = $decoded['Pro_PrixLitre'];
        } else {
            $this->prixlitre  = null;
        }

        if (isset($decoded['Pro_Cepage'])) {
            $this->cepage = $decoded['Pro_Cepage'];
        } else {
            $this->cepage  = null;
        }

        if (isset($decoded['Pro_Annee'])) {
            $this->anne = $decoded['Pro_Annee'];
        } else {
            $this->anne  = null;
        }

        if (isset($decoded['Pro_SeuilAlerte'])) {
            $this->seuil = $decoded['Pro_SeuilAlerte'];
        } else {
            $this->seuil  = null;
        }

        if (isset($decoded['Pro_Volume'])) {
            $this->volume = $decoded['Pro_Volume'];
        } else {
            $this->volume  = null;
        }


        if (isset($decoded['Pro_Description'])) {
            $this->description = $decoded['Pro_Description'];
        } else {
            $this->description  = null;
        }
    }

    public function constructeurModificationProduit()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Pro_Nom']) &&
            isset($decoded['Pro_Typ_Id']) &&
            isset($decoded['Pro_Fou_Id']) &&
            isset($decoded['Pro_Quantite']) &&
            isset($decoded['Pro_CommandeAuto']) &&
            isset($decoded['Pro_Prix'])&&
            isset($decoded['Pro_Ref']) &&
            isset($decoded['Pro_PrixLitre'])&&
            isset($decoded['Pro_Cepage'])&&
            isset($decoded['Pro_Annee'])&&
            isset($decoded['Pro_SeuilAlerte'])&&
            isset($decoded['Pro_Volume'])


        ) {
            $this->nom  = $decoded['Pro_Nom'];
            $this->type_id = $decoded['Pro_Typ_Id'];
            $this->id_fournisseur = $decoded['Pro_Fou_Id'];
            $this->quantite = $decoded['Pro_Quantite'];
            $this->pro_CommandeAuto = $decoded['Pro_CommandeAuto'];
            $this->prix = $decoded['Pro_Prix'];
        } else {
            throw new ExceptionWithStatusCode('Objet Produit incomplet', 400);
        }
    }

    public function AjouterProduit()
    {

        $Requete = "INSERT INTO dbo.Produit (Pro_Nom, Pro_Typ_Id, Pro_Ref, Pro_Fou_Id, Pro_Cepage, Pro_Annee, Pro_Prix,
        Pro_PrixLitre, Pro_SeuilAlerte, Pro_Quantite, Pro_Volume, Pro_Description, Pro_CommandeAuto)   

        VALUES (:Pro_Nom, :Pro_Typ_Id, :Pro_Ref, :Pro_Fou_Id, :Pro_Cepage, :Pro_Annee, :Pro_Prix,
        :Pro_PrixLitre, :Pro_SeuilAlerte, :Pro_Quantite, :Pro_Volume, :Pro_Description, :Pro_CommandeAuto) ";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);



        // bind values
        $stmt->bindParam(":Pro_Nom", $this->pro_nom);
        $stmt->bindParam(":Pro_Typ_Id",  $this->type_id);
        $stmt->bindParam(":Pro_Ref", $this->reference);
        $stmt->bindParam(":Pro_Fou_Id", $this->id_fournisseur);
        $stmt->bindParam(":Pro_Cepage", $this->pro_cepage);
        $stmt->bindParam(":Pro_Annee", $this->pro_anne);
        $stmt->bindParam(":Pro_Prix", $this->pro_prix);
        $stmt->bindParam(":Pro_PrixLitre", $this->pro_prixlitre);
        $stmt->bindParam(":Pro_SeuilAlerte", $this->pro_seuil);
        $stmt->bindParam(":Pro_Quantite", $this->pro_quantite);
        $stmt->bindParam(":Pro_Volume", $this->pro_volume);
        $stmt->bindParam(":Pro_Description", $this->pro_description);
        $stmt->bindParam(":Pro_CommandeAuto", $this->pro_CommandeAuto);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Produit');
        }
    }


    public function SupprimerProduit()
    {

        $VerifFourn = "SELECT * FROM dbo.Produit WHERE Pro_Id=:Pro_Id";
        $id = $this->id_produit;
        $IdFourn = $this->connexion->prepare($VerifFourn);
        $IdFourn->bindParam(":Pro_Id", $this->id_produit);
        $IdFourn->execute(array($id));

        $resultat = $IdFourn->fetch();

        if (!$resultat) {
            throw new Exception('Suppression : Le produit a déjà été suprimé ou n\'existe pas');
        }

        $ReqFourn = "DELETE FROM dbo.Produit WHERE Pro_Id=:Pro_Id";

        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Pro_Id", $this->id_produit);


        if (!$MailVerif->execute()) {
            throw new Exception('Suppression produit : probleme lors de l\'execution');
        }

    }

    public function ObtenirProduit()
    {

        $ReqClient = "SELECT * FROM dbo.View_Produit WHERE Pro_Id=?";
        $id = $this->id_produit;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, true);
    }
    public function ObtenirTousProduit()
    {

        $ReqClient = "SELECT * FROM dbo.View_Produit";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, true);
    }

    public function ModifierProduit()
    {

        $Requete = "UPDATE dbo.Produit SET Pro_Nom=:Pro_Nom, Pro_Typ_Id=:Pro_Typ_Id, Pro_Ref=:Pro_Ref, Pro_Fou_Id=:Pro_Fou_Id, Pro_Cepage=:Pro_Cepage, Pro_Annee=:Pro_Annee, Pro_Prix=:Pro_Prix, Pro_PrixLitre=:Pro_PrixLitre, Pro_SeuilAlerte=:Pro_SeuilAlerte, Pro_Quantite=:Pro_Quantite, Pro_Volume=:Pro_Volume, Pro_Description=:Pro_Description, Pro_CommandeAuto=:Pro_CommandeAuto WHERE Pro_Id=:Pro_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Pro_Nom", $this->nomDomaine);
        $stmt->bindParam(":Pro_Typ_Id", $this->nomResp);
        $stmt->bindParam(":Pro_Ref", $this->telResp);
        $stmt->bindParam(":Pro_Fou_Id", $this->mailResp);
        $stmt->bindParam(":Pro_Cepage", $this->fonction);
        $stmt->bindParam(":Pro_Annee", $this->id_utilisateur);

        $stmt->bindParam(":Pro_Prix", $this->nomDomaine);
        $stmt->bindParam(":Pro_PrixLitre", $this->nomResp);
        $stmt->bindParam(":Pro_SeuilAlerte", $this->telResp);
        $stmt->bindParam(":Pro_Quantite", $this->mailResp);
        $stmt->bindParam(":Pro_Volume", $this->fonction);
        $stmt->bindParam(":Pro_Description", $this->id_utilisateur);
        $stmt->bindParam(":Pro_CommandeAuto", $this->id_utilisateur);
        $stmt->bindParam(":Pro_Id", $this->id_utilisateur);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
        }
    }
}
