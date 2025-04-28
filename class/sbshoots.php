<?php
echo '<page><h2>'.str_replace('_',' ',$name).'</h2>';
echo '<div class="soustitre">Classement par meilleure passe :</div>';
include 'includes/conx_bd.php';

$sql = 'SELECT id FROM person';
$id_person = mysqli_query($base, $sql);
$n_shooter = mysqli_num_rows($id_person);


//initialisation des variables
for ($i=0;$i<11;$i++) {
    $tab_base[$i]=0;
}
krsort($tab_base);

//enregistrement des passes, du total, et des appuis de chaque tireur
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

    $sql .= ' AS total FROM '.$name.' WHERE id_shooter = '.$person.' ORDER BY total DESC  LIMIT 0 , 1';
    $res = mysqli_query($base, $sql) or die ("Requ�te invalide");

    if (mysqli_num_rows($res)!= 0) {
        $total = 0;
        $appui = $tab_base;
        $n = 0;

        while ($passe = mysqli_fetch_array($res)) {
            for ($j=1; $j<=$number; $j++) {
                $sh = 'shoot'.$j;
                $best[$n] = $passe[$sh];
                $total += $passe[$sh];
                $n++;
            }
        }
        //enregistrement de la passe, du total et de l'appui
        rsort($best);
        $tab_chal_total[$person] = $total;
        $best[0] = $total;
        $tab_chal[$person] = $best;
    }
}

arsort($tab_chal);

$ind = 1;
foreach ($tab_chal as $key => $passe) {
    $sql = 'SELECT * FROM person WHERE id='.$key;
    $res = mysqli_query($base, $sql);
    while ($data=mysqli_fetch_array($res)) {
        echo '<div class="contenu"><div class="droite">'.$ind++.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
        if ($data['birthdate']!='0000-00-00') {
            echo date("d.m.Y", strtotime($data['birthdate']));
        }
        echo '</div>';
    }
    echo '<div class="tir">';

    echo '&nbsp;&nbsp;&nbsp;<strong>Total :</strong>'.$tab_chal_total[$key];
    echo '&nbsp;&nbsp;&nbsp;<strong>Appui :</strong>';

    for ($i=1; $i<$number; $i++){
        if ($passe[$i] < 10) {
            echo '&nbsp;';
        }
        echo '&nbsp;&nbsp;'.$passe[$i];
    }
    echo '</div></div><br />';
}
echo '</page>';
mysqli_close ($base);






/*



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

$req = mysqli_query($base, $sql) or die ("Requ�te invalide");
$ind=1;
$tab[0]=0;

for ($i=0;$i<11;$i++) {
    $tab_base[$i]=0;
}
krso
//affichage des donn�es
while ($data = mysqli_fetch_array($req)) {
    $inlist = false;
    foreach ($tab as $shooter) {
        if ($shooter == $data['id_shooter']) {
                $inlist = true;
        }
    }
    if (!($inlist)) {
        $old_total = $total;
        $old_appui = $appui;
        $total = 0;
        $appui = $tab_base;
        for ($i=1;$i<=$number;$i++) {
            $sh = 'shoot'.$i;
            $total += $data[$sh];
            $appui[$data[$sh]] += 1;
        }

        $egalite = 0;
        if ($total == $old_total) {
            if ($appui == $old_appui) {
                    $egalite = 1;
            }
        }
        $classement = $ind - $egalite;
        echo '<div class="contenu"><div class="droite">'.$classement.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
                if ($data['birthdate']!='0000-00-00') {
                    echo date("d.m.Y", strtotime($data['birthdate']));
                }
        echo '</div>';
        echo '<div class="tir">';

        for ($i=1;$i<=$number;$i++) {
            $sh = 'shoot'.$i;
            $str = sprintf("%05s", $data[$sh]);
            echo str_replace('0', '&nbsp;', substr($str, 0, 3));
            echo substr($str, 3, 2);
        }

        echo '&nbsp;&nbsp;<strong>Total :</strong>'.$total;
        echo '&nbsp;&nbsp;<strong>Appui :</strong>';
        print_r($appui);
        echo '</div>';
        echo '</div><br/>';

        $tab[$ind]=$data['id_shooter'];
        $ind++;
        }
    }

//si aucune passe
if (mysqli_num_rows($req) == 0) {
    echo '<p>aucun tir enregistr�</p>';
}
echo '</fieldset></page>';
mysqli_close ($base);
*/
?>
