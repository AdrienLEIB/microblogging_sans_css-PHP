<?php
session_start();
// si il y a une sessions en cours, il y aura dans le nav le nom du client ainsi que la possibilité de se deconnecter
if(isset($_SESSION["pseudo"])){
	echo 
	"<div style='width:100%; height:100px; background:cyan;'>
			<tr>
			<td style='text-align:left; top:0px;'> Bienvenue, ". $_SESSION['pseudo'] .". Vous etes sur la page de : " . $nom . "</td>
			<td style='text-align: right; top:0px;'><form method='POST' action='../deconnecter.php' enctype='multipart/form-data' style='text-align:right;'><input type='submit' value='Se deconnecter'/>
            </form> </td>			
			</tr>
	</div>";
}
// sinon à la place, le client sera avertis qu'il n'est pas connecté et il aura la possibilité de le faire
else{
	echo 
	"<div style='width:100%; height:100px; background:cyan;'>
			<tr>
			<td style='text-align:left;'> Vous n'etes pas connecté </td>
			<td style='text-align: right; top:0px;'><form method='POST' action='../connexion.php' enctype='multipart/form-data' style='text-align:right;'><input type='submit' value='Se connecter'/>
            </form></td>			
			</tr>
	</div>";
}