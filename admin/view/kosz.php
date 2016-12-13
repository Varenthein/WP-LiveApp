<? 
$CON .= '<div class="rezerwowi" style="width:740px"><section id="sl2">';
$CON .= "<h4>PODSTAWOWY SKŁAD</h4>";

$CON .= '<table style="width:740px;padding:0px;"><tr><td style="width:50%">';                            

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp));

if($SkladGosp != NULL) { foreach($SkladGosp as $P) {  $i++;
if($P->Gole == "not") $P->Gole = 0;
if($P->nr == "") $P->nr = 0;
$CON .= '<div class="player rez">';  
$CON .= '<b class="nr">'.$P->nr.'</b>  '.$P->name.' '.(($P->kartki == 'true') ? '<img src="'.plugins_url( '../img/Captain.png', __FILE__ ).'" alt="" class="Live_pkt">' : '').' '.'<span class="pkt long">'.(($P->Zmiana == '1') ? '<img alt="" src="'.plugins_url( '../img/KoszPkt.png', __FILE__ ).'">' : ' ').$P->Gole.' pkt</span>';
$CON .= '</div>';
}
}

$CON .= '</td><td style="width:50%;padding-left:1px;">';

$SkladGosc = json_decode(stripslashes_deep($T->SkladGosc));

if($SkladGosc != NULL) { foreach($SkladGosc as $P) {  $i++;
if($P->Gole == "not") $P->Gole = 0;
if($P->nr == "") $P->nr = 0;
$CON .= '<div class="player rez">';  
$CON .= '<b class="nr">'.$P->nr.'</b> '.$P->name.' '.(($P->kartki == 'true') ? '<img src="'.plugins_url( '../img/Captain.png', __FILE__ ).'" alt="" class="Live_pkt"> ' : '').' <span class="pkt long">'.(($P->Zmiana == '1') ? '<img alt="" src="'.plugins_url( '../img/KoszPkt.png', __FILE__ ).'">' : ' ').$P->Gole.' pkt</span>';
$CON .= '</div>';
}
}

$CON .= '</td></tr></table>
</section>';

$CON .= '<section id="sl3"><h4>Trenerzy</h4>
<table style="width:740px;padding:0px;"><tr><td style="width:50%"><table style="width:100%"><tr class="player rez"><td>'.(($T->TrenerGosp == "") ?  'brak danych' : $T->TrenerGosp).'</td></tr></table><td style="width:50%;padding-left:1px;"><table style="width:100%"><tr class="player rez"><td>'.(($T->TrenerGosc == "") ?  'brak danych' : $T->TrenerGosc).'</td></tr></table><br><br>';                             


$CON .= '</td></tr></table>
</section></div>';
?>