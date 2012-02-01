<?php
    echo '<page><h2>'.str_replace('_',' ',$name).'</h2>';
    echo '<div class="soustitre">Classement altern&eacute; :</div>';
    echo '<fieldset class="titre">';
    include 'includes/conx_bd.php';

    //varaibles necessaire a la recherche
    reset($tab);
    $count_tab = count($tab_centre);
    reset($tab_centre);
	$shooter_in = array();
    $ind = 1;

    //tri pour classement alterné
    while ($count_tab!=0) {
        //classement a l'adition
        $search = true;
        //cherche dans la liste si l'id de la personne existe
        while ($search) {
            $inlist = false;
            foreach ($shooter_in as $shooter) {
                if ($shooter == key($tab)) {
                        $inlist = true;
                }
            }
            //si elle n'y est pas on affiche le résultat et on sort
            if (!($inlist)) {
                $sql = 'SELECT * FROM person WHERE id='.key($tab);
                $res = mysql_query($sql);
                while ($data=mysql_fetch_array($res)) {
                    echo '<div class="contenu"><div class="droite">'.$ind++.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
                    if ($data['birthdate']!='0000-00-00') {
                        echo date("d.m.Y", strtotime($data['birthdate']));
                    }
                    echo '</div></div><br />';
                }
                $shooter_in[$ind]=key($tab);
                $count_tab--;
                $search = false;
            }
            next($tab);
        }
      
        //classement au coup centré, si il y a encore des personnes a afficher.
        if ($count_tab!=0){
            $search = true;
            //tant qu'on as pas afficher de tireur
            while ($search) {
                //si la personne n'est pas dans la liste
                $inlist = false;
                foreach ($shooter_in as $shooter) {
                    if ($shooter == key($tab_centre)) {
                            $inlist = true;
                    }
                }
                if (!($inlist)) {
                    $sql = 'SELECT * FROM person WHERE id='.key($tab_centre);
                    $res = mysql_query($sql);
                    while ($data=mysql_fetch_array($res)) {
                        echo '<div class="contenu"><div class="droite">'.$ind++.'. '.$data['last_name'].'  &nbsp; &nbsp;'.$data['first_name'].'  &nbsp; &nbsp;';
                        if ($data['birthdate']!='0000-00-00') {
                            echo date("d.m.Y", strtotime($data['birthdate']));
                        }
                        echo '</div></div><br />';
                    }
                    $shooter_in[$ind]=key($tab_centre);
                    $count_tab--;
                    $search = false;
               }
               next($tab_centre);
               if (current($tab_centre)== 0) {
                   break;
               }
            }
        }

    }
    echo '</fieldset></page>';
    mysql_close ($base);
?>
