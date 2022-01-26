<?php 


class Database {
  public $server = "localhost";
    private $database = "Stive";
    public $username = "sa";
    public $password = "DatabaseSTIVE!";
    public $connexion;

    public function getConnexion(){
        $this->connexion = null;

        try{
            $this->connexion =  new PDO("sqlsrv:server=".$this->server .";Database=".$this->database, $this->username, $this->password);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $oPDOException){
            echo "Erreur de connexion : " . $oPDOException->getMessage();
        }

        return $this->connexion;
    }
}

/*$conn = new Database();
if($conn->getConnexion()){
    echo 'bravo amigo';}*/

?>