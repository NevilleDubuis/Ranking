<?php
echo '<page><h2>'.str_replace('_',' ',$name).'</h2>';
echo '<div class="soustitre">Addition :</div>';
include 'includes/conx_bd.php';
//cr�ation de la requ�te sql

$sql = 'SELECT id FROM person';
$id_person = mysqli_query($base, $sql);
$n_shooter = mysqli_num_rows($id_person);

//enregistrement du total de chaque tireur
while ($data = mysqli_fetch_array($id_person)) {
    $person = $data['id'];
    $tab[$person] = 0;
    $sql = 'SELECT ';

    for ($i = 1; $i<=$number; $i++) {
        $sql .= 'shoot'.$i;
        $sql .= ',  ';
    }

    for ($i = 1; $i<=$number; $i++) {
            $sql .= 'shoot'.$i;
            if ($i<$number){
                    $sql .= ' + ';
            }
    }

    $sql .= ' AS total FROM '.$name.' WHERE id_shooter = '.$person.' ORDER BY total DESC  LIMIT 0 , 3';
    $res = mysqli_query($base, $sql) or die ("Requ�te invalide");
    if (mysqli_num_rows($res) != 0) {
        $total=0;
            while ($passe = mysqli_fetch_array($res)) {
                $total += $passe['total'];
            }
        $tab[$person] = $total;
    }
}

//affichage des données
//------------------------------------------------------------------------------
arsort($tab);
reset($tab);
$ind=1;

for ($i=0; $i<=$n_shooter; $i++) {
    if (pos($tab)!=0) {

        //affichage du nom de la personne
        $sql = 'SELECT * FROM person WHERE id='.key($tab);
        $res = mysqli_query($base, $sql);
        while ($data=mysqli_fetch_array($res)) {
            echo '<div class="contenu"><div class="droite">'.$ind++.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
            if ($data['birthdate']!='0000-00-00') {
                echo date("d.m.Y", strtotime($data['birthdate']));
            }
            echo '</div>';
        }

        //création de la requete sql pour selectionner les 3 meilleurs passe
        $sql = 'SELECT ';

        for ($j = 1; $j<=$number; $j++) {
            $sql .= 'shoot'.$j;
            $sql .= ',  ';
        }

        for ($j = 1; $j<=$number; $j++) {
                $sql .= 'shoot'.$j;
                if ($j<$number){
                        $sql .= ' + ';
                }
        }

        $sql .= ' AS total FROM '.$name.' WHERE id_shooter = '.key($tab).' ORDER BY total DESC  LIMIT 0 , 3';
        $res = mysqli_query($base, $sql) or die('raté');
        $n_passe = 1;
        echo '<div class="tir">';
        //affichage des 3 passe concernée
        while ($data = mysqli_fetch_array($res)) {
            echo '&nbsp;&nbsp;&nbsp;<strong>passe '.$n_passe.' :</strong>';
            for ($j=0; $j<=$number; $j++) {
                $sh = 'shoot'.$j;
                if (isset($data[$sh])) {
                    $str = sprintf("%05s", $data[$sh]);
                    echo str_replace('0', '&nbsp;', substr($str, 0, 3));
                    echo substr($str, 3, 2);
                }
            }
            $n_passe++;
        }
        echo '&nbsp;&nbsp;&nbsp;<strong>Total :'.pos($tab).'</strong>';
        echo '</div></div><br />';
        next($tab);

    }
}
echo '</page>';
mysqli_close ($base);

?>
