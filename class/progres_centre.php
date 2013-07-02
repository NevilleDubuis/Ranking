<?php
echo '<page><h2>'.str_replace('_',' ',$name).'</h2>';
echo '<div class="soustitre">Coup centr&eacute; :</div>';
echo '<fieldset class="titre">';
include 'includes/conx_bd.php';
//cr�ation de la requ�te sql

$sql = 'SELECT id FROM person';
$id_person = mysql_query($sql) or die('requete invalide');
$n_shooter = mysql_num_rows($id_person);

//enregistrement du total de chaque tireur
while ($data = mysql_fetch_array($id_person)) {
    $person = $data['id'];
    $tab[$person] = 0;
    $sql = 'SELECT ';

    for ($i = 1; $i<=$number; $i++) {
        $sql .= 'shoot'.$i;
        if ($i<$number){
                    $sql .= ', ';
            }
    }

    $sql .= ' FROM '.$name.' WHERE id_shooter = '.$person;
    $res = mysql_query($sql) or die ("Requete invalide");
    $temp_centre= null;
    $n=1;
    if (mysql_num_rows($res)!=0) {
        while ($passe = mysql_fetch_array($res)) {
            for ($j=1; $j<=$number; $j++) {
                $sh = 'shoot'.$j;
                $temp_centre[$n] = $passe[$sh];
                $n++;
            }
        }
        if (!(isset($temp_centre[0]))) {
            rsort($temp_centre);

            $tot = 0;
            for ($i=0; $i<=4; $i++)  {
                if ($i <= 2 ) {
                    $tot += $temp_centre[$i];
                }
                $centre[$i]=$temp_centre[$i];
            }
            array_unshift($centre, $tot);
            $tab_centre[$person] = $centre;

        }
    }
}
$ind=1;

arsort($tab_centre);
$centre = $tab_centre;
reset($centre);
foreach ($tab_centre as $passe) {
    $sql = 'SELECT * FROM person WHERE id='.key($centre);
    next($centre);
    $res = mysql_query($sql);
    while ($data=mysql_fetch_array($res)) {
        echo '<div class="contenu"><div class="droite">'.$ind++.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
        if ($data['birthdate']!='0000-00-00') {
            echo date("d.m.Y", strtotime($data['birthdate']));
        }
        echo '</div>';
    }
    echo '<div class="tir">';
    $n = 0;
    $total = 0;
    array_shift($passe);
    foreach ($passe as $tir) {
        $total += $tir;
        $str = sprintf("%05s", $tir);
        echo str_replace('0', '&nbsp;', substr($str, 0, 3));
        echo substr($str, 3, 2);
        if ($n==2) {echo '&nbsp;&nbsp;&nbsp;<strong>Total :</strong>'.$total.'&nbsp;&nbsp;&nbsp;<strong>Appui :</strong>';}
        $n++;
    }
    echo '</div></div><br />';
}
echo '</fieldset></page>';

mysql_close ($base);
?>
