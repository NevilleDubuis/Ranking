<?php
echo '<page><h2>'.str_replace('_',' ',$name).'</h2>';
echo '<div class="soustitre">Classement par meilleure passe :</div>';
include 'includes/conx_bd.php';
//cr.ation de la requ.te sql

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
    $res = mysqli_query($base, $sql) or die ("Requ.te invalide");

    if (mysqli_num_rows($res)!= 0) {
        $total = 0;
        $appui = $tab_base;
        $n = 0;

        while ($passe = mysqli_fetch_array($res)) {
            for ($j=0; $j<=$number; $j++) {
                $sh = 'shoot'.$j;
                $best[$n] = $passe[$sh];
                $total += $passe[$sh];
                $n++;
            }
        }
        //enregistrement de la passe, du total et de l'appui
        rsort($best);
        $tab_chal_total[$person] = $total;
        $tab_chal[$person] = $best;
    }
}

arsort($tab_chal_total);
$egalite = 0;
$ind = 1;
foreach ($tab_chal_total as $key => $passe) {
    $sql = 'SELECT * FROM person WHERE id='.$key;
    $res = mysqli_query($base, $sql);
    while ($data=mysqli_fetch_array($res)) {
        $old_total = $total;
        $old_appui = $appui;
        $total = $tab_chal_total[$key];
        $appui = $tab_chal[$key][0];

        if ($total == $old_total) {
            if ($appui == $old_appui) {
                $egalite = 1;
            }
            else { $egalite = 0; }
        }
        else { $egalite = 0; }

        $class = $ind - $egalite;
        echo '<div class="contenu"><div class="droite">'.$class.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
        if ($data['birthdate']!='0000-00-00') {
            echo date("d.m.Y", strtotime($data['birthdate']));
        }
        echo '</div>';
    }
    echo '<div class="tir">';
    echo '&nbsp;&nbsp;&nbsp;<strong>Total :</strong>'.$tab_chal_total[$key];
    echo '&nbsp;&nbsp;&nbsp;<strong>Appui :</strong>'.$appui.' => ';
    foreach ($tab_chal[$key] as $tir) {
        if ($tir < 10) {
            echo '&nbsp;';
        }
        echo '&nbsp;&nbsp;'.$tir;
    }
    echo '</div></div><br />';
    $ind++;
}
echo '</page>';
mysqli_close ($base);

?>
