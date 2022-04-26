<?php
include_once 'Produit.class.php';

class ContenuCommandeFournisseur extends Produit
{
    public $cof_id;
    public $ccf_quantite;
    public $maj;
    public $dateCrea;
    public $etat_commande;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }


    public function SetContenuCommande($c, $v)
    {
        if($c === "Ccf_Pro_Id"){
            $this->id_produit = intval($v);

        }elseif($c === "Ccf_Quantite"){
            $this->quantite_produit = $v;

        }elseif($c === "Cof_Fou_Id"){
            $this->id_fournisseur = $v;
        }
    }

    public function SetUpdateContenuCommande()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);
        
        if(isset($decoded[0]['Eta_Id'])){
         $this->etat_commande =  intval($decoded[0]['Eta_Id']);
        }

        if(isset($decoded[0]['Cof_Fou_Id'])){
            $this->id_fournisseur =  intval($decoded[0]['Cof_Fou_Id']);
           }
   

        foreach ($decoded as $key) {

            if(
                isset($key['Ccf_Cof_Id']) &&
                isset($key['Ccf_Quantite']) &&
                isset($key['Ccf_Pro_Id'])

            ){
                $this->cof_id = $key['Ccf_Cof_Id'];
                $this->ccf_quantite = $key['Ccf_Quantite'];
                $this->id_produit = intval($key['Ccf_Pro_Id']);

            }else{

                throw new Exception('Objet Contenu Commande fournisseur Indisponible');

            }


            if($this->ccf_quantite === 0  || $this->ccf_quantite === '0') {

                $DeleteContenu = "DELETE FROM dbo.ContenuCommandeFournisseur WHERE Ccf_Pro_Id=:Ccf_Pro_Id";
                $DeleteRequete = $this->connexion->prepare($DeleteContenu);
                $DeleteRequete->bindParam(":Ccf_Pro_Id", $this->id_produit);
                
                $DeleteRequete->execute();
                
            }else{
                
                // appeler la méthode de modification

                //$this->ModifierContenuCommandeFournisseur();
                $Requete = "UPDATE dbo.ContenuCommandeFournisseur SET Ccf_Cof_Id=:Ccf_Cof_Id, Ccf_Quantite=:Ccf_Quantite WHERE Ccf_Pro_Id=:Ccf_Pro_Id";
                $IdFourn = $this->connexion->prepare($Requete);
                $IdFourn->bindParam(":Ccf_Pro_Id", $this->id_produit);
                $IdFourn->bindParam(":Ccf_Cof_Id", $this->cof_id );
                $IdFourn->bindParam(":Ccf_Quantite", $this->pro_quantite_commande);
                $IdFourn->execute();
            }

            $Requete = "UPDATE dbo.CommandeFournisseur SET Cof_Eta_Id=:Cof_Eta_Id, Cof_Fou_Id=:Cof_Fou_Id WHERE Cof_Id=:Cof_Id";
            $IdFourn = $this->connexion->prepare($Requete);
            $IdFourn->bindParam(":Ccf_Cof_Id", $this->cof_id);
            $IdFourn->bindParam(":Cof_Eta_Id", $this->etat_commande);
            $IdFourn->bindParam(":Cof_Fou_Id", $this->id_fournisseur);

            $IdFourn->execute();

        }
    }

    public function RequeteSelectCourantCommande()
    {

        $auto = 2;
        $creation = 1;

        $ReqCommandeFournisseur = "SELECT * FROM dbo.CommandeFournisseur WHERE Cof_Fou_Id=:Cof_Fou_Id AND Cof_Eta_Id=:Cof_Eta_Id OR Cof_Eta_Id=:Cof_Eta";

        $ConnCommandeFournisseur = $this->connexion->prepare($ReqCommandeFournisseur);
        $ConnCommandeFournisseur->bindParam(":Cof_Fou_Id", $this->id_fournisseur);
        $ConnCommandeFournisseur->bindParam(":Cof_Eta_Id", $auto);
        $ConnCommandeFournisseur->bindParam(":Cof_Eta", $creation);


        $ConnCommandeFournisseur->execute();
        $resuFournisseur = $ConnCommandeFournisseur->fetch();

        if (!$resuFournisseur) {
            return false;
        }

        if (isset($resuFournisseur['Cof_Id'])) {
            $this->cof_id = intval($resuFournisseur['Cof_Id']);
      
        } else {
            throw new Exception('Probleme lors de l\'ajout de la commande');
        }
    }

    public function GetContenuCommandeByIdCommande()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (isset($_GET['Ccf_Cof_Id'])) {
            $this->cof_id = $_GET['Ccf_Cof_Id'];
        } else {
            throw new Exception('Id Commande incorrect');
        }

        $ReqClient = "SELECT * FROM View_ContenuCommandeFournisseur WHERE Ccf_Cof_Id=?";
        $id = $this->cof_id;
        $MailVerif = $this->connexion->prepare($ReqClient);
        -$MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function RequeteAjouterContenuCommandeFournisseur(): bool
    {
 
        $Requete = "INSERT INTO dbo.ContenuCommandeFournisseur (Ccf_Cof_Id, Ccf_Pro_Id, Ccf_Quantite)   
        VALUES (:Ccf_Cof_Id, :Ccf_Pro_Id, :Ccf_Quantite)";
        // prepare query
        $stmt = $this->connexion->prepare($Requete);
        // bind values
        $stmt->bindParam(":Ccf_Cof_Id", $this->cof_id);
        $stmt->bindParam(":Ccf_Pro_Id", $this->id_produit);
        $stmt->bindParam(":Ccf_Quantite", $this->quantite_produit);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de l\'ajout produit CCF');
        }

        return true;
    }


    public function ObtenirContenuCommandeFournisseurById()
    {

        $ReqClient = "SELECT * FROM dbo.View_ContenuCommandeFournisseur";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function ObtenirContenuCommandeFournisseurByIdCommande()
    {

        $ReqClient = "SELECT * FROM dbo.View_ContenuCommandeFournisseur WHERE  ";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }


    /*public function ModifierContenuCommandeFournisseur()
    {

        $Requete = "UPDATE dbo.ContenuCommandeFournisseur SET  Ccf_Quantite=:Ccf_Quantite WHERE Ccf_Pro_Id=:Ccf_Pro_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Ccf_Quantite", $this->pro_quantite_commande);


        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
        }
    }*/
}
