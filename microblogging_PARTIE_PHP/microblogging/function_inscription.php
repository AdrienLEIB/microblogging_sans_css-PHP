<?php

function Verification_du_contenu(){
	// on pose les variables pseudo, mdp, mdp_save et compteur
	$pseudo = $_POST["pseudo"];
	$mdp = $_POST["mdp"];
	$mdp_save = $_POST["mdp_save"];
	$compteur = 0;
	// si la longeur du pseudo est inférieur ou égale à 20
	if(strlen($pseudo)<=20){
		// si les deux mots de passe saisis sont égaux
		if($mdp == $mdp_save){
			// on découpe le pseudo
			for ($i = 0; $i < strlen($pseudo); $i++) {
				// si il y a une présence d'un charactère indésirable le compteur augmente
    			if($pseudo[$i]==" " ||  $pseudo[$i]=="."  || $pseudo[$i]=="<" || $pseudo[$i]==">" || $pseudo[$i]=="/"){
					$compteur=$compteur+1;
    			}
			}
			// une fois la boucle finis, si le compteur est supérieur à 1, alors le pseudo est incorrecte
			if($compteur>=1){
				echo "Votre pseudo comporte des caractères incorrects";
			}
			// sinon on appel à la fonction nouveaumembre qui va enregister dans le sql le nouveau membre
			else{
			NouveauMembre();				
			}
		}
		// sinon les mots de passes sont différents on prévient l'utilisteurs et rien ne se passe
		else{
			echo "les mots de passes saisis sont différents";
		}
	}
	// pseudo trop long rien ne se passe
	else{
		echo "votre pseudo est trop long !";
	}
}

function NouveauMembre(){
	// on repose les variables, $pseudo et $mdp puisque je ne sais pas comment utiliser une variable d'une fonction à une autre
	$pseudo = $_POST["pseudo"];
	$mdp = $_POST["mdp"];
	// on utilise la fonction password_hash qui hash la variable $mdp
	$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

	// SQL
	$microblogging_utilisateurs = new PDO("mysql:host=localhost;dbname=microblogging", "root", "");
	// on prépare un nouveau membre qui aura 2 valeurs un pseudo et un mdp
	$newmembre = $microblogging_utilisateurs->prepare("INSERT INTO utilisateurs(pseudo, mdp) VALUES(?, ?)");
	// pseudo = $pseudo et le mdp = $mdp_hash
	$newmembre->execute(array($pseudo,$mdp_hash));
	// on previent l'utilisateurs qu'il est inscrit et qu'il peut se connecter en cliquant sur le lien
	echo "vous etes inscrit, <a href=\"connexion.php\">Connectez-vous</a>";

	// on créer la variable dossier qui définit le chemin ou se situe tous les profils
	$dossier = __DIR__ . "\\profil";
	// on créer la variable user_link qui est un fichier .php, il sera situé dans $dossier et aura comme nom le pseudo du nouveau membre
	$user_link = fopen( $dossier . "\\" . $pseudo .".php", "w");
	// si le fichier principale des pseudos existe
	if(file_exists('user.txt')) {
    	// On récupère et affiche le contenu
    	$contenu = file_get_contents('user.txt', LOCK_SH);
	}
	// et on le rajouter dans le nouveau fichier $user_link			
	fwrite($user_link, $contenu);
	// toujours fermé un fichier
	fclose($user_link);	
}
?>