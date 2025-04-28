<?php
	include 'conx_bd.php';
	$id = $_GET['id'];
	$sql = 'SELECT name FROM events where id = '.$id;
	$res = mysqli_query($base, $sql);
	$data = mysqli_fetch_array($res);
	$name = str_replace(" ","_",$data['name']);
	$sql = 'DROP TABLE '.$name;
	$res = mysqli_query($base, $sql);
	$sql = 'DELETE FROM events WHERE id = '.$id;
	$res = mysqli_query($base, $sql);
	mysqli_close($base);
	header ('location: ../index.php');
?>