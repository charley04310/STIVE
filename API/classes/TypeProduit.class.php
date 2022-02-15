<?php
include_once 'Produit.class.php';

class TypeProduit extends Produit
{

    public $connexion;
    public $type_libelle;
    public $id_TyProduit;


    public function __construct($BDD)
    {
        parent::__construct($BDD);
        $this->type_libelle = is_string($this->id_TyProduit);
    }



    public function DeleteTypeProduit()
    {
    }

    public function ObtenirTousTypeProduit(){
        $RequeteTypeProduit = "SELECT * from dbo.TypeProduit";
        $prepareRequete = $this->connexion->prepare($RequeteTypeProduit);
        $prepareRequete->execute(array());
        $result = $prepareRequete->fetchAll();

        if (!$result) {
            throw new Exception('problème lors de la requête ou type produit inéxistant');
        }
        echo json_encode($result, true);

    }

    public function AjouterTypeProduit()
    {

        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        if (isset($decoded['Typ_Libelle']) && is_string($decoded['Typ_Libelle'])) {

            $this->type_libelle  = $decoded['Typ_Libelle'];

            $Requete = "INSERT INTO dbo.TypeProduit (Typ_Libelle)   
            VALUES (:Typ_Libelle) ";

            // prepare query
            $stmt = $this->connexion->prepare($Requete);

            // bind values
            $stmt->bindParam(":Typ_Libelle", $this->type_libelle);

            if (!$stmt->execute()) {
                throw new Exception('Probleme lors de ajout type produit');
            }
        }
    }
}
