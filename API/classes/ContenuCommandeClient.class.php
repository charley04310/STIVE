<?php 
include_once 'CommandeClient.class.php';

class ContenuCommandeClient extends CommandeClient {
    
   
    
    public $dateCrea;
    public $id_client;
    public $id_produit;
    public $quantite_produit;

    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
   

    public function constructeurContenuCommandeClient($v, $c){

        if($c === "Pro_Id"){
            $this->id_produit = intval($v);

        }elseif($c === "Pro_Quantite"){
            $this->quantite_produit = $v;
        }
    }
   
    // insert contenu commande client 
    public function RequeteInsertContenuCommandeClient()
    {
   

        $sql = "INSERT INTO dbo.ContenuCommandeClient (Ccc_Coc_Id, Ccc_Pro_Id, Ccc_Quantite) VALUES (?,?,?)";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(1, $this->id_commande_client);
        $stmt->bindParam(2, $this->id_produit);
        $stmt->bindParam(3, $this->quantite_produit);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
 
    public function AjouterContenuCommandeClient($decoded){

        foreach ($decoded as $key => $value) {
            //var_dump($decoded);
            //echo 'Utilisateur n°' .($nb++). ' :<br>';
            foreach ($value as $c => $v) {
                $this->constructeurContenuCommandeClient($v, $c);
            }

            if(!$this->RequeteInsertContenuCommandeClient()){
                throw new ExceptionWithStatusCode('Erreur lors de l\'ajout du contenu de la commande', 400);
            }
        }
    }
    
    public function SupprimerCommande(){
    }

    public function ValiderCommande(){
    }
// obtenir tous le contenu des commandes clients
    public function ObtenirContenuCommandeClient()
    {
        $ReqClient = "SELECT * FROM dbo.View_ContenuCommandeClient";
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    // obtenir contenu commande client par id commande client
    public function ObtenirContenuCommandeClientParIDCommandeClient()
    {
        $ReqClient = "SELECT * FROM dbo.View_ContenuCommandeClient WHERE Ccc_Coc_Id=?";
        $id = $this->id_commande_client;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
}