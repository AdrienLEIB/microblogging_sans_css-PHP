<?php
session_start();
// on détruit la session
session_destroy();
echo "Vous etes deconnecté";
// et on ramène l'utilisateur à la page de connexion
header("Location: connexion.php");
?>