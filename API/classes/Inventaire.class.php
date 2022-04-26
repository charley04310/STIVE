<?php
include_once 'Produit.class.php';

class Inventaire extends Produit
{

    public $connexion;
    public $inv_id;
    public $inv_stock_etat;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
  
 
    public function AjouterInventaire()
    {

        $Requete = "INSERT INTO dbo.Inventaire (Inv_StockRegul)   
        VALUES (:inv_stock_etat) ";

        $this->inv_stock_etat = 0;

        // prepare query
        $stmt = $this->connexion->prepare($Requete);
        $stmt->bindParam(":inv_stock_etat", $this->inv_stock_etat);
        
        if (!$stmt->execute()) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }

    }

    public function ObtenirInventaire()
    {

        $ReqClient = "SELECT * FROM dbo.View_ContenuInventaire WHERE Inv_Id=:Inv_Id";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->bindParam(":Inv_Id", $this->id_inventaire);
        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id inventaire incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function ObtenirTousInventaire()
    {

        $ReqClient = "SELECT * FROM dbo.Inventaire";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Aucun inventaire en base');
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function ValiderInventaire()
    {
        $Requete = "UPDATE dbo.Inventaire SET inv_Nom=:inv_Nom, inv_Typ_Id=:inv_Typ_Id, inv_Ref=:inv_Ref, inv_Fou_Id=:inv_Fou_Id, inv_Cepage=:inv_Cepage, inv_Annee=:inv_Annee, inv_Prix=:inv_Prix, inv_PrixLitre=:inv_PrixLitre, inv_SeuilAlerte=:inv_SeuilAlerte, inv_Quantite=:inv_Quantite, inv_Volume=:inv_Volume, inv_Description=:inv_Description, inv_CommandeAuto=:inv_CommandeAuto WHERE inv_Id=:inv_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":inv_Nom", $this->inv_nom);
        $stmt->bindParam(":inv_Typ_Id", $this->type_id);
        $stmt->bindParam(":inv_Ref", $this->reference);
        $stmt->bindParam(":inv_Fou_Id", $this->id_fournisseur);
        $stmt->bindParam(":inv_Cepage", $this->inv_cepage);
        $stmt->bindParam(":inv_Annee", $this->inv_anne);

        $stmt->bindParam(":inv_Prix", $this->inv_prix);
        $stmt->bindParam(":inv_PrixLitre", $this->inv_prixlitre);
        $stmt->bindParam(":inv_SeuilAlerte", $this->inv_seuil);
        $stmt->bindParam(":inv_Quantite", $this->inv_quantite);
        $stmt->bindParam(":inv_Volume", $this->inv_volume);
        $stmt->bindParam(":inv_Description", $this->inv_description);
        $stmt->bindParam(":inv_CommandeAuto", $this->inv_CommandeAuto);
        $stmt->bindParam(":inv_Id", $this->id_inventaire);

        if (!$stmt->execute()) {
            throw new Exception('invbleme lors de la requete Modification de  Fournisseur');
        }

        /*------ FONCTIONNALITÉ DE COMMANDE AUTOMATIQUE -------*/

        if(floatval($this->inv_seuil) >= floatval($this->inv_quantite)) {
         
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
           
                $Requete = "INSERT INTO dbo.ContenuCommandeFournisseur (Ccf_Cof_Id, Ccf_inv_Id)   
                VALUES (:Ccf_Cof_Id, :Ccf_inv_Id)";
                // prepare query
                $stmt = $this->connexion->prepare($Requete);
                // bind values
                $stmt->bindParam(":Ccf_Cof_Id", $id);
                $stmt->bindParam(":Ccf_inv_Id", $this->id_inventaire);
             
                $resultat =  $stmt->execute();

                if(!$resultat){
                    throw new Exception('invblème lors de l\'insertion du contenu commande en base de donnée');
                }
                

            } else {
            
                $this->AjouterNouvelleCommandeFournisseur();
                $this->AjouterContenuCommandeFournisseur();

            }
        }

    }
    
    public function SupprimerInventaire(){

        $VerifFourn = "SELECT * FROM dbo.ContenuInventaire WHERE Coi_Inv_Id=:Coi_Inv_Id";

        $id = $this->inv_id;
        $IdFourn = $this->connexion->prepare($VerifFourn);
  
        $IdFourn->execute(array($id));

        $resultat = $IdFourn->fetchAll();

        if ($resultat) {

            $ReqFourn = "DELETE FROM dbo.ContenuInventaire WHERE Coi_Inv_Id=:Coi_Inv_Id";

            $MailVerif = $this->connexion->prepare($ReqFourn);
            $MailVerif->bindParam(":Pro_Id", $this->id_produit);
    
    
            if (!$MailVerif->execute()) {
                throw new Exception('Suppression produit : probleme lors de l\'execution');
            }

        }

        $ReqFourn = "DELETE FROM dbo.Inventaire WHERE Inv_Id=:Inv_Id";

        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Pro_Id", $this->id_produit);


        if (!$MailVerif->execute()) {
            throw new Exception('Suppression produit : probleme lors de l\'execution');
        }
    }
   
}
