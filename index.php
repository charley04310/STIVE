<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<?php include 'API/config/dbConnect.class.php';?>

<body>

    <form action="http://localhost:8888/STIVE/API/controlers/Utilisateur/ajouter.php" method="POST">

        <div class="form-group">
            <label for="name">Nom Responsable</label>
            <input type="text" class="form-control" name="NomResp" >
        </div>

        <div class="form-group">
            <label for="name">Nom Domaine</label>
            <input type="text" class="form-control" name="NomDomaine" >
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" name="Adresse" >
        </div>

        <div class="form-group">
            <label for="reference">Complement adresse</label>
            <input type="text" class="form-control" name="CompAdresse" >
        </div>
        <div class="form-group">
            <label for="code postal">Code postale</label>
            <input type="text" class="form-control" name="CodePostal" >
        </div>


        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" name="Ville" >
        </div>

        <div class="form-group">
            <label for="pays">Pays</label>
            <input type="text" class="form-control" name="Pays" >
        </div>

        <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="text" class="form-control" name="Telephone" >
        </div>
        <div class="form-group">
            <label for="telephone">Telephone Responsable</label>
            <input type="text" class="form-control" name="TelResp" >
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" name="Mdp" >
        </div>


        <div class="form-group">
            <label for="mail">Mail</label>
            <input type="mail"  class="form-control" name="Mail" >
        </div>


        <div class="form-group">
            <label for="mail">Mail Responsable</label>
            <input type="mail"  class="form-control" name="MailResp" >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>



</body>

</html>