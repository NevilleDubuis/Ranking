<?php

		$sql = "SELECT * FROM events ORDER BY date_of DESC";
		$req = mysqli_query($base, $sql) or die ("Requête invalide");
		$i=0;
	    while ($data = mysqli_fetch_array($req)) { 
			//pour l'affichage des sauts de ligne 
			echo '<fieldset class="titre"><legend>'.$data['name'].'</legend>';
			echo '<div class="contenu">Lieu : '.$data['place'].'  &nbsp; &nbsp;  date :'.$data['date_of'].' &nbsp; &nbsp; nombre_de coups : '.$data['number_shoot'];
			echo '&nbsp; &nbsp; <a href="add_shoot.php?id='.$data['id'].'">ajouter des tirs</a>';
			echo '&nbsp; &nbsp; <a href="classement.php?id='.$data['id'].'">voir le calssement</a>';
			echo '&nbsp; &nbsp; <a href="includes/delete.php?id='.$data['id'].'">supprimer</a>';
			echo '</div></div></fieldset><br/>';
			$i++;
		}
		//si aucun article
		if (mysqli_num_rows($req) == 0) {
			echo '<p>aucun tir prévu dans la base de données</p>';
		}
?>