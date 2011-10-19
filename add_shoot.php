<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//fr" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">

<head>
	<link href="styles/forms.css" rel="stylesheet" type="text/css" />
	<link href="styles/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/forms.js"></script>
	<script type="text/javascript" src="scripts/load.js"></script>
</head>
<body>
<?php
	include 'includes/conx_bd.php';
	$id = $_GET['id'];
	$sql = 'SELECT name, number_shoot FROM events where id = '.$id;
	$res = mysql_query($sql);
	$data = mysql_fetch_array($res);
	$name = str_replace(" ","_",$data['name']);
	$number = $data['number_shoot'];
	mysql_close ($base);
?>

<fieldset>
    <legend>Passe</legend>
        <a href="add_person.php">ajouter un tireur</a>
        <form method="post" action="includes/shoot.php" id="formulaire">
        <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
        <input type="hidden" name="bd" id="bd" value="<?php echo $name ?>"/>
        <input type="hidden" name="bd-number" id="bd-number" value="<?php echo $number ?>"/>
        <br/>
        <label for="shoter_id" class="normal">Nom du tireur :</label>
        <select name="shoter_id" id="shoter_id">
            <?php
                    //cr�ation de la liste avec les entr�e de la base de donn�es
                    include 'includes/conx_bd.php';
                    $sql = 'SELECT * FROM person ORDER BY last_name';
                    $res = mysql_query($sql);
                    while ($data = mysql_fetch_array($res)) {
                            if ($data['birthdate']!='0000-00-00') {
                                    $birthdate = date("d.m.Y", strtotime($data['birthdate']));
                            }
                            else {
                                    $birthdate = '';
                            }
                            echo '<option value="'.$data['id'].'">'.$data['last_name'].' '.$data['first_name'].' '.$birthdate.'</option>';
                    }
                    mysql_close ($base);
            ?>
        </select><br/><br/>

        <?php
                //cr�ation du nombre de champs correspondant au nombre de tir
                for ($i=1; $i <= 10 && $i <= $number; $i++) {
                        echo'
                        <label for="shoot'.$i.'" class="shoot">Coup '.$i.' :</label>';
                }
                echo '<br />';
                for ($i=1; $i <= 10 && $i <= $number; $i++) {
                        echo'<input type="text" name="shoot'.$i.'" id="shoot'.$i.'" class="shoot" size="3"/>';
                }
                echo '<br /><br />';

                if ($number > 10) {
                    for ($i=11; $i <= 20 && $i <= $number; $i++) {
                            echo'
                            <label for="shoot'.$i.'" class="shoot">Coup '.$i.' :</label>';
                    }
                    echo '<br />';
                    for ($i=11; $i <= 20 && $i <= $number; $i++) {
                            echo'<input type="text" name="shoot'.$i.'" id="shoot'.$i.'" class="shoot" size="3"/>';
                    }
                    echo '<br /><br />';
                }
        ?>

        <input type="submit" value="envoyer" id="submit" class="submit"/>
        <input type="reset" value="effacer" id="reset"/>
        <input type="button" value="retour" onclick="window.location='index.php';"/>

        </form>

    </fieldset>
    <?php
        echo '<fieldset class="titre"><legend>Passe Enregistr&eacute;e</legend>';
        include 'includes/conx_bd.php';
        //cr�ation de la requ�te sql
        $sql = 'SELECT '.$name.'.*, person.* FROM '.$name.' INNER JOIN person
                        ON '.$name.'.id_shooter = person.id ORDER BY ';
        for ($i = 1; $i<=$number; $i++) {
                $sql .= 'shoot'.$i;
                if ($i<$number){
                        $sql .= ' + ';
                }
        }
        $sql .= ' DESC';

        $req = mysql_query($sql) or die ("Requ�te invalide");
        $i=0;

        //affichage des donn�es
        while ($data = mysql_fetch_array($req)) {
            echo '<div class="contenu"><div class="droite">'.$ind.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
            if ($data['birthdate']!='0000-00-00') {
                    echo date("d.m.Y", strtotime($data['birthdate']));
            }
            $total = 0;
            echo '</div>';
            echo '<div class="tir">';
            for ($i=1;$i<=$number;$i++) {

                $name = 'shoot'.$i;
                if (isset($data[$name])) {
                    $str = sprintf("%05s", $data[$name]);
                    echo str_replace('0', '&nbsp;', substr($str, 0, 3));
                    echo substr($str, 3, 2);
                    $total += $data[$name];
                }
            }
            echo '&nbsp;&nbsp;<strong>Total :'.$total.'</strong>';
            echo '</div>';
            echo '</div><br/>';
        }
        echo '</fieldset>';
        mysql_close ($base);
    ?>

</body>
</html>