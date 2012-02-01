<?php 
  if (isset($_POST['pdf'])) {
	$pdf = $_POST['pdf']; 
  } 
  else {
	$pdf = null;
  }
  if ($pdf == null) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//fr" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">

<head>
	<link href="styles/forms.css" rel="stylesheet" type="text/css" />
	<link href="styles/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/forms.js"></script>
	<script type="text/javascript" src="scripts/load.js"></script>
</head>

<?php
	}
	include 'includes/conx_bd.php';
	$id = $_GET['id'];
	$sql = 'SELECT name, number_shoot FROM events where id = '.$id;
	$res = mysql_query($sql);
	$data = mysql_fetch_array($res);
	$name = str_replace(" ","_",$data['name']);
	$number = $data['number_shoot'];
	mysql_close ($base);
    if ($pdf == null) {
?>
<body>

    <h1>Classement :</h1>
    <fieldset>
	<form method="post" action="<?php echo 'classement.php?id='.$id;?>" id="formulaire">

            <label for="bshoots" class="normal">addition (appui au coup profond)</label>
            <input type="checkbox" value="bshoots" name="bshoots" class='choose'<?php if (isset($_POST['bshoots'])) {echo 'checked';}?>/> <div class="comm">pour le challenge dame, toupin et section</div> <br/><br/>

            <label for="sbshoots" class="normal">addition (appui au N&ordm; de 10,9,...)</label>
            <input type="checkbox" value="sbshoots" name="sbshoots" class='choose'<?php if (isset($_POST['sbshoots'])) {echo 'checked';}?>/> <div class="comm">pour le challenge standard et speedy </div><br/><br/>

            <label for="prgres_add" class="normal">addition (progr&egrave;s)</label>
            <input type="checkbox" value="progres_add" name="progres_add" class='choose'<?php if (isset($_POST['progres_add'])) {echo 'checked';}?>/><br/><br/>

            <label for="prgres_add" class="normal">coups centr&eacute; (progr&egrave;s)</label>
            <input type="checkbox" value="progres_centre" name="progres_centre" class='choose'<?php if (isset($_POST['progres_centre'])) {echo 'checked';}?>/><br/><br/>

            <label for="prgres_add" class="normal">classement altern&eacute; (progr&egrave;s)</label>
            <input type="checkbox" value="progres_alt" name="progres_alt" class='choose'<?php if (isset($_POST['progres_alt'])) {echo 'checked';}?>/><div class="comm">&Agrave; ne cocher seulement si l'addition et le coup centr&eacute; sont coch&eacute; </div><br/><br/>

            <label for="pdf" class="normal">cr&eacute;er un pdf</label>
            <input type="checkbox" value="pdf" name="pdf" class='choose'/><br/><br/>

            <input type="submit" value="envoyer" id="submit" class="submit"/>
            <input type="reset" value="effacer" id="reset"/>
            <input type="button" value="retour" onclick="window.location='index.php';"/>

	</form>
		
</fieldset>
<?php
      }
	if ($pdf != null) {
		ob_start();
		if (isset($_POST['bshoots'])) {
			include 'class/bshoots.php';
		}
        if (isset($_POST['sbshoots'])) {
			include 'class/sbshoots.php';
		}
        if (isset($_POST['progres_add'])) {
			include 'class/progres.php';
		}
        if (isset($_POST['progres_centre'])) {
			include 'class/progres_centre.php';
		}
        if (isset($_POST['progres_alt'])) {
			include 'class/progres_alt.php';
		}
		$content = ob_get_clean();
		require_once('html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4','fr');
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('exemple00.pdf');
		}
		catch(HTML2PDF_exception $e) { echo $e; }
	}
	else {
		if (isset($_POST['bshoots'])) {
			include 'class/bshoots.php';
		}
        if (isset($_POST['sbshoots'])) {
			include 'class/sbshoots.php';
		}
        if (isset($_POST['progres_add'])) {
			include 'class/progres.php';
		}
        if (isset($_POST['progres_centre'])) {
			include 'class/progres_centre.php';
		}
        if (isset($_POST['progres_alt'])) {
			include 'class/progres_alt.php';
		}
	}
	if ($pdf == null) {
?>
</body>
</html>
<?php } ?>