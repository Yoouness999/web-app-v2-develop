<?php
    $etage=0;$volume=0;$str_duree="Moins de 6 mois";
    $nb_objets=0;$nb_obj_fragiles=0;
    $nb_obj_toDo=0;$nb_obj_done=0;$nb_obj_notDo=0;$nb_obj_2pers=0;$aide=0;
    $info=
        [ 
        "str_duree"=>array("min_6"=>"Moins de 6 mois","plus_6"=>"Plus de 6 mois"),
        "camion" =>                     //prix et type de camionnettes
            [
                0=>["cat"=>"Camionette Boxify", "prix"=>0],
                1=>["cat"=>"Camionette Boxify", "prix"=>61.98],
                2=>["cat"=>"Camionette Sixt", "prix"=>0],
                3=>["cat"=>"Camionette Sixt", "prix"=>100],
                4=>["cat"=>"Camionette Sixt", "prix"=>200],
                5=>["cat"=>"Camion d&eacute;m&eacute;nageur", "prix"=>200]
            ],
        "lift"=>                             //prix et catégorie des lifts
            [ 
                ["cat"=>"Pas de lift", "prix"=>0],
                ["cat"=>"Petit lift", "prix"=>61.98],
                ["cat"=>"Grand lift", "prix"=>150]
            ],
        "etages"=>[0,2,7,16],           //différents seuils des étages
        "volCamion"=>[40,21,18,14],     //différents seuils utilisés pour le calcul et le type de camion
        "volPersonnes"=>[0,6,11,21,31], //différents seuils utilisés pour le calcul du nombres de personnes nécessaires
        "prixHomme"=>37.2,
        "personne" =>  //gestion des déménageurs, nombres de personnes et prix correspondants
            [
                0=>['nb'=>1,'prix'=>0],
                1=>['nb'=>2,'prix'=>0],
                2=>['nb'=>2,'prix'=>1],
                3=>['nb'=>2,'prix'=>2],
                4=>['nb'=>3,'prix'=>3],
                5=>['nb'=>4,'prix'=>4],
            ],
        "volEtage"=>[10,5,4], //volume traité en fonction de l'étage
        "seuil_nbObjets_volume"=>5, //seuil au-delà du quel s'applique le malus dans le cas où il y a beaucoup d'objets au m³
        "malus_nbObjets_volume"=>20, //coefficient du malus en % appliqué dans le cas où il y a beaucoup d'objets au m³
        "demontage"=>2/3, //temps (en heure) pour le démontage d'un objet
        "fragile"=>1/6, // temps (en heure) pour la manutention d'objets fragiles
        "assurance"=>150, //couverture (en euros de l'assurance)
        ];
    
    $submit=false;
    if(!empty($_POST))
    {
        
        $submit=true;

        $str_duree=$info['str_duree'][$_POST['duree']];
        $lift=selectLift($_POST['etage']);
        $camion=selectCamion($_POST['volume'],$_POST['duree'],$_POST['etage']);
        $heurePers=processNbHeuresPerso($_POST['etage'],$_POST['volume'],$_POST['nb_objets'],$_POST['nb_obj_toDo'],$_POST['nb_obj_fragiles']);
        $personnes=selectNbPersonne($_POST['etage'], $_POST['volume'], $_POST['nb_objets'], $_POST['nb_obj_toDo'],$_POST['nb_obj_done'],$_POST['nb_obj_2pers'],$_POST['aide']);
        $heures=$heurePers['final'] / $personnes['nb'];
        $heuresFacturees=processHeuresFacturees($heures, $personnes['nb'],$_POST['etage']);
        $personnes['prix']*=$info['prixHomme'];
        $frais=$heuresFacturees * ($personnes['prix'] + $lift['prix'] ) + $camion['prix'];
        $asstotale=$info['assurance']*$_POST['volume'];

        $etage=intval($_POST['etage']);$volume=intval($_POST['volume']); 
        $nb_objets=intval($_POST['nb_objets']);
        $nb_obj_fragiles=intval($_POST['nb_obj_fragiles']); $nb_obj_toDo=intval($_POST['nb_obj_toDo']);
        $nb_obj_done=intval($_POST['nb_obj_done']); 
        $nb_obj_notDo=$nb_objets-$nb_obj_toDo-$nb_obj_done;
        $nb_obj_2pers=intval($_POST['nb_obj_2pers']);$aide=intval($_POST['aide']);


        $var0_lift=selectLift(0);
        $var0_camion=selectCamion($_POST['volume'],$_POST['duree'],0);
        $var0_heurePers=processNbHeuresPerso(0,$_POST['volume'],$_POST['nb_objets'],$_POST['nb_obj_toDo'],$_POST['nb_obj_fragiles']);
        $var0_personnes=selectNbPersonne(0, $_POST['volume'], $_POST['nb_objets'], $_POST['nb_obj_toDo'],$_POST['nb_obj_done'],$_POST['nb_obj_2pers'],$_POST['aide']);
        $var0_heures=$var0_heurePers['final'] / $var0_personnes['nb'];
        $var0_heuresFacturees=processHeuresFacturees($var0_heures, $var0_personnes['nb'],0);
        $var0_personnes['prix']*=$info['prixHomme'];
        $var0_frais=$var0_heuresFacturees * ($var0_personnes['prix'] + $var0_lift['prix'] ) + $var0_camion['prix'];
    
    }
    else
    {   $_POST['volume']="0";
        $_POST['etage']="0";
        $_POST['duree']="min_6";
        $_POST['nb_objets']="0";
        $_POST['nb_obj_fragiles']="0";
        $_POST['nb_obj_toDo']="0";
        $_POST['nb_obj_done']="0";
        $_POST['nb_obj_2pers']="0";
        $_POST['aide']="0";
    }

    function selectLift($etage)
    {
        global $info;
        if($etage==$info['etages'][0])
        {
            return $info['lift'][0];
        }
        if($etage<$info['etages'][2])
        {
            return $info['lift'][1];
        }
        if($etage<$info['etages'][3])
        {
            return $info['lift'][2];
        }
    }

    function selectCamion($volume,$duree,$etage)
    {
        global $info;
        $v=$info['volCamion'];
        $c=$info['camion'];
        if($volume>=$v[0])
        {
            return $c[5];
        }
        if($volume>=$v[1])
        {
            if($etage>=1){return $c[5];}
            if($etage==0){
                if($duree=="min_6"){return $c[4];}
                return $c[2];
            }
        }
        if($volume>=$v[2])
        {
            if($duree=='min_6'){return $c[3];}
            return $c[2];
        }
        if($volume>=$v[3])
        {
            if($duree=='min_6'){return $c[1];}
            return $c[0];
        }
        return $c[0];
    }

    function processNbHeuresPerso($etage,$volume,$nb_objets,$nb_obj_toDo,$nb_obj_fragiles)
    {
        global $info;
        $e=$info['etages'];$v=$info['volEtage'];
        $coeff=100;$volHoraire=0;
        if($etage==$e[0])
        {
            $volHoraire=$v[0];
        }elseif($etage<=$e[2])
        {
            $volHoraire=$v[1];
        }else
        {
            $volHoraire=$v[2];
        }
        $nbheure["volumeHoraire"]=$volHoraire;
        if($nb_objets/$volume>$info["seuil_nbObjets_volume"])
        {
            $coeff+=$info["malus_nbObjets_volume"];
        }
        $nbheure['coeff']=$coeff;
        $nbheure['brut']=($volume/$volHoraire);
        $nbheure['final']=($volume/$volHoraire)*($coeff/100);
        $nbheure['final']+=($info["demontage"]*$nb_obj_toDo)+($info["fragile"]*$nb_obj_fragiles);
        $nbheure['demontage']=($info["demontage"]*$nb_obj_toDo);
        $nbheure['fragile']=($info["fragile"]*$nb_obj_fragiles);
        return $nbheure;
    }
    function selectNbPersonne($etage, $volume, $nb_objets, $nb_obj_toDo,$nb_obj_done,$nb_obj_2pers,$aide)
    {
        global $info;
        $p=$info['personne'];
        $e=$info['etages']; //[0,2,7,16],
        $v=$info['volPersonnes'];//[0,6,11,21,31]
        if($etage==0)
        {
            if($volume>=$v[4]){return $p[5];}
            if($volume>=$v[3]){return $p[4];}
            if($volume>=$v[2]){return $p[3];}
            if($volume>=$v[1])
            {
                if($nb_obj_toDo!=0){return $p[3];}
                if($nb_obj_2pers==0){return $p[1];}
                if($aide==0){return $p[3];}
                return $p[0];
            }
            else
            {if($nb_obj_toDo!=0){return $p[3];}
            if($nb_obj_2pers==0){return $p[0];}
            if($aide==1){return $p[0];}
            return $p[2];}
        }
        if($etage<$e[2])
        {
            if($volume>=$v[3]){return $p[5];}
            if($volume>=$v[1]){return $p[4];}
            return $p[3];
        }
        if($etage<$e[3])
        {
            if($volume>=$v[1]){return $p[5];}
            return $p[4];
        }
    }
    function processHeuresFacturees($heures, $nbPers, $etage)
    {
        global $info;
        $e=$info['etages'];
        $gift=0;
        if($etage<=$e[0])
        {
            if($nbPers<=2)
            {
                $gift=1;
            }
        }
        $h=($heures>$gift)?($heures-$gift):0;
        return ceil($h);
    }

    function toStringHours($hours)
    {
        $heure=floor($hours);
        $minutes=ceil(($hours-$heure)*60);
        return $heure."h".$minutes; 
    }
