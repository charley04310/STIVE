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

    <form action="http://localhost:8888/STIVE/API/controlers/produit/ajouter.php" method="post">

        <div class="form-group">
            <label for="name">Nom de produit</label>
            <input type="name" class="form-control" name="NameNewProduit" >
        </div>

        <div class="form-group">
            <label for="reference">Reference</label>
            <input type="text" class="form-control" name="ReferenceNewProduit" >
        </div>
        <div class="form-group">
            <label for="reference">Fournisseur</label>
            <input type="text" class="form-control" name="FournisseurNewProduit" >
        </div>


        <div class="form-group">
            <label for="cepage">Cepage</label>
            <input type="text" class="form-control" name="CepageNewProduit" >
        </div>

        <div class="form-group">
            <label for="anne">Anne</label>
            <input type="date" class="form-control" name="DateNewProduit" >
        </div>

        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" step="0.01" class="form-control" name="PrixNewProduit" >
        </div>

        <div class="form-group">
            <label for="prix">Prix Litre</label>
            <input type="number" step="0.01" class="form-control" name="PrixLitreNewProduit" >
        </div>

        <div class="form-group">
            <label for="seuil">Seuil</label>
            <input type="number" step="0.01" class="form-control" name="SeuilNewProduit" >
        </div>

        <div class="form-group">
            <label for="quantite">Quantité</label>
            <input type="number" step="0.1" class="form-control" name="QuantiteNewProduit" >
        </div>

         <div class="form-group">
           <label for="volume">Volume</label>
            <input type="number" step="0.1" class="form-control" name="VolumeNewProduit" >
        </div>
        <div class="form-group">
           <label for="description">Description</label>
            <input type="text" class="form-control" name="DescriptionNewProduit" >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>



</body>

</html>