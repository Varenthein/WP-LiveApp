<?php 
if($T->Stat == "Odwołane") { $CON .= '<br><center><h2 class="widget-title">Zawody odwołane</h2></center><br>';

} else {

function compareRowsPoz($a, $b)
{
    if ($a->poz == $b->poz) {
        return 0;
    }
    return ($a->poz > $b->poz) ? 1 : -1;
}
function compareRowsNota($a, $b)
{
    if ($a->nota == $b->nota) {
        return 0;
    }
    return ($a->ranking > $b->ranking) ? 1 : -1;
}
function compareTwo($a, $b) {
    if ($a->kraj == $b->kraj) {
        return $a->poz - $b->poz;
    }
    return strcmp($a->kraj, $b->kraj);
}

function getTeamsFromPlayers($ARRAY) {
usort($ARRAY, "compareTwo");
$Kraj;
$KRAJE = array();
foreach($ARRAY as $P) {
if($P->kraj != $Kraj and $P->kraj != "") {  $Kraj = $P->kraj; $KRAJE[] = (object) array(
    'name'=> $P->kraj
); }
}
return $KRAJE; 
}
                                                                      
function createTeams($array) {
usort($array, "compareTwo");
$actKraj = "";
$newArray = array();
$Rezultat = 0;
$First = 0;
$Second = 0;

foreach($array as $A) {
if($A->kraj != $actKraj) {


$newArray[$actKraj][6] = new stdClass();
$newArray[$actKraj][6]->first = $First;
$newArray[$actKraj][6]->sec = $Second;
$newArray[$actKraj][6]->nota = $Rezultat;
$actKraj = $A->kraj; $Rezultat = 0;  $First = 0; $Second = 0; 
 }                     
$newArray[$actKraj][] = $A; $Rezultat += $A->nota; $First += $A->first; $Second += $A->sec;
}
$newArray[$actKraj][6] = new stdClass();
$newArray[$actKraj][6]->first = $First;
$newArray[$actKraj][6]->sec = $Second;
$newArray[$actKraj][6]->nota = $Rezultat;

return $newArray;
}

function checkDSQ($array)  {
foreach($array as $el) {
if($el->nota == 'DSQ' or $el->nota == "") { $el->poz = '5000'; $rest[] = $el; }
else $gora[] = $el;
}
$newArray = array();
if($gora) { foreach($gora as $el) $newArray[] = $el;  }
if($rest) { foreach($rest as $el) $newArray[] = $el; }
return $newArray;
}

function PorzadkujTCS($array)  {

foreach($array as $el) {
if($el->top == 'true') { $rest[] = $el; }
else $gora[] = $el;
}
$newArray = array();
if($gora) { usort($gora,"compareRowsNota"); foreach($gora as $el) $newArray[] = $el;  }
if($rest) { usort($rest,"compareRowsNota"); foreach($rest as $el) $newArray[] = $el; }
return $newArray;
}
$CON .= "<div class='rezerwowi' style='width:100%;'><h2 class='widget-title buts four skoki'><a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl1\").delay(100).css(\"display\",\"block\"); ' style='width: 100%;  padding:5px 320px;border:none;border-bottom:1px solid #fff;color:#fff;background:#d82824;font-size:12pt;font-family:Uni Sans;font-weight:bold;margin:0px; '>".(($T->KaryGosc == "" and $T->Stat != "Zawody przerwane") ? 'Wyniki LIVE' : 'Klasyfikacja')."</a><br><a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl2\").delay(100).css(\"display\",\"block\");'>Lista startowa</a>";

$CON .= "<a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl6\").delay(100).css(\"display\",\"block\");'>Wyniki I serii</a><a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl7\").delay(100).css(\"display\",\"block\");'>Wyniki II serii</a>";

$CON .= "<a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl5\").delay(100).css(\"display\",\"block\");'>Kalendarz</a>";

if($T->Turniej != "brak" and $T->Turniej != "") $CON .= "<a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl3\").delay(100).css(\"display\",\"block\");'>Klasyfikacja</a>";

$CON .= "</h2><div style='width:100%;max-height:466px;overflow:auto;'><div class='slides'><section id='sl1'".(($T->Stat == "") ? " style='display:none'" : "").">";

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 

if($Stadion->Typ == 'Indywidualne' or $Stadion->Typ == 'TCS' and $T->KaryGosp != "") { 

if($T->KaryGosc == "") {
$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:350px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Rezultat</td></tr></thead>';
} else {
$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:350px;">Zawodnik</td><td style="text-align:center;">I seria</td><td style="text-align:center;">II seria</td><td style="text-align:center;">Rezultat</td></tr></thead>';
}

} else if($Stadion->Typ == 'TCS' and $T->KaryGosp == "") { 

//Wyniki LIVE TCS pierwsza Seria 

if($SkladGosp != NULL) { 

$SkladGosp = checkDSQ($SkladGosp);
$i=0;
foreach($SkladGosp as $P) { $i++;

if($P->poz == '5000') { $P->poz = 'DSQ'; }

if($i%2 != 0) $CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:350px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Rezultat</td></tr></thead>';

$CON .= '<tr '.(($P->top == "true") ? 'style="opacity:0.5" ' : '').'class="player rez"><td class="pozycja"><b>'.(($P->poz == 'DSQ') ? 'DSQ' : $P->poz).'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f', (($T->KaryGosp != "") ? $P->sec : $P->first)).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';

if($i%2 == 0) $CON .= "</table>"; 
}
}



 } else {
$FIRST = 0;
$SEC = 0;
$NOTA = 0;
}