?>

<html>
<header>
    <title>Frais</title>
    <style>
        table{border-collapse: collapse;}
        td, th{border: 1px solid black;}
        .colorGreen{color:forestGreen;}
        .colorOrange{color:chocolate;}
    </style>
</header>
<body>
    <form method="post">
        <ul>
            <li>Volume :<br /> <input type='number' name='volume' id='volume' class='inputNumber' value=<?=intval($_POST['volume'])?> /> m&sup3;</li>
            <li>Etage :<br /> <input type='number' name='etage' id='etage' class='inputNumber' value=<?=intval($_POST['etage'])?> /></li>
            <li>Dur&eacute;e de stockage :<br /> <select name='duree' id='duree' class='inputSelect' >
                    <option value="min_6" <?php if($_POST['duree']=="min_6") echo "selected";?>>Moins de 6 mois</option>
                    <option value="plus_6" <?php if($_POST['duree']=="plus_6") echo "selected";?>>Plus de 6 mois</option>
                </select></li>
            <li>Nombre d'objets :<br /> <input type='number' name='nb_objets' id='nb_objets' class='inputNumber' value=<?=intval($_POST['nb_objets'])?> /></li>
            <li>Nombre d'objets fragiles :<br /> <input type='number' name='nb_obj_fragiles' id='nb_obj_fragiles' class='inputNumber' value=<?=intval($_POST['nb_obj_fragiles']) ?> /></li>
            <li>Nombre d'objets &agrave; d&eacute;monter :<br /> <input type='number' name='nb_obj_toDo' id='nb_obj_toDo' class='inputNumber' value=<?=intval($_POST['nb_obj_toDo']) ?> /></li>
            <li>Nombre d'objets d&eacute;mont&eacute;s :<br /> <input type='number' name='nb_obj_done' id='nb_obj_done' class='inputNumber' value=<?=intval($_POST['nb_obj_done']) ?> /></li>
            <li>Nombre d'objet transportable par deux personnes :<br /> <input type='number' name='nb_obj_2pers' id='nb_obj_2pers' class='inputNumber' value=<?=intval($_POST['nb_obj_2pers']) ?> /></li>
            
            <li>Personne aidante (client) :<br /> <select name='aide' id='aide' class='inputSelect' >
                    <option value="0" <?php if($_POST['aide']=="0") echo "selected";?>>Non</option>
                    <option value="1" <?php if($_POST['aide']=="1") echo "selected";?>>Oui</option>
                </select></li>
        </ul>
        <input type="submit" value="calculer">  <input type="button" onClick='faireReset()' value="Reset"/>
    </form>
    <?php if($submit):?>
    <table id='tab_summarize'>
        <tr><td>Volume</td><td><?=$volume;?> m&sup3;</td></tr>
        <tr><td>Dur&eacute;e de stockage</td><td><?=$str_duree;?></td></tr>
        <tr><td>Nombre d'objets</td><td><?=$nb_objets;?></td></tr>
        <tr><td>Nombre d'objets fragiles</td><td><?=$nb_obj_fragiles;?></td></tr>
        <tr><td>Nombre d'objets &agrave; d&eacute;monter</td><td><?=$nb_obj_toDo;?></td></tr>
        <tr><td>Nombre d'objets d&eacute;mont&eacute;s</td><td><?=$nb_obj_done;?></td></tr>
        <tr><td>Nombre d'objets non-d&eacute;montables</td><td><?=$nb_obj_notDo;?></td></tr>
        <tr><td>Nombre d'objet transportable par deux personnes</td><td><?=$nb_obj_2pers;?></td></tr>
        <tr><td>Personne en plus</td><td> <?=($aide==0)?"non":"oui"; ?></td></tr>
    </table>
    <br />
    <table id='tab_processes'>
        <tr><th>Frais</th><th>&Eacute;tage client : <?=$etage;?></th><th>Rez de Chauss&eacute;e</th></tr>
        <tr><th>Nombre d'heures-personne</th><td><?=toStringHours($heurePers['final']);?></td><td><?=toStringHours($var0_heurePers['final']);?></td></tr>
        <tr><th>Volume horaire par personne</th><td><?=$heurePers["volumeHoraire"];?></td><td><?=$var0_heurePers["volumeHoraire"];?></td></tr>
        <tr><th>Coefficient "petits objets"</th><td><?=$heurePers['coeff'];?> %</td><td><?=$var0_heurePers['coeff'];?> %</td></tr>
        <tr><th>Nombre d'heure "brute"</th><td><?=toStringHours($heurePers['brut']);?></td><td><?=toStringHours($var0_heurePers['brut']);?></td></tr>
        <tr><th>Temps pour le d&eacute;montage</th><td><?=toStringHours($heurePers['demontage']);?></td><td><?=toStringHours($var0_heurePers['demontage']);?></td></tr>
        <tr><th>Temps pour les objets fragiles</th><td><?=toStringHours($heurePers['fragile']);?></td><td><?=toStringHours($var0_heurePers['fragile']);?></td></tr>
        <tr><th>Nombre de personnes &agrave; envoyer</th><td><?=$personnes['nb'];?> - <?=$personnes['prix'];?> &euro;/heure</td><td><?=$var0_personnes['nb'];?> - <?=$var0_personnes['prix'];?> &euro;/heure</td></tr>
        <tr><th>Nombre d'heures r&eacute;elles</th><td><?=toStringHours($heures);?></td><td><?=toStringHours($var0_heures);?></td></tr>
        <tr><th>Nombre d'heures factur&eacute;es</th><td><?=$heuresFacturees;?></td><td><?=$var0_heuresFacturees;?></td></tr>
        <tr><th>Lift</th><td><?=$lift["cat"];?> - <?=$lift['prix'];?> &euro;</td><td><?=$var0_lift["cat"];?> - <?=$var0_lift['prix'];?> &euro;</td></tr>
        <tr><th>Camion</th><td><?=$camion['cat'];?> - <?=$camion['prix'];?> &euro;</td><td><?=$var0_camion['cat'];?> - <?=$var0_camion['prix'];?> &euro;</td></tr>
        <tr><th class='colorOrange'>Couverture Assurance boxify</th><td class='colorOrange'><em><?=$asstotale;?> &euro; </em></td><td class='colorOrange'><em><?=$asstotale;?> &euro;</em></td></tr>
        <tr><th>Total des frais (HTVA)</th><td><span><?=number_format($frais,2);?> &euro;</span></td><td><span><?=number_format($var0_frais,2);?> &euro;</span></td></tr>
        <tr><th class='colorGreen'>Total des frais (TVAC)</th><td><span class='colorGreen'><?=number_format($frais*1.21,2);?> &euro;</span> </td><td><span class='colorGreen'><?=number_format($var0_frais*1.21,2);?> &euro;</span></td></tr>
    </table>
    <?php endif; ?>
</body>
<script type="text/javascript">
        function faireReset()
        {
            document.getElementById('volume').value=0;
            document.getElementById('etage').value=0;
            document.getElementById('nb_objets').value=0;
            document.getElementById('nb_obj_fragiles').value=0;
            document.getElementById('nb_obj_toDo').value=0;
            document.getElementById('nb_obj_done').value=0;
            document.getElementById('nb_obj_2pers').value=0;
            document.getElementById('aide').selectedIndex = 0;
            document.getElementById("duree").selectedIndex = 0;
            document.getElementById("tab_summarize").style.display = "none";
            document.getElementById("tab_processes").style.display = "none";
        }
    </script>
</html>