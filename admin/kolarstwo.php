<?php 
function compareRowsPoz($a, $b)
{
    if ($a->poz == $b->poz) {
        return 0;
    }
    return ($a->poz > $b->poz) ? 1 : -1;
}
function compareTwo($a, $b) {
    if ($a->kraj == $b->kraj) {
        return $a->poz - $b->poz;
    }
    return strcmp($a->kraj, $b->kraj);
}
$CON .= "<div class='rezerwowi' style='width:100%;'><h2 class='widget-title buts'>";

if($T->Turniej != "brak" and $T->Turniej != "") $CON .= "<a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl1\").delay(100).css(\"display\",\"block\"); '>Klasyfikacja</a><a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl3\").delay(100).css(\"display\",\"block\");'>Klasyfikacja generalna</a>";
else $CON .= "<a>Klasyfikacja</a>";

$CON .= "</h2><div style='width:100%;max-height:480px;overflow:auto;'><div class='slides'><section id='sl1'>";

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 

if($Stadion->Typ != 'Drużynowe') { $CON .= '</table><i>'.$P->kraj.'</i><table style="width:100%"><thead><tr><td>Poz.</td><td>Kraj</td><td style="width:300px;">Imię i nazwisko</td><td>Drużyna</td><td>Czas</td></tr></thead>'; } else {
$FIRST = 0;
$SEC = 0;
$NOTA = 0;
}

if($SkladGosp != NULL) { 
usort($SkladGosp, "compareRowsPoz"); 
function compareRows($a, $b)
{
    if ($a->kraj == $b->kraj) {
        return 0;
    }
    return ($a->kraj < $b->kraj) ? 1 : -1;
}
if($Stadion->Typ == 'Drużynowe') usort($SkladGosp, "compareTwo"); $i=0;
foreach($SkladGosp as $P) {  $i++;  
if($Stadion->Typ == 'Drużynowe' and $i==5) { $i=1; $FIRST = 0; $SEC = 0; $NOTA =0; }
$FIRST += $P->first;
$SEC += $P->sec;
$NOTA += $P->nota; 
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$i.'</b></td><td style="text-transform:uppercase">'.substr($P->kraj,0,3).'</td><td>'.$P->name.'</td><td class="TdRownaj">'.$P->team.' </td><td class="TdRownaj">'.$P->czas.'</td></tr>';  
if($Stadion->Typ == 'Drużynowe' and $i==4) { $CON .= '<tfoot><tr><td>Razem</td><td></td><td style="width:300px;"></td><td>'.$FIRST.'m</td><td>'.$SEC.'m</td><td>'.$NOTA.'</td></tr></tfoot>';  }
}
}

$CON .= "</table></section><section style='display:none' id='sl3'>";

$TUR = loadTur($T->Turniej); 
$SkladGosp = json_decode(stripslashes_deep($TUR[0]->Sklad)); 

$CON .= '<table style="width:100%"><thead><tr><td>Poz.</td><td>Kraj</td><td style="width:460px;">Imię i nazwisko</td><td>Starty</td><td>Pkt</td></tr></thead>';

$i=0;
if($SkladGosp != NULL) foreach($SkladGosp as $P) { $i++; 
$CON .= '<tr class="player rez"><td class="pozycja"><b>'.$i.'</b></td><td style="text-transform:uppercase">'.substr($P->kraj,0,3).'</td><td>'.$P->name.'</td><td>'.$P->first.'</td><td> '.$P->punkty.'</td></tr>';  
}

$CON .= "</table></section></div></div></div>";

/*$CON .= "<h2 class='widget-title buts kole'>Skacze:";

$SkladGosc =  json_decode(stripslashes_deep($T->SkladGosc));
usort($SkladGosc, "compareRowsPoz"); $i = 0;
$SkladGosc = array_slice($SkladGosc,0,3);
foreach($SkladGosc as $P) {  $i++;  
if($i == 2) $CON .= ' Następni ';
$CON .= '<a>'.$i.'. '.$P->name.'</a>';
} 

$CON .= "</h2>"; */
?>