if($SkladGosp != NULL) { 

$SkladGosp = checkDSQ($SkladGosp);
usort($SkladGosp, "compareRowsPoz");


 
function compareRows($a, $b)
{
    if ($a->kraj == $b->kraj) {
        return 0;
    }
    return ($a->kraj < $b->kraj) ? 1 : -1;
}


//WYNIKI LIVE

if($Stadion->Typ == "Drużynowe") {

if($T->KaryGosc == "" and $T->Stat != "Zawody przerwane") {

$Judge = json_decode(stripslashes_deep($T->Judge)); 
if($Judge != NULL) {
$Sklad = createTeams($SkladGosp);

usort($Judge, function($a, $b) use ($Sklad) {
        $a = array_pop($Sklad[$a->name])->nota;
        $b = array_pop($Sklad[$b->name])->nota;
    
    if ($a == $b) {
        $ret = 0;
    }
    $ret = ($a > $b) ? -1 : 1;
    return $ret;
});

//function getItSorted($a,$b,$sklad)
//var_dump($Sklad);
//usort($Judge, "comparebyPkt");

foreach($Judge as $kraj) {

$CON .= '<i>'.$kraj->name.'</i><table style="width:100%"><thead><tr><td>Poz.</td><td>Kraj</td><td style="width:400px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Rezultat</td></tr></thead>';

foreach(array_slice($Sklad[$kraj->name],0,count($Sklad[$kraj->name])-1)  as $P) { 

if($P->poz == '5000') { $P->poz = 'DSQ'; }

$CON .= '<tr class="player rez"><td class="pozycja"><b>'.(($P->poz == 'DSQ') ? 'DSQ' : $P->poz).'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f', (($T->KaryGosp != "") ? $P->sec : $P->first)).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';   
 
}

$info = array_pop($Sklad[$kraj->name]); 
$CON .= '<tfoot><tr><td>Razem</td><td></td><td style="width:300px;"></td><td></td><td style="text-align:center">'.sprintf('%0.1f',$info->nota).'</td></tr></tfoot></table>'; 


}
}
} else {

//KLASYFIKACJA DRUZYNOWA 

$CON .= '<table style="width:100%"><thead>
<tr>
<td></td>
<td style="width:20px;">Kraj</td>
<td>Drużyna</td>
<td>Zawodnicy</td>
<td>Punkty</td>
</tr>
</thead>';

foreach($SkladGosp as $P) {  $i++;  
if($P->poz == '5000') { $P->poz = 'DSQ'; }

if($T->KaryGosc != "" or $T->Stat == "Zawody przerwane"){
switch($P->poz) {
case 1: 
$P->poz = '<img class="flaga" src="'.plugins_url('../img/zlotymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#ffbf11;"';
break;
case 2:
$P->poz = '<img class="flaga" src="'.plugins_url('../img/srebrnymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#fff;"';
break;
case 3:
$P->poz = '<img class="flaga" src="'.plugins_url('../img/brazowymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#d39d58;margin-bottom:5px;"';
break;
default:
$styl = '';
break;
}
}
$CON .= '<tr class="player rez"'.$styl.'><td class="pozycja"><b>'.$P->poz.'</b></td><td><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->name.'.png', __FILE__ ).'" alt=""></td><td '.$styl.'>'.$P->name.'</td><td>'.$P->zawodnicy.'</td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';  

}



}

} else if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == 'TCS' and $T->KaryGosp != "") {


if($Stadion->Typ == 'Drużynowe') usort($SkladGosp, "compareTwo"); $i=0;
foreach($SkladGosp as $P) {  $i++;  
if($P->poz == '5000') { $P->poz = 'DSQ'; }

if($T->KaryGosc != "" or $T->Stat == "Zawody przerwane"){
switch($P->poz) {
case 1: 
$P->poz = '<img class="flaga" src="'.plugins_url('../img/zlotymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#ffbf11;"';
break;
case 2:
$P->poz = '<img class="flaga" src="'.plugins_url('../img/srebrnymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#fff;"';
break;
case 3:
$P->poz = '<img class="flaga" src="'.plugins_url('../img/brazowymedal.png', __FILE__ ).'" alt="">';
$styl = ' style="font-weight:bold;//background:#d39d58;margin-bottom:5px;"';
break;
default:
$styl = '';
break;
}
}

if($T->KaryGosc == "") {
$CON .= '<tr class="player rez"'.$styl.'><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td '.$styl.'>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f', (($T->KaryGosp != "" and $T->Stat != "Zawody przerwane") ? $P->sec : $P->first)).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';  
} else {
$CON .= '<tr class="player rez"'.$styl.'><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td '.$styl.'>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f', $P->first).' m</a></td><td class="TdRownaj"><a>'.sprintf('%0.1f', $P->sec).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';  
}
}

}

//END WYNIKI LIVE

}

$CON .= "</table></section><section style='display:none' id='sl3'>";

$TUR = loadTur($T->TurniejId); 
$SkladGosp = json_decode(stripslashes_deep($TUR[0]->Sklad)); 

$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:460px;">'.(($Stadion->Typ == 'Drużynowe') ? 'Drużyna':'Zawodnik').'</td><td style="text-align:center;width:100px">Punkty</td><td style="text-align:center;width:100px;">Strata</td></tr></thead>';

$i=0;
if($SkladGosp != NULL) 
foreach($SkladGosp as $P) { $i++; 
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a>'.$P->punkty.'</a></td><td class="TdRownaj"><a> '.$P->first.'</a></td></tr>';  
}

$CON .= "</table></section><section ".(($T->Stat == "") ? '': "style='display:none'")." id='sl2'>";


$SkladGosc = json_decode(stripslashes_deep($T->SkladGosc)); 
usort($SkladGosc,'compareRowsPoz');

$i=0;
if($Stadion->Typ == "Drużynowe") { 
$SkladGosc = json_decode(stripslashes_deep($T->Judge)); 
if($SkladGosc != NULL) { usort($SkladGosc, "compareRowsPoz");
$CON .= '<table style="width:100%"><thead><tr><td></td><td style="width:20px;">Kraj</td><td>Drużyna</td><td>Zawodnicy</td></tr></thead>';
foreach($SkladGosc as $P) {  $i++;  
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->name.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td>'.$P->zawodnicy.'</td></tr>';
}
}
} else if($Stadion->Typ == "TCS") {

if($SkladGosc != NULL) {

$CON .= '<table style="width:100%;"><tr><td><table style="width:100%"><thead><tr><td></td><td style="width:20px;">Kraj</td><td>Zawodnik</td></tr></thead>';
$Sklad = array_slice($SkladGosc,0,25);
foreach($Sklad as $P) {  $i++;  
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td></td></tr>';
} 

$CON .= '</table></td><td><table style="width:100%"><thead><tr><td></td><td style="width:20px;">Kraj</td><td>Zawodnik</td></tr></thead>';

$Sklad = array_reverse(array_slice($SkladGosc,25));
foreach($Sklad as $P) {  $i++;  
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td></td></tr>';
} 


}
} else {
if($SkladGosc != NULL) {
$CON .= '<table style="width:100%"><thead><tr><td></td><td style="width:20px;">Kraj</td><td>Zawodnik</td></tr></thead>';
foreach($SkladGosc as $P) {  $i++;  
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td></td></tr>';
} 
}
}

$CON .= "</td></tr></table>";


$months = array('01' => 'Styczeń', '02' => 'Luty', '03' => 'Marzec', '04' => 'Kwiecień', '05' => 'Maj', '06' => 'Czerwiec', '07' => 'Lipiec', '08' => 'Sierpień', '09' => 'Wrzesień', '10' => 'Październik', '11' => 'Listopad', '12' => 'Grudzień');
$CON .= "</table></section><section style='display:none' id='sl4'></section><section style='display:none' id='sl5'><h3>".$months[date('m')]."</h3>";

$CON .= '<table style="width:100%"><thead><tr><td style="width:100px;">Data</td><td style="width:40px;">Kraj</td><td style="width:250px;">Miejscowość</td><td style="width:140px">Rozmiar</td><td style="width:100px">Rodzaj</td></tr></thead>';
$IMPREZY = loadImprezy($T->TurniejId);

if($IMPREZY != NULL) { $i=0;
foreach($IMPREZY as $P) {  $i++; 
$ST = json_decode(stripslashes_deep($P->Stadion)); 
$CON .= '<tr class="player rez"><td>'.substr($P->Data,0,10).'</td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->Gosp.'.png', __FILE__ ).'" alt=""></td><td>'.$P->Rozgrywki.'</td><td >'.$ST->Rozmiar.'</td><td>'.$ST->Typ.' </td></tr>'; 
}
}

$CON .= "</table></section><section id='sl6' style='display:none'>";

//WYNIKI PIERWSZEJ SERII 

$SkladSerii = json_decode(stripslashes_deep($T->KaryGosp)); 
if($SkladSerii != NULL) { $SkladSerii = checkDSQ($SkladSerii); usort($SkladSerii, "compareRowsPoz");

if($Stadion->Typ == "Indywidualne") {

$i=0;

$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:500px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Nota</td></tr></thead>';

foreach($SkladSerii as $P) { $i++;         
if($P->poz == '5000') { $P->poz = 'DSQ'; }

$CON .= '<tr '.(($P->odpada == "YES") ? 'style="opacity:0.5" ':'').'class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-align:center"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->first).' m</a></td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->nota).'</a></td></tr>'; 

}

$CON .= "</table>";
}  else if($Stadion->Typ == "TCS") { 

$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:500px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Nota</td></tr></thead>';

$SkladSerii = PorzadkujTCS($SkladSerii); $i=0;
$SkladSerii = checkDSQ($SkladSerii);
foreach($SkladSerii as $P) { $i++;


$CON .= '<tr '.(($i>30) ? 'style="opacity:0.5" ':'').(($i>25 and $i <=30) ? 'style="background:#FBFF8C" ':'').'class="player rez"><td class="pozycja"><b>'.(($P->poz == "5000") ? "DSQ" : $i).'</b></td><td style="text-align:center"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->first).' m</a></td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->nota).'</a></td></tr>';

}

$CON .= '</table>';
 }  
