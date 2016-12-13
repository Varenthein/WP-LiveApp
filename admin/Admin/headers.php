<?
 //if($T->Kategoria != "Skoki narciarskie") {
$CON .= '<section class="relInfo">';

if($Stadion->logo != "") $CON .= '<img class="logo" style="margin:10px;" src="'.$Stadion->logo.'" alt="">';

if($T->Kategoria == "Losowanie") $CON .= '<h3>'.$T->Rozgrywki.'</h3>';
 /*
$DAYS = array('1' => 'poniedziałek','2' => 'wtorek','3' => 'środa','4' => 'czwartek','5' => 'piątek','6' => 'sobota','7' => 'niedziela');
$MONTHS = array('01' => 'styczeń','02' => 'luty','03' => 'marzec','04' => 'kwiecień','05' => 'maj','06' => 'czerwiec','07' => 'lipiec','08' => 'sierpień','09' => 'wrzesień','10' => 'październik','11' => 'listopad','12' => 'grudzień');

$CON .= '<div class="restInfo">'.(($T->Faza != '') ? $T->Faza.' |' : '').' '.substr($T->Data,8,2).' '.$MONTHS[substr($T->Data,5,2)].' | '.$DAYS[date('N', strtotime( $T->Data))].'</h3>';
  */
$CON .= '</section>';
//}
?>