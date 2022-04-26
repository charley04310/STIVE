<?php
include_once 'Inventaire.class.php';

class ContenuInventaire extends Inventaire
{

    public $connexion;
    public $cont_inv_id;
    public $cont_pro_id;
    public $cont_pro_libelle;
    public $cont_pro_quantite;
    public $cont_pro_nom;
    public $cont_inventaire;
    public $cont_fou_nomDomaine;
    public $cont_invStockRegul;

    public function __construct($BDD)
    {
        parent::__construct($BDD);

    }

    public function getCoi_inv_id($decoded):bool {
     
        if($decoded[0]['Coi_Inv_Id'] == null){

        return true;

        }
        else{
        return false;
        }
    }

    // GET contenu inventaire by coi inv id
    public function getContenuInventaireByCoiInvId($coi_inv_id)
    {
        $ReqClient = "SELECT * FROM dbo.View_ContenuInventaire WHERE Coi_inv_id=?";
        $id = $this->coi_inv_id;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();
        if (!$result) {
            throw new Exception('Id inventaire incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    //obtenir tous les contenu inventaire
    public function getAllContenuInventaire()
    {
        $ReqClient = "SELECT * FROM dbo.View_ContenuInventaire";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array());
        $result = $MailVerif->fetchAll();
        if (!$result) {
            throw new Exception('Aucun inventaire en base');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function constructeurContenuInventaire($c, $v){

        if ($c === "Coi_Inv_Id") {
            $this->inv_id  = $v;
           
        }elseif($c === "Coi_Pro_Id"){
            $this->cont_pro_id = intval($v);
           
        }elseif($c === "Coi_Typ_Libelle"){
            $this->cont_pro_libelle = $v;
         
        }elseif($c === "Coi_Pro_Quantite"){
            $this->cont_pro_quantite = $v;
          
        }elseif($c === "Coi_Pro_Nom"){
            $this->cont_pro_nom = $v;
           
        }elseif($c === "Coi_Inventaire" && $v === 0 ||$v === '0'){
            $this->cont_inventaire = 0;

        }elseif($c === "Coi_Inventaire"){
            $this->cont_inventaire = $v;
        }
        
       
        if($c == "Coi_Fou_NomDomaine"){
            $this->cont_fou_nomDomaine = $v;
        }

        if($c == "Inv_StockRegul"){
            $this->cont_invStockRegul = $v;
        }
        
        
    }
    // requete SQL : selectionner le dernier inventaire de la base de données
   
    public function AjouterContenuIventaire()
    {
        $ContenuInventaire = "SELECT TOP 1 * FROM dbo.Inventaire ORDER BY Inv_Id DESC";
        $stmt = $this->connexion->prepare($ContenuInventaire);
    

        if (!$stmt->execute()) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }

        $resultatInventaire = $stmt->fetch();

       
        if (isset($resultatInventaire['Inv_Id'])) {

            // verifier si on recoit un poste : constructeur Contenu Inventaire

            $this->inv_id = intval($resultatInventaire['Inv_Id']);


            $Requete = "INSERT INTO dbo.ContenuInventaire(Coi_Inv_Id, Coi_Pro_Id, Coi_Typ_Libelle, Coi_Pro_Quantite, Coi_Inventaire, Coi_Fou_NomDomaine, Coi_Pro_Nom) 
            VALUES (:Coi_Inv_Id, :Coi_Pro_Id, :Coi_Typ_Libelle, :Coi_Pro_Quantite, :Coi_Inventaire, :Coi_Fou_NomDomaine, :Coi_Pro_Nom)";


            // prepare query
            $stmt = $this->connexion->prepare($Requete);

            $stmt->bindParam(":Coi_Inv_Id", $this->inv_id);
            $stmt->bindParam(":Coi_Pro_Id", $this->cont_pro_id);
            $stmt->bindParam(":Coi_Typ_Libelle", $this->cont_pro_libelle);
            $stmt->bindParam(":Coi_Pro_Quantite", $this->cont_pro_quantite);
            $stmt->bindParam(":Coi_Inventaire", $this->cont_inventaire);
            $stmt->bindParam(":Coi_Fou_NomDomaine", $this->cont_fou_nomDomaine);
            $stmt->bindParam(":Coi_Pro_Nom", $this->cont_pro_nom);

            if (!$stmt->execute()) {
                throw new Exception('probleme lors de excecution de requete inventaire');
            }
        }
    }

    // ajouter contenu inventaire
    public function addContenuInventaire()
    {
        $Requete = "INSERT INTO dbo.ContenuInventaire(Coi_Inv_Id, Coi_Pro_Id, Coi_Typ_Libelle, Coi_Pro_Quantite, Coi_Inventaire, Coi_Fou_NomDomaine, Coi_Pro_Nom) 
        VALUES (:Coi_Inv_Id, :Coi_Pro_Id, :Coi_Typ_Libelle, :Coi_Pro_Quantite, :Coi_Inventaire, :Coi_Fou_NomDomaine, :Coi_Pro_Nom)";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);

        $stmt->bindParam(":Coi_Inv_Id", $this->inv_id);
        $stmt->bindParam(":Coi_Pro_Id", $this->cont_pro_id);
        $stmt->bindParam(":Coi_Typ_Libelle", $this->cont_pro_libelle);
        $stmt->bindParam(":Coi_Pro_Quantite", $this->cont_pro_quantite);
        $stmt->bindParam(":Coi_Inventaire", $this->cont_inventaire);
        $stmt->bindParam(":Coi_Fou_NomDomaine", $this->cont_fou_nomDomaine);
        $stmt->bindParam(":Coi_Pro_Nom", $this->cont_pro_nom);

        if (!$stmt->execute()) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }
    }

// supprimer contenu inventaire ou inventaire

    public function SupprimerContenuInventaire()
    {
        $Requete = "DELETE FROM dbo.ContenuInventaire WHERE Coi_Pro_Id=:Coi_Pro_Id AND Coi_Inv_Id=:Coi_Inv_Id";
       // $id = $this->inv_id;
        $MailVerif = $this->connexion->prepare($Requete);
        $MailVerif->bindParam(":Coi_Pro_Id", $this->cont_pro_id);
        $MailVerif->bindParam(":Coi_Inv_Id", $this->inv_id);

        $MailVerif->execute();
   
    }
    public function commandeAuto(){

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

    public function ModificationIventaireProduit()
    {
        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

 

        foreach ($decoded as $key => $value) {
             
         
            foreach ($value as $c => $v){
              
                $this->constructeurContenuInventaire($c, $v);
              

           }
           // on verifie si le stock et inferieur au seuil alerte
        
           if($this->cont_inventaire != null || $this->cont_inventaire === 0) {
     
               $this->ComparerStocketSeuil(); 
               $this->UpdateProduitDepuisInventaire();   

           }
          
        }

        $this->UpdateStatusInventaire();   
        
    }


    public function UpdateStatusInventaire()
    {
        $inv_status =1;
        $Requete = "UPDATE dbo.Inventaire SET Inv_StockRegul=:Inv_StockRegul WHERE Inv_Id=:Inv_Id";
        $stmt = $this->connexion->prepare($Requete);
        
        $stmt->bindParam(":Inv_StockRegul", $inv_status);
        $stmt->bindParam(":Inv_Id", $this->inv_id);

        if (!$stmt->execute()) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }
    }

    public function UpdateProduitDepuisInventaire()
    {

        $Requete = "UPDATE dbo.Produit SET Pro_Quantite=:Pro_Quantite WHERE Pro_Id=:Pro_Id";
        $src = $this->connexion->prepare($Requete);

        $inventaire = $this->cont_inventaire;
        $pro_id = intval($this->cont_pro_id);
        
       //$src->bindParam(':Pro_Id', $pro_id);
        //$src->bindParam(':Pro_Quantite', $inventaire);
    
        
        if (!$src->execute(array(':Pro_Id' => $pro_id, ':Pro_Quantite' => $inventaire))) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }
      
    }

    public function ComparerStocketSeuil()
    {
        $Requete = "SELECT * FROM dbo.Produit WHERE Pro_Id=:Pro_Id";
        $stmt = $this->connexion->prepare($Requete);
        $stmt->bindParam(":Pro_Id", $this->cont_pro_id);

        if (!$stmt->execute()) {
            throw new Exception('probleme lors de excecution de requete inventaire');
        }

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultat['Pro_SeuilAlerte'] >  $this->cont_inventaire) {

            $this->id_fournisseur = $resultat['Pro_Fou_Id'];
            $this->pro_seuil = $resultat['Pro_SeuilAlerte'];
            $this->pro_quantite = $resultat['Pro_Quantite'];
            $this->id_produit = $resultat['Pro_Id'];

            $this->commandeAuto();

        } 
    }
}
