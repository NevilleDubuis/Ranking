<?php
 
 $generate = isset($_GET['make_pdf']);
 $nom = isset($_GET['nom']) ? $_GET['nom'] : 'inconnu';
 
 $nom = substr(preg_replace('/[^a-zA-Z0-9]/isU', '', $nom), 0, 26);
 
 if ($generate)
 {
 	ob_start();
 }
 else
 {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >	
		<title>Exemple d'auto g�n�ration de PDF</title>
	</head>
	<body>
<?php	
 }
?>
<br>
Ceci est un exemple de g�n�ration de PDF via un bouton :)<br>
<br>
<br>
<br>
<?php if ($generate) { ?>
Bonjour <b><?php echo $nom; ?></b>, ton nom peut s'�crire : <br>
<barcode type="C39" value="<?php echo strtoupper($nom); ?>" style="color: #770000" ></barcode><hr>
<br>
<?php } ?>
<br>
<?php
	if ($generate)
	{
		$content = ob_get_clean();
		require_once('html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P','A4', 'fr', false, 'ISO-8859-15');
			$html2pdf->writeHTML($content);
			$html2pdf->Output('exemple09.pdf');
		}
		catch(HTML2PDF_exception $e) { echo $e; }
		exit;
	}
?>
		<form method="get" action="">
			<input type="hidden" name="make_pdf" value="true">
			Ton nom : <input type="text" name="nom" value=""> - 
			<input type="submit" value="Generer le PDF" >
		</form>
	</body>
</html>