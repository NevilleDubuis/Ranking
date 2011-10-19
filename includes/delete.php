<?php
	include 'conx_bd.php';
	$id = $_GET['id'];
	$sql = 'SELECT name FROM events where id = '.$id;
	$res = mysql_query($sql);
	$data = mysql_fetch_array($res);
	$name = str_replace(" ","_",$data['name']);
	$sql = 'DROP TABLE '.$name;
	$res = mysql_query($sql);
	$sql = 'DELETE FROM events WHERE id = '.$id;
	$res = mysql_query($sql);
	mysql_close ($base);
	header ('location: ../index.php');
?>