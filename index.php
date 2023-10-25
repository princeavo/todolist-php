<?php if(isset($_POST['envoyer'])){

require_once "bdd.php";

$description = $_POST['description'];

$infos = $_FILES["fichier"];
$nom = $infos['name'];
$type = $infos['type'];
$taille = $infos['size'];
$message = null;

$fichier_temporaire = $infos['tmp_name'];
$code_error = $infos['error'];
switch ($code_error) {

case UPLOAD_ERR_OK :

//Fichier bien reçu
//Déterminer sa destination finale 
$destination = __DIR__.DIRECTORY_SEPARATOR."fichiers".DIRECTORY_SEPARATOR . $nom;
//copier le fichier temporaire 
if(copy($fichier_temporaire,$destination)){
//Copie OK => mettre un message de confirmation?
// $message.="Transfert terminé Fichier = $nom";
// $message.="Taille = $taille octects ";
// $message.="Type MIME = $type";

$request = $pdo->prepare("INSERT INTO images (nom, description) VALUES (:nom, :description)");
$request->bindParam(":nom", $nom);
$request->bindParam(":description", $description);
$request->execute();
$request->closeCursor();

header("location:liste.php");


}else{
//Problème de copie => mettre un message d'erreur 
$message = "Problème de copie sur le serveur";
}
break;

case UPLOAD_ERR_NO_FILE :

//Pas de fichier saisi 
$message = 'Pas de fichier saisi';
break;

case UPLOAD_ERR_INI_SIZE :

//Taille fichier > upload_max_filesize
$message = "Fichier $nom non transféré ";
$message.='Taille > upload_max_filesize';
break;

case UPLOAD_ERR_FORM_SIZE :

//Taille fichier > MAX_FILE_SIZE
$message = "Fichier $nom non transféré ";
$message.='Taille > MAX_FILE_SIZE';
break;

 
case UPLOAD_ERR_PARTIAL :

// fichier partiellement transféré
$message = "Fichier $nom non transféré ";
$message.='problème lors du transfert';
break;

case UPLOAD_ERR_NO_TMP_DIR :

//Pas de répertoire temporaire
$message = "Fichier $nom non transféré ";
$message.='pas de répertoire temporaire';
break;

case UPLOAD_ERR_CANT_WRITE :

// erreur de l'écriture sur disque
$message = "Fichier $nom non transféré ";
$message.='erreur de l\'écriture sur disque';
break;

case UPLOAD_ERR_EXTENSION :

// transfert stoppé par l'extension
$message = "Fichier $nom non transféré ";
$message.="transfert stoppé par l'extension";
break;

default :
$message = "Fichier non trasféré";
}
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <style>
        body{
            background-color:#546531;
        }
            #container {
                width:40%;
                margin:30vh auto;
                height:40vh;
                background-color: #846513;
                border-radius:20px;
                padding : 20px;
            }
            #content{
                width:80%;
                margin:0 auto;
            }
            form{
                display:flex;
                align-items:center;
                justify-content:space-around;
                flex-direction:column;
                padding:20px;
            }
            input{
                width:100%;
            }
            input[type="text"]{
                height:30px;
                outline:0;
                border-radius:10px;
            }
            input[type="text"]:focus{
                border:2px solid blue;
            }

            input::file-selector-button {
                background-image: linear-gradient(
                    to right,
                    #ff7a18,
                    #af002d,
                    #319197 100%,
                    #319197 200%
                );
                background-position-x: 0%;
                background-size: 200%;
                border: 0;
                border-radius: 8px;
                color: #fff;
                padding: 1rem 1.25rem;
                text-shadow: 0 1px 1px #333;
                transition: all 0.25s;
                margin : 20px;
            }
            input::file-selector-button:hover {
                background-position-x: 100%;
                transform: scale(1.1);
            }
            input[type="submit"]{
                padding: 20px;
                margin: 10px auto;
                 background-image: linear-gradient(
                    to right,
                    #ff7a18,
                    #af002d,
                    #319197 ,
                    #319197
                );
                height:20px;
                border-radius:30px;
                width:50%;
                transition : 0.5s ease-in-out;
            }
             input[type="submit"]:hover{
                 background-position-x: 80%;
                transform: scale(1.1);
             }
        </style>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <?php echo @$message; ?>
                <form action="" method="post" enctype = "multipart/form-data">
	                <input type="file" name="fichier" accept="image/*">
                    <input type="text" name = "description" placeholder="Description de votre image" >
                    <input type="submit" name = "envoyer" value="Ajouter" >
                </form>
            </div>
        </div>
    </body>
</html>