<?php 

class Database {
    private $sHote = "localhost";
    private $sNomBDD = "#";
    private $sUsername = "root";
    private $sMotDePasse = "";
    public $connexion;

    public function SeConnecter(){
        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=". $this->sHote .";dbname=". $this->sNomBDD, $this->sUsername, $this->sMotDePasse);
            $this->connexion->exec("set names utf8");
        }
        catch (PDOException $oPDOException){
            echo "Erreur de connexion : " . $oPDOException->getMessage();
        }

        return $this->connexion;
    }
}

// CONNEXION BASE DE DONNÉES
$Database = new Database();
$BDD = $Database->SeConnecter();


?>