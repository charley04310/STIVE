<?php
include_once 'Produit.class.php';

class Image extends Produit
{

    private $nomTable;

    public $img_id;
    public $img_adresse;
    public $img_nom;

    // on construit l'objet à partir de la BDD 
    public function __construct($BDD)
    {
        parent::__construct($BDD);
    }
    public function constructeurImage()
    {
        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (
            isset($decoded['Pro_Id']) &&
            isset($decoded['Img_Adresse']) &&
            isset($decoded['Img_Nom'])


        ) {
            $this->id_produit = $decoded['Pro_Id'];
            $this->img_adresse = $decoded['Img_Adresse'];
            $this->img_nom = $decoded['Img_Nom'];
        } else {
            throw new ExceptionWithStatusCode('Objet Image incomplet', 400);
        }
    }
    public function AjouterImage()
    {
        $Requete = "INSERT INTO dbo.Image (Img_Pro_Id, Img_Adresse, Img_Nom)   
        VALUES (:Img_Pro_Id, :Img_Adresse, :Img_Nom) ";

        // prepare query
        $stmt = $this->connexion->prepare($Requete);

        // bind values
        $stmt->bindParam(":Img_Pro_Id", $this->id_produit);
        $stmt->bindParam(":Img_Adresse",  $this->img_adresse);
        $stmt->bindParam(":Img_Nom", $this->img_nom);

        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de excecution de requete Image');
        }
    }

    public function ModifierImage(){

        $VerifFourn = "SELECT * FROM dbo.Image WHERE Img_Id=:Img_Id";
        $id = $this->img_id;
        $id_img = $this->connexion->prepare($VerifFourn);
        $id_img->bindParam(":Img_Id", $this->id_produit);
        $id_img->execute(array($id));

        $resultat = $id_img->fetch();

        if (!$resultat) {
            throw new Exception('Modification : L\'image a été suprimé ou n\'existe pas');
        }


        $Requete = "UPDATE dbo.Image SET Img_Pro_Id=:Img_Pro_Id, Img_Adresse=:Img_Adresse, Img_Nom=:Img_Nom WHERE Img_Id=:Img_Id";

        // bind new values
        $stmt = $this->connexion->prepare($Requete);

        $stmt->bindParam(":Img_Id", $this->img_id);
        $stmt->bindParam(":Img_Pro_Id", $this->id_produit);
        $stmt->bindParam(":Img_Adresse",  $this->img_adresse);
        $stmt->bindParam(":Img_Nom", $this->img_nom);
        // bind values
        
        if (!$stmt->execute()) {
            throw new Exception('Probleme lors de la requete Modification de  Fournisseur');
        }

    }

    public function ObtenirImage(){

        $ReqClient = "SELECT * FROM dbo.Image WHERE Img_Pro_Id=?";
        $id = $this->id_produit;
        $MailVerif = $this->connexion->prepare($ReqClient);
        $MailVerif->execute(array($id));
        $result = $MailVerif->fetchAll();

        if (!$result) {
            throw new Exception('Id Produit ou image inéxistante incorrect');
        }
        echo json_encode($result, true);
    }

    public function SupprimerImage()
    {
        $VerifFourn = "SELECT * FROM dbo.Image WHERE Img_Id=:Img_Id";
        $id = $this->img_id;
        $id_img = $this->connexion->prepare($VerifFourn);
        $id_img->bindParam(":Img_Id", $this->img_id);
        $id_img->execute(array($id));

        $resultat = $id_img->fetch();

        if (!$resultat) {
            throw new Exception('Suppression : L\'image a déjà été suprimé ou n\'existe pas');
        }

        $ReqFourn = "DELETE FROM dbo.Image WHERE Img_Id=:Img_Id";

        $MailVerif = $this->connexion->prepare($ReqFourn);
        $MailVerif->bindParam(":Img_Id", $this->img_id);


        if (!$MailVerif->execute()) {
            throw new Exception('Suppression Image : probleme lors de l\'execution');
        }

    }
}
