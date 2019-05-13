<?php
// on pose la variable nom qui porte le nom du fichier
$nom = basename(__FILE__, ".php");
// appel à la bare de navigation
require("../nav.php");

// si jamais il y a un msg
if(isset($_POST["msg"])){
    // on pose une variable qui est égale à $_POST["msg"]
    $msg = $_POST["msg"];
    // si la longueur de la chaine de charactère est infèrieur à 250
    if(strlen($msg)<250){
        // alors on appel à la fonction NouveauMSG
	       NouveauMSG();
    }
}

function NouveauMSG(){
    // on pose les variables $pseuso, $msg, et on créer le PDO pour entrer dans le sql
	$pseudo = $_SESSION["pseudo"];
	$msg = $_POST["msg"];
	$microblogging_message = new PDO("mysql:host=localhost;dbname=microblogging", "root", "");
    // on prepare un nouveau message qui aura un pseudo et un message
	$newmessage = $microblogging_message->prepare("INSERT INTO message(pseudo, message) VALUES(?, ?)");
    // on enregistre ce message dans le sql avec la fonction execute
	$newmessage->execute(array($pseudo,$msg));	
}
?>

<!doctype html>
<html>
    <head>
        <!--Le titre du site possède  -->
        <title>Liste des Messages de <?php echo basename(__FILE__, ".php"); ?></title>
    </head>
    <body>
        <!-- J'ai coupé en 3 grandes parties la partie html -->

        <!-- La première affiche l'option d'envoyer un message -->
        <section>
            <?php
            // on définit la variable chemin qui porte le nom du fichier
                $chemin = basename(__FILE__, ".php");
                // Si il y a une session d'active avec un pseudo
                if(isset($_SESSION["pseudo"])){
                    //  et que ce pseudo et égale au nom du fichier
                   if($_SESSION["pseudo"]==$chemin){
            ?>
            <!-- Alors l'utilisateur à la possibilité d'envoyer un message sur cette page -->
                    <div align="center">     
                        <form method="POST" action="" enctype="multipart/form-data">
                            <label>Message :
                                <input type="text" name="msg" />
                            </label>
                            <input type="submit" value="twitter" />
                        </form>
                    </div>
            <?php
                    }
                }
            ?>
        </section>

        <!-- La 2ème affiche un tableau contenant tous les messages du profil, le profil est chargé selon le nom du fichier (ex : si c'est adrien.php, alors le tableau va afficher tous les messages de adrien) -->
        <section>
            <table border="1"">
                <thead>
                    <tr>
                        <td> Pseudo </td>
                        <td> Message </td>
                        <!-- Si La personne connecté à le même nom que le fichier l'outil permettant d'effacer un message apparait sinon l'utilisateur ne pourra voir que le pseudo et le message( ici ce n'est que le titre X qui est affiché) -->
                        <?php
                            $chemin = basename(__FILE__, ".php");
                                    if(isset($_SESSION["pseudo"])){
                                        if($_SESSION["pseudo"]==$chemin){
                        ?>
                        <td> X </td>
                        <?php
                                        }
                                    }
                        ?>
                    </tr>
                </thead>
                <tbody>
                  
                        <?php
                            // on appelle au sql
                            $microblogging_message = new PDO("mysql:host=localhost;dbname=microblogging", "root", "");
                            // on definit resultats qui égale à l'ensemble des valeurs dans la table message
                            $resultats = $microblogging_message->query("SELECT * FROM message ORDER BY id");
                            // on definit chemin qui porte le nom du fichier
                            $chemin = basename(__FILE__, ".php");
                            $fichier = __FILE__;

                            // Pour chaque message qui porte le pseudo de la page
                            // on créer une ligne qui affiche le pseudo + message
                            foreach($resultats as $test => $resultat) {
                                if($resultat["pseudo"]==$chemin){
                                    echo "<tr>";
                                    echo "<td>" . $resultat["pseudo"] .  "</td>" ."\n";
                                    echo "<td>" . $resultat["message"] .  "</td>" . "\n";
                                    // Si la session active navigue sur son profil elle pourrra alors voir les qui suppriment les post
                                    if(isset($_SESSION["pseudo"])){
                                        if($_SESSION["pseudo"]==$chemin){
                                            // value="$resultat["id"] permet de definir la valeur de l'id du message à chaque $_POST["sup"] et ainsi supprimer le bon message quand l'utilisteur cliquera sur le bouton 
                                            echo "<td>" ."<form method='POST' action='' enctype='multipart/form-data'><input type='submit' value='$resultat[id]' name='sup' /></form></td>" ;
                                        }
                                    }
                                    // on ferme la ligne
                                    echo "</tr>";
                                }
                            }

                            // on défnit test la valer qui porte le nom.php du fichier
                            $test= basename(__FILE__);
                            // si un bouton sup a été activé
                            if(isset($_POST["sup"])){
                                // alors le message situé à la valeur du $_POST["sup"] sera supprimé dans le sql
                                $microblogging_message->query("DELETE FROM `message` WHERE id=" .$_POST["sup"]);
                                // et on recharge la page pour que l'action soit visible par l'utilisateur
                                header('Location: '.$test);
                            }
                        ?>
                </tbody>                
            </table>
        </section>

    </body>
</html>