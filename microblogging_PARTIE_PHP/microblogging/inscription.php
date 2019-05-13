<?php
// on fait appel au sql
$microblogging_utilisateurs = new PDO("mysql:host=localhost;dbname=microblogging", "root", "");
// on definit resultats qui est égale à l'ensemble des valeurs de la table utilisateues
$resultats = $microblogging_utilisateurs->query("SELECT * FROM utilisateurs");
// on affiche la partie html
require("inscription.html");
// on affiche les fonctions
require("function_inscription.php");
// on créer un compteur il permettra d'arrêter le processus si le pseudo existe déjà
$small_compteur = 0;

// si toutes les valeurs ne existent
if (isset($_POST["pseudo"]) and isset($_POST["mdp"]) and isset($_POST["mdp_save"])){
	// et quelles sont vide
	if (empty($_POST["pseudo"]) or empty($_POST["mdp"]) or empty($_POST["mdp_save"])) {
		// on prévient le client que le formulaire n'est pas correct
		echo "Le formulaire n'est pas bien remplis, reassayez";
	}
	// sinon on cherche si le pseudo entré existe déjà
	else{
		foreach($resultats as $resultat) {
    		// si le pseudo existe le compteur devient supérieur à 1 et la boucle est stoppé
    		if(strtoupper($resultat["pseudo"])==strtoupper($_POST["pseudo"])) {
    			$small_compteur = $small_compteur +1;
    			break;
    		}
		}
		// si le compteur est égale à 1 alors le pseudo existe
    	if($small_compteur==1){
    		echo "Votre pseudo existe déjà";
    	}
    	// sinon on verifie le contenue dans function_insciption.php
    	else{
			Verification_du_contenu();
    	}
	}
}


?>