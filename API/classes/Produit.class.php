<?php 

class Produit {

    private $connexion;
    private $nomTable = "dbo.Produit";

    public $id;
    public $nom;
    public $reference;
    public $fournisseur;
    public $cepage;
    public $anne;
    public $prix;
    public $prixlitre;
    public $seuil;
    public $quantite;
    public $volume;
    public $description;

    public function __construct($BDD) {
        $this->connexion = $BDD;
    }

    function test_input($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    function length_int($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_int($data) === false){
                throw new Exception('Float attendu');
            }else{
                return $data;
            }
        }
    }


    function length_string($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_string($data) === false){
                throw new Exception('String attendu');
            }else{
                return $data;
            }
        }
        
    }


    function length_float($data)
    {
        if(strlen($data) > 30){
            throw new Exception('Trop de caractère');
        }else{
            if(is_float($data) === false){
                throw new Exception('Float attendu');
            }else{
                return $data;
            }
        }
        
    }


    public function AjouterProduit(){

        // query to insert record
        $sRequete = "INSERT INTO " . $this->nomTable . "
            SET Pro_Nom=:Pro_Nom, Pro_Ref=:Pro_Ref, Pro_Cepage=:Pro_Cepage, Pro_Anne=:Pro_Anne, Pro_Prix=:Pro_Prix, Pro_PrixLitre=:Pro_PrixLitre, Pro_SeuilAlerte=:Pro_SeuilAlerte, Pro_Quantite=:Pro_Quantite, Pro_Volume=:Pro_Volume, Pro_Description=:Pro_Description";

        // prepare query
        $stmt = $this->connexion->prepare($sRequete);

        // bind values
        $stmt->bindParam(":Pro_Nom", $this->nom);
        $stmt->bindParam(":Pro_Ref", $this->reference);
        $stmt->bindParam(":Pro_Cepage", $this->cepage);
        $stmt->bindParam(":Pro_Anne", $this->anne);
        $stmt->bindParam(":Pro_Prix", $this->prix);
        $stmt->bindParam(":Pro_PrixLitre", $this->prixlitre);
        $stmt->bindParam(":Pro_SeuilAlerte", $this->seuil);
        $stmt->bindParam(":Pro_Quantite", $this->quantite);
        $stmt->bindParam(":Pro_Volume", $this->volume);
        $stmt->bindParam(":Pro_Description", $this->description);
       
        if($stmt->execute()){
        echo 'produit ajouté';
        }else{
            echo 'error fck';
        }
    }

    public function ModifierProduit(){

    }
    
    public function SupprimerProduit(){

    }

    public function ObtenirProduit(){

    }

}