else { 

// DRUZYNOWA PIERWSZA SERIA

$TEAMS = createTeams($SkladSerii);
$JUDGE = getTeamsFromPlayers($SkladSerii);

usort($JUDGE, function($a, $b) use ($TEAMS) {
        $a = array_pop($TEAMS[$a->name])->nota;
        $b = array_pop($TEAMS[$b->name])->nota;
    
    if ($a == $b) {
        $ret = 0;
    }
    $ret = ($a > $b) ? -1 : 1;
    return $ret;
});

$i=0;
foreach($JUDGE as $TEAM) {  $i++;

$CON .= '<br><i>'.$TEAM->name.'</i><table style="width:100%'.(($i>8)?  ';opacity:0.5': '').'"><thead><tr><td>Poz.</td><td>Kraj</td><td style="width:400px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Rezultat</td></tr></thead>';

foreach(array_slice($TEAMS[$TEAM->name],0,count($TEAMS[$TEAM->name])-1)  as $P) { 

if($P->poz == '5000') { $P->poz = 'DSQ'; }

$CON .= '<tr class="player rez"><td class="pozycja"><b>'.(($P->poz == 'DSQ') ? 'DSQ' : $P->poz).'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f',$P->first).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';   
 
} 

$info = array_pop($TEAMS[$TEAM->name]); 
$CON .= '<tfoot><tr><td>Razem</td><td></td><td style="width:300px;"></td><td style="text-align:center"></td><td style="text-align:center">'.sprintf('%0.1f',$info->nota).'</td></tr></tfoot></table>'; 
}

}
}

