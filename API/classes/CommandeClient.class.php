<?php 
include_once 'Client.class.php';

class CommandeClient extends Client{

    public $connexion;
    private $nomTable = "CommandeClient";
    public $id_commande_client;
    public $maj;
    public $dateCrea;
    public $etat_commande_client;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
// ajouter commande client 
    public function constructeurCommandeClient($decoded){
        if(isset($decoded[0]['Uti_MailContact'])){
            $this->mail = $decoded[0]['Uti_MailContact'];
        } else{
            throw new Exception('Mail inexistant merci de renseigner tous les champs');
        } 
    
        if(isset($decoded[0]['Uti_Mdp'])){
            $this->password = $decoded[0]['Uti_Mdp'];
        } else{
            throw new Exception('Password inexistant merci de renseigner tous les champs');
        } 
    
        if(isset($decoded[0]['Uti_Cp'])){
            $this->code_postal = $decoded[0]['Uti_Cp'];
        } else{
            throw new Exception('Cp inexistante merci de renseigner tous les champs');
        } 
        if(isset($decoded[0]['Uti_Ville'])){
            $this->ville = $decoded[0]['Uti_Ville'];
        } else{
            throw new Exception('Ville inexistante merci de renseigner tous les champs');
        } 
        if(isset($decoded[0]['Uti_Pays'])){
            $this->pays = $decoded[0]['Uti_Pays'];
        } else{
            throw new Exception('Pays inexistante merci de renseigner tous les champs');
        }
        if(isset($decoded[0]['Uti_Adresse'])){
            $this->adresse = $decoded[0]['Uti_Adresse'];
        } else{
            throw new Exception('Adresse inexistante merci de renseigner tous les champs');
        }   
       // isset uti_telcontact
        if(isset($decoded[0]['Uti_TelContact'])){
            $this->tel = $decoded[0]['Uti_TelContact'];
        } else{
            throw new Exception('Tel inexistante merci de renseigner tous les champs');
        } 
        if(isset($decoded[0]['Cli_Nom'])){
            $this->nom = $decoded[0]['Cli_Nom'];
        } else{
            throw new Exception('Nom inexistante merci de renseigner tous les champs');
        } 
        if(isset($decoded[0]['Cli_Prenom'])){
            $this->prenom = $decoded[0]['Cli_Prenom'];
        } else{
            throw new Exception('Prenom inexistante merci de renseigner tous les champs');
        } 


    }

    public function AjouterCommandeClient(){

        $this->etat_commande_client = 2;
        $Requete = "INSERT INTO dbo.CommandeClient (Coc_Cli_Id, Coc_Eta_Id)   
        VALUES (:Coc_Cli_Id, :Coc_Eta_Id) ";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);
 
        // bind values
        $stmt->bindParam(":Coc_Eta_Id", $this->etat_commande_client);
        $stmt->bindParam(":Coc_Cli_Id",  $this->id_client);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Produit');
        }
    }

    public function ObtenirCommandeClientParIDClient()
    {

        $ReqClient = "SELECT * FROM dbo.View_CommandeClient WHERE Coc_Cli_Id=?";
        $id = $this->id_client;
     
        $MailVerif = $this->connexion->prepare($ReqClient);-
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function ObtenirCommandeClient()
    {

        $ReqClient = "SELECT * FROM dbo.View_CommandeClient";
     
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute();
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function ModifierStatuCommandeClient(){

        $Requete = "UPDATE dbo.CommandeClient SET Coc_Eta_Id=:Coc_Eta_Id WHERE Coc_Id=:Coc_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Coc_Eta_Id", $this->etat_commande_client);
        $stmt->bindParam(":Coc_Id", $this->id_commande_client);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Commande Client');
        }


    }

// obtenir la derniere commande client 
    public function ObtenirDerniereCommandeClient(){

        $ReqClient = "SELECT TOP 1 * FROM dbo.CommandeClient ORDER BY Coc_Id DESC";
        $id = $this->id_client;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetch();

        if (!$result) {
            throw new Exception('Id Client incorrect');
        }

        $this->id_commande_client = $result['Coc_Id'];
      
    }

    
    

   
}

?>
