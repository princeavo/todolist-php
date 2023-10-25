<?php

require_once "bdd.php";

if(isset($_GET["id"])){
    $request = $pdo->prepare("DELETE FROM images WHERE id = :id");
    $request->bindParam(":id", $_GET["id"]);
    $request->execute();
    $request->closeCursor();
    header("location:liste.php");
}
$request = $pdo->prepare("SELECT * FROM images");
$request->execute();
$request = $request->fetchAll(PDO::FETCH_ASSOC);
if($request){
}else{
    $erreur = "Votre liste est vide...";
}


  /**
  *      # (liste.php) #
  * ----------------------------
  * @created   < 27/03/2023, 13:48:14 > 
  * @path      < c:\wamp64\www\todolist\liste.php > 
  * @type      < hack > 
  * @author    <seu-nome>
  * @copyright <sua-empresa>
  * ----------------------------
  *      #  Descricao   #
  *     digite a decricao
  * ----------------------------
  * -- gerado automaticamente --
  *       phpcodedetals
  **/
?>



<!DOCTYPE html>
<html lang="fr">
    <head>
        <style>
            body{
                padding:200px;
                background-color:#546531;
                display:flex;
                flex-wrap:wrap;
                align-items:center;
                justify-content:center;
            }
            .container {
                width:380px;
                height:30vh;
                background-color: #846513;
                border-radius:20px;
                margin:20px;
                padding:10px;                
            }
            #content{
                width:80%;
                margin:0 auto;
            }
            .fig img{
                width:100%;
                height:80%;
                border-radius:20px;
            }
            .fig{
                width:90%;
                margin:0 auto;
                height:95%;
            }
            .remove img{
                width:20px;
                height:20px;
                position:absolute;
                top:0px;
                left:0px;
            }
            .remove{
                position:relative;
                top:-15px;
                left:-18px;
            }
            #vide{
                color:#758469;
                width:200px;
                margin-top:25%;
            }
            button{
                background-image: linear-gradient(
                    to right,
                    #ff7a18,
                    #af002d,
                    #319197 100%,
                    #319197 200%
                );
                width:150px;
                padding:15px;
                position:absolute;
                top:10px;
                left:10px;
            }
        </style>
    </head>
    <body>
       <a href="index.php"><button>Ajouter une photo</button></a>
    <?php if($erreur): ?>
        <div id="vide">
           Votre liste est vide
            </div>
        </div>
    <?php else :?>

        <?php foreach($request as $line): ?>
           <?php
                $chemin = "fichiers".DIRECTORY_SEPARATOR .$line["nom"] ; 
                $description = $line["description"];
                $id = $line["id"];
            ?>
            <div class="container">
                <div class="remove">
                        <a href="liste.php?id=<?=$id?>"><img src="remove.png" alt="" /></a>
                </div>
                <div class="fig">
                    <a href="<?=$chemin?>"><img src="<?=$chemin?>" alt="" /></a>
                    <p><?php echo $description;?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </body>
</html>