<?php
// Voir l'exemple fourni sur la page de la fonction password_hash()
// pour savoir d'où cela provient.
$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

if (password_verify('rasmuslerdorf', $hash)) {
    echo 'Le mot de passe est valide !'. "<br>";
} else {
    echo 'Le mot de passe est invalide.';
}
?>

<?php
echo "1) ".basename(__FILE__, ".php");
echo "2) ".basename(__file__).PHP_EOL . "<br>";
echo "3) ".basename("/etc/passwd").PHP_EOL . "<br>";
echo "4) ".basename("/etc/").PHP_EOL . "<br>";
echo "5) ".basename(".").PHP_EOL . "<br>";
echo "6) ".basename("/") . "<br>";
echo __FILE__  ."<br>";
?>

<?php



$pseudo = "ad.ri en";
	for ($i = 1; $i <= strlen($pseudo); $i++) {
    	echo $pseudo[$i];
    	if($pseudo[$i]== " " or $pseudo[$i]=="."){
    		echo "Votre pseudo comporte des caractères incorrects";
    		break;
    	}
	}
?>