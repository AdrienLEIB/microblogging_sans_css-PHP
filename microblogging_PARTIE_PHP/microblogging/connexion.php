<?php
session_start();
// SQL
$microblogging_utilisateurs = new PDO("mysql:host=localhost;dbname=microblogging", "root", "");
// on definit resultats qui est égale à l'ensemble des valeurs de la table utilisateues
$resultats = $microblogging_utilisateurs->query("SELECT * FROM utilisateurs");
// html connexion
require("connexion.html");

// si le formulaire est complet
if (isset($_POST["pseudo"]) and isset($_POST["mdp"])){
    // et que l'on trouve le pseudo dans le sql
	foreach($resultats as $resultat) {
    	if(strtoupper($resultat["pseudo"])==strtoupper($_POST["pseudo"])) {
            // et qu'avec la fonction password_verify le mdp est égale au mdp hash
    		if(password_verify($_POST["mdp"], $resultat["mdp"])) {
                // alors on active la session
    			$_SESSION["pseudo"] = $_POST["pseudo"];
    			$test = $_SESSION["pseudo"];
                // et on amène le client sur sa page
				header("location: profil" . "\\". $test . ".php");
    		}
    	}
	}
	echo "Un des champs est invalide";
}

?>