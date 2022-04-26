<?php
include_once 'Fournisseur.class.php';

class Produit extends Fournisseur
{

    public $connexion;
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
    public $isWeb;
    public $pro_CommandeAuto;
    public $pro_quantite_commande;

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
            $this->pro_nom  = $decoded['Pro_Nom'];
            $this->type_id = $decoded['Pro_Typ_Id'];
            $this->id_fournisseur = $decoded['Pro_Fou_Id'];
            $this->pro_quantite = $decoded['Pro_Quantite'];
            $this->pro_CommandeAuto = $decoded['Pro_CommandeAuto'];
            $this->pro_prix = $decoded['Pro_Prix'];
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
            $this->pro_prixlitre  = $decoded['Pro_PrixLitre'];
        } else {
            $this->pro_prixlitre  = null;
        }

        if (isset($decoded['Pro_Cepage'])) {
            $this->pro_cepage = $decoded['Pro_Cepage'];
        } else {
            $this->pro_cepage  = null;
        }

        if (isset($decoded['Pro_Annee'])) {
            $this->pro_anne = $decoded['Pro_Annee'];
        } else {
            $this->pro_anne  = null;
        }

        if (isset($decoded['Pro_SeuilAlerte'])) {
            $this->pro_seuil = $decoded['Pro_SeuilAlerte'];
        } else {
            $this->pro_seuil  = null;
        }

        if (isset($decoded['Pro_Volume'])) {
            $this->pro_volume = $decoded['Pro_Volume'];
        } else {
            $this->pro_volume  = null;
        }

        if (isset($decoded['Pro_Description'])) {
            $this->pro_description = $decoded['Pro_Description'];
        } else {
            $this->pro_description  = null;
        }

        if (isset($decoded['Pro_IsWeb'])) {
            $this->isWeb = $decoded['Pro_IsWeb'];
        } else {
            $this->isWeb = null;
        }
    }
    public function constructeurModificationProduit()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Pro_Id']) &&
            isset($decoded['Pro_Nom']) &&
            isset($decoded['Pro_Typ_Id']) &&
            isset($decoded['Pro_Fou_Id']) &&
            isset($decoded['Pro_Quantite']) &&
            isset($decoded['Pro_CommandeAuto']) &&
            isset($decoded['Pro_Prix']) &&
            isset($decoded['Pro_Ref']) &&
            isset($decoded['Pro_PrixLitre']) &&
            isset($decoded['Pro_Cepage']) &&
            isset($decoded['Pro_Annee']) &&
            isset($decoded['Pro_SeuilAlerte']) &&
            isset($decoded['Pro_Volume']) &&
            isset($decoded['Pro_Description'])


        ) {

            $this->pro_nom  = $decoded['Pro_Nom'];
            $this->type_id = $decoded['Pro_Typ_Id'];
            $this->id_produit = $decoded['Pro_Id'];
            $this->id_fournisseur = $decoded['Pro_Fou_Id'];
            $this->pro_quantite = intval($decoded['Pro_Quantite']);
            $this->pro_CommandeAuto = $decoded['Pro_CommandeAuto'];
            $this->pro_prix = $decoded['Pro_Prix'];
            $this->reference = $decoded['Pro_Ref'];
            $this->pro_prixlitre = $decoded['Pro_PrixLitre'];
            $this->pro_cepage = $decoded['Pro_Cepage'];
            $this->pro_anne = $decoded['Pro_Annee'];
            $this->pro_seuil = $decoded['Pro_SeuilAlerte'];
            $this->pro_volume = $decoded['Pro_Volume'];
            $this->pro_description = $decoded['Pro_Description'];
        } else {
            throw new ExceptionWithStatusCode('Objet Produit incomplet', 400);
        }

        if (isset($decoded['Pro_IsWeb'])) {
            $this->isWeb = $decoded['Pro_IsWeb'];
        } else {
            $this->isWeb = null;
        }
    }



    public function AjouterProduit()
    {

        $Requete = "INSERT INTO dbo.Produit (Pro_Nom, Pro_Typ_Id, Pro_Ref, Pro_Fou_Id, Pro_Cepage, Pro_Annee, Pro_Prix,
        Pro_PrixLitre, Pro_SeuilAlerte, Pro_Quantite, Pro_Volume, Pro_Description, Pro_CommandeAuto, Pro_IsWeb)   
        VALUES (:Pro_Nom, :Pro_Typ_Id, :Pro_Ref, :Pro_Fou_Id, :Pro_Cepage, :Pro_Annee, :Pro_Prix,
        :Pro_PrixLitre, :Pro_SeuilAlerte, :Pro_Quantite, :Pro_Volume, :Pro_Description, :Pro_CommandeAuto, :Pro_IsWeb)";

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
        $stmt->bindParam(":Pro_IsWeb", $this->isWeb);


        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Produit');
        }
    }
    public function SupprimerProduit()
    {




        $VerifFourn = "SELECT * FROM dbo.Produit WHERE Pro_Id=:Pro_Id";
        $id = $this->id_produit;
        $IdFourn = $this->connexion->prepare($VerifFourn);
        // $IdFourn->bindParam(":Pro_Id", $this->id_produit);
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
        $result = $MailVerif->fetch();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function ObtenirTousProduit()
    {

        $ReqClient = "SELECT * FROM dbo.View_Produit";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Aucun produit en base');
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }    


    public function AjouterNouvelleCommandeFournisseur()
    {
        $auto = 5;
        // on crée une nouvelle commande
        $Requete = "INSERT INTO dbo.CommandeFournisseur (Cof_Fou_Id, Cof_Eta_Id)   
         VALUES (:Cof_Fou_Id, :Cof_Eta_Id)";
        // prepare query
        $stmt = $this->connexion->prepare($Requete);
        // bind values
        $stmt->bindParam(":Cof_Fou_Id", $this->id_fournisseur);
        $stmt->bindParam(":Cof_Eta_Id", $auto);


        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de l\'ajout de la commande');
        }
    }

    public function commandeAutomatique(){

        $auto = 5;
        $creation = 1;

        $ReqCommandeFournisseur = "SELECT * FROM dbo.CommandeFournisseur WHERE Cof_Fou_Id=:Cof_Fou_Id AND Cof_Eta_Id=:Cof_Eta_Id OR Cof_Eta_Id=:Cof_Eta_Idd";

        $ConnCommandeFournisseur = $this->connexion->prepare($ReqCommandeFournisseur);

        $ConnCommandeFournisseur->bindParam(":Cof_Fou_Id", $this->id_fournisseur);
        $ConnCommandeFournisseur->bindParam(":Cof_Eta_Id",  $auto);
        $ConnCommandeFournisseur->bindParam(":Cof_Eta_Idd",  $creation);

        $ConnCommandeFournisseur->execute();
        $resuFournisseur = $ConnCommandeFournisseur->fetch();


        if ($resuFournisseur) {

            $id = intval($resuFournisseur['Cof_Id']);

            // convertir le seuil d'alerte x2
            $this->pro_quantite_commande = floatval($this->pro_seuil) * 2;

            $ReqContenuCommandeFournisseur = "SELECT * FROM dbo.ContenuCommandeFournisseur WHERE Ccf_Pro_Id=:Ccf_Pro_Id";
            $stmt = $this->connexion->prepare($ReqContenuCommandeFournisseur);
            $stmt->bindParam(":Ccf_Pro_Id", $this->id_produit);
            $stmt->execute();
            $resultat =  $stmt->fetch();

            if ($resultat) {

                $this->pro_quantite_commande = $this->pro_quantite_commande + intval($resultat['Ccf_Quantite']);
                $Requete = "UPDATE dbo.ContenuCommandeFournisseur SET Ccf_Cof_Id=:Ccf_Cof_Id, Ccf_Quantite=:Ccf_Quantite WHERE Ccf_Pro_Id=:Ccf_Pro_Id";
                $stmt = $this->connexion->prepare($Requete);
                $stmt->bindParam(":Ccf_Pro_Id", $this->id_produit);
                $stmt->bindParam(":Ccf_Cof_Id", $id);
                $stmt->bindParam(":Ccf_Quantite", $this->pro_quantite_commande);

                if (!$stmt->execute()) {
                    throw new Exception('Probleme lors incrementation produit update');
                }
                
            }else{

                $Requete = "INSERT INTO dbo.ContenuCommandeFournisseur (Ccf_Cof_Id, Ccf_Pro_Id, Ccf_Quantite)   
                VALUES (:Ccf_Cof_Id, :Ccf_Pro_Id, :Ccf_Quantite)";
                // prepare query
                $stmt = $this->connexion->prepare($Requete);
                // bind values
                $stmt->bindParam(":Ccf_Cof_Id", $id);
                $stmt->bindParam(":Ccf_Pro_Id", $this->id_produit);
                $stmt->bindParam(":Ccf_Quantite", $this->pro_quantite_commande);


                $resultat =  $stmt->execute();

                if (!$resultat) {
                    throw new Exception('Problème lors de l\'insertion du contenu commande en base de donnée');
                }
            }

           
        } else {

            $this->AjouterNouvelleCommandeFournisseur();
            $this->AjouterContenuCommandeFournisseur();
        }
    }
    


    public function ModifierProduit()
    {
        $Requete = "UPDATE dbo.Produit SET Pro_Nom=:Pro_Nom, Pro_Typ_Id=:Pro_Typ_Id, Pro_Ref=:Pro_Ref, Pro_Fou_Id=:Pro_Fou_Id, Pro_Cepage=:Pro_Cepage, Pro_Annee=:Pro_Annee, Pro_Prix=:Pro_Prix, Pro_PrixLitre=:Pro_PrixLitre, Pro_SeuilAlerte=:Pro_SeuilAlerte, Pro_Quantite=:Pro_Quantite, Pro_Volume=:Pro_Volume, Pro_Description=:Pro_Description, Pro_CommandeAuto=:Pro_CommandeAuto, Pro_IsWeb=:Pro_IsWeb WHERE Pro_Id=:Pro_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Pro_Nom", $this->pro_nom);
        $stmt->bindParam(":Pro_Typ_Id", $this->type_id);
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
        $stmt->bindParam(":Pro_Id", $this->id_produit);
        $stmt->bindParam(":Pro_IsWeb", $this->isWeb);


        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
        }

        /*------ FONCTIONNALITÉ DE COMMANDE AUTOMATIQUE -------*/

        if (floatval($this->pro_seuil) >= floatval($this->pro_quantite)) {

         $this->commandeAutomatique();
        }
    }
    public function ConstructeurModificationInventaire()
    {
       
        // On recupère les produits inventaire en base 
    }

    public function ObtenirProduitByIdFournisseur()
    {

        $ReqClient = "SELECT * FROM dbo.View_Produit WHERE Pro_Fou_Id=?";
        $id = $this->id_fournisseur;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));

        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
}
