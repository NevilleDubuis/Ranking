<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//fr" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">

<head>
	<link href="styles/forms.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php
	if(isset($_POST['name'])){
		$name = $_POST['name'];
		$number = $_POST['number'];
		$place = $_POST['place'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		
		include "includes/conx_bd.php";
		$date = $year."-".$month."-".$day;
		
		$sql="insert into events (name,number_shoot,place,date_of) values ('".$name."','".$number."','".$place."','".$date."')";
		$res=mysqli_query($base, $sql);
		$name = str_replace(" ","_",$name);
		$sql="CREATE TABLE ".$name." (	
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			id_shooter INT NOT NULL, ";
		for ($i=1; $i<=$number; $i++) {
			$sql .= "shoot".$i." INT NOT NULL ";
			if ($i<$number) {
				$sql .=',';
			}
		}
		$sql .= ')';
		$res=mysqli_query($base, $sql);
		mysqli_close($base);
		
		header ('location: transit.html');
		exit();
	}
		
?>
<br>
<fieldset>
	<legend>Informations sur le tir</legend>
	
	<form method="post" action="add_events.php" id="formulaire">

	<br/>
	<label for="name" class="normal">Nom :</label>
	<input type="text" name="name" id="name"/> <br/>
  
	<br/>
	<label for="number" class="normal">Nombre de coups :</label>
	<select name="number" id="number">
			<?php
				//création de la liste avec les entr�e de la base de donn�es
				for ($i=1;$i<21;$i++) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			?>
	</select><br/><br/>

	<label for="place" class="normal">Lieu :</label>
	<input type="text" name="place" id="place"/> <br/><br/>
	
		Date du tir :
		<br/>
		<label for="day" class="date">jours</label>
		<label for="month" class="date">mois</label>
		<label for="year" class="date">ann�es</label><br/>
	
		<input type="text" name="day" size="2" maxlength="2" id="day"/> 
		<input type="text" name="month" size="2" maxlength="2" id="month"/>
		<input type="text" name="year" size="4" maxlength="4" id="year"/>
		<br/>
	
	<br/>
	
	<input type="submit" value="envoyer" class="submit"/>
	<input type="reset" value="effacer" id="reset"/> 
	<input type="button" value="retour" onclick="window.location='index.php';"/> 

	</form>

</fieldset>
</body>
</html>