<?php
	include 'conx_bd.php';
	$sql = 'INSERT INTO '.$_POST['bd'].' (	id_shooter,';
	for ($i = 1; $i<=$_POST['bd-number']; $i++) {
		$sql .= 'shoot'.$i;
		if ($i<$_POST['bd-number']){
			$sql .= ' ,';
		}
	}
	$sql .= ' ) VALUES ( '.$_POST['shoter_id'].',';
	for ($i = 1; $i<=$_POST['bd-number']; $i++) {
		$name = 'shoot'.$i;
		$sql .= $_POST[$name];
		if ($i<$_POST['bd-number']){
			$sql .= ' ,';
		}
	}
	$sql .= ' )';
	$res = mysql_query($sql);
	mysql_close ($base);
	$url='location: ../add_shoot.php?id='.$_POST['id'];
	header ($url);
?>