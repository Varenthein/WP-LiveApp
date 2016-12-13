<? 

function compareTwo($a, $b) {
    if ($a->grupa == $b->grupa ) {
        return $a->poz - $b->poz;
    }
    return strcmp($a->grupa, $b->grupa);
}

function compareRowsPoz($a, $b)
{
    if ($a->poz == $b->poz) {
        return 0;
    }
    return ($a->poz > $b->poz) ? 1 : -1;
}

function createGroups($array) {

usort($array, "compareTwo");
$actGRP = "";
$newArray = array();

foreach($array as $A) {
if($A->grupa != $actGRP) {
$actGRP = $A->grupa; 
 }                     
$newArray[$actGRP][] = $A; 
}
return $newArray;
}

$CON .= '<div class="rezerwowi"><section id="sl2">
<table style="width:740px;padding:0px;"><tr>';      

if($Stadion->Typ == "Grupowe")  {                    

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 

$Grupy = json_decode(stripslashes_deep($T->Judge));
$Teams = createGroups($SkladGosp); $i = 0;
if($Grupy != NULL) {  


foreach($Grupy as $G) { $i++;

 if($i == 5) $CON .= "</tr><tr>";
 $CON .= '<td style="width:25%;padding-right:1px"><div style="text-align:center;padding:10px"><b>'.$G->name.'</b></div>';
 $CON .= '<table style="width:100%;"><thead><td style="width:10px;"></td><td>Drużyna</td></thead>';
 
 foreach($Teams[$G->name] as $T) {
 $CON .= '<tr class="player rez"><td style="padding-right:0px;"><img class="flaga" src="'.plugins_url('../img/Flags/'.$T->kraj.'.png', __FILE__ ).'" alt=""></td><td>'.$T->name.'</td></tr>';
 }
 
 $CON .= "</table></td>";
  
}

} 
$CON .= '<tr></table></section></div>';
} else {

//PARY

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 
usort($SkladGosp,"compareRowsPoz");  $i=0;

foreach($SkladGosp as $P) { $i++;

if($i%2 != 0) { 

$CON .= '<tr class="player rez">'; 
$CON .= '<td><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td style="width:350px;padding-right:2px;">'.$P->name.'</td>';

} else {

$CON .= '<td><b>VS</b></td> <td style="width:350px;padding-right:2px;text-align:right">'.$P->name.'</td><td><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td>';
$CON .= '</tr>';

} 

} 

$CON .= '</table></section></div>';

}
?>