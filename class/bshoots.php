<?php
echo '<fieldset class="titre"><legend>'.$name.'</legend>';
		include 'includes/conx_bd.php';
		//création de la requête sql
		$sql = 'SELECT '.$name.'.*, person.* FROM '.$name.' INNER JOIN person 
				ON '.$name.'.id_shooter = person.id ORDER BY ';
		for ($i = 1; $i<=$number; $i++) {
			$sql .= 'shoot'.$i;
			if ($i<$number){
				$sql .= ' + ';
			}		
		}
		$sql .= ' DESC';
		
		$req = mysql_query($sql) or die ("Requête invalide");
		$ind=1;
		$tab[0]=0;
		//affichage des données
		while ($data = mysql_fetch_array($req)) { 
			$inlist = false;
			foreach ($tab as $shooter) {
				if ($shooter == $data['id_shooter']) {
					$inlist = true;
				}
			}
			if (!($inlist)) {
				echo '<div class="contenu"><div class="droite">'.$ind.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
				if ($data['birthdate']!='0000-00-00') { 
					echo date("d.m.Y", strtotime($data['birthdate']));
				}
				$total = 0;
				echo '</div><table><tr>';
				for ($i=1;$i<=$number;$i++) {
						echo '<td>';
						echo 'tir '.$i;
						echo '</td>';
						
				}
				
				echo '<td>Total</td></tr><tr>';
				for ($i=1;$i<=10;$i++) {
					$name = 'shoot'.$i;
					if (isset($data[$name])) {
						echo '<td>';
						echo $data[$name].' ';
						echo '</td>';
						$total += $data[$name];
					}
				}
				echo '<td><strong>';
				echo $total;
				echo '</strong></td></tr></table></div>';
				echo '<br/>';
			
				$tab[$ind]=$data['id_shooter'];
				$ind++;
			}
		}
		//si aucune passe
		if (mysql_num_rows($req) == 0) {
			echo '<p>aucun tir enregistré</p>';
		}
		echo '</fieldset>';
		mysql_close ($base);
?>