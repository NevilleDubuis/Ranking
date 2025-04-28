<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//fr" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">

<head>
	<link href="styles/forms.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php
	if(isset($_POST['last_name'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		
		//controle des valeurs entrée
		
		include "includes/conx_bd.php";
		$birthdate = $year."-".$month."-".$day;
		$sql="insert into person (first_name,last_name,birthdate) values ('".$first_name."', '".$last_name."','".$birthdate."')";
		$res=mysqli_query($base, $sql);
		mysqli_close ($base);
		header ('location: transit.html');
		exit();
	}
?>
<br>
<fieldset>
	<legend>Informations de la personne</legend>
	
	<form method="post" action="add_person.php" id="formulaire">

	<label for="last_name" class="normal">nom :</label>
	<input type="text" name="last_name" id="last_name"/> <br/><br/>
	
	<label for="first_name" class="normal">prénom :</label>
	<input type="text" name="first_name" id="first_name"/> <br/><br/>

		Date de naissance :
		<br/>
		<label for="day" class="date">jours</label>
		<label for="month" class="date">mois</label>
		<label for="year" class="date">années</label><br/>
	
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