$CON .= "</section><section id='sl7' style='display:none'>";

//WYNIKI DRUGIEJ SERII 

if($T->Stat == "Zawody przerwane") $CON .= '<br><center>Druga seria nie doszła do skutku</center><br>';

$SkladSerii = json_decode(stripslashes_deep($T->KaryGosc)); 
if($SkladSerii != NULL) { $SkladSerii = checkDSQ($SkladSerii); usort($SkladSerii, "compareRowsPoz");

if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == "TCS") {

$i=0;

$CON .= '<table style="width:100%"><thead><tr><td></td><td>Kraj</td><td style="width:500px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Nota</td></tr></thead>';

foreach($SkladSerii as $P) { $i++;

if($P->poz == '5000') { $P->poz = 'DSQ'; }

$CON .= '<tr '.(($i>30) ? 'style="opacity:0.5" ':'').'class="player rez"><td class="pozycja"><b>'.$P->poz.'</b></td><td style="text-align:center"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->sec).' m</a></td><td class="TdRownaj"><a> '.sprintf('%0.1f',$P->nota).'</a></td></tr>'; 

}

$CON .= "</table>";
} else {

//DRUŻYNOWA DRUGA SERIA

$TEAMS = createTeams($SkladSerii);
$JUDGE = getTeamsFromPlayers($SkladSerii);

usort($JUDGE, function($a, $b) use ($TEAMS) {
        $a = array_pop($TEAMS[$a->name])->nota;
        $b = array_pop($TEAMS[$b->name])->nota;
    
    if ($a == $b) {
        $ret = 0;
    }
    $ret = ($a > $b) ? -1 : 1;
    return $ret;
});

$i=0;
foreach($JUDGE as $TEAM) {  $i++;

$CON .= '<br><i>'.$TEAM->name.'</i><table style="width:100%'.(($i>8)?  ';opacity:0.5': '').'"><thead><tr><td>Poz.</td><td>Kraj</td><td style="width:400px;">Zawodnik</td><td style="text-align:center;">Wynik</td><td style="text-align:center;">Rezultat</td></tr></thead>';

foreach(array_slice($TEAMS[$TEAM->name],0,count($TEAMS[$TEAM->name])-1)  as $P) { 

if($P->poz == '5000') { $P->poz = 'DSQ'; }

$CON .= '<tr class="player rez"><td class="pozycja"><b>'.(($P->poz == 'DSQ') ? 'DSQ' : $P->poz).'</b></td><td style="text-transform:uppercase"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$P->name.'</td><td class="TdRownaj"><a>'.sprintf('%0.1f', $P->sec).' m</a></td><td class="TdRownaj"> <a style="width:40px;">'.sprintf('%0.1f', $P->nota).'</a></td></tr>';   
 
} 

$info = array_pop($TEAMS[$TEAM->name]); 
$CON .= '<tfoot><tr><td>Razem</td><td></td><td style="width:300px;"></td><td style="text-align:center"></td><td style="text-align:center">'.sprintf('%0.1f',$info->nota).'</td></tr></tfoot></table>'; 
}

}
}

$CON .= "</section></div></div></div>";

/*$CON .= "<h2 class='widget-title buts kole'>Skacze:";

$SkladGosc =  json_decode(stripslashes_deep($T->SkladGosc));
usort($SkladGosc, "compareRowsPoz"); $i = 0;
$SkladGosc = array_slice($SkladGosc,0,3);
foreach($SkladGosc as $P) {  $i++;  
if($i == 2) $CON .= ' Następni ';
$CON .= '<a>'.$i.'. '.$P->name.'</a>';
} 

$CON .= "</h2>"; */

}
?>