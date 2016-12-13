<?php
//error_reporting(0);

  function orderByCat($a, $b) {
    if ($a->Kategoria == $b->Kategoria) {
        return 0;
    }
    return ($a->Kategoria > $b->Kategoria) ? 1 : -1;
  }
  function orderByData($a, $b) {
    return strtotime($a->Data)<strtotime($b->Data);
  }
  
  function splitCat($array) {
  usort($array,"orderByCat");
  
  $ar='';
  $LIVE = array();
  foreach($array as $A) {
  
  if($A->Kategoria != $ar) { if(is_array($LIVE[$ar])) { usort($LIVE[$ar],"orderByData"); } $ar = $A->Kategoria;  }
  $LIVE[$ar][] = $A;
  
  }
  
  if(is_array($LIVE[$ar])) { usort($LIVE[$ar],"orderByData"); }
  
  return $LIVE;
  }
     
     
     
function my_plugin_query_parser( $q ) {

$the_page_name = get_option( "my_plugin_page_name" );
$the_page_id = get_option( 'my_plugin_page_id' );

$qv = $q->query_vars;

// have we NOT used permalinks...?
if( !$q->did_permalink AND ( isset( $q->query_vars['page_id'] ) ) AND ( intval($q->query_vars['page_id']) == $the_page_id ) ) {
$q->set('my_plugin_page_is_called', TRUE );
return $q;

}
elseif( isset( $q->query_vars['pagename'] ) AND ( ($q->query_vars['pagename'] == $the_page_name) OR ($_pos_found = strpos($q->query_vars['pagename'],$the_page_name.'/') === 0) ) ) {
$q->set('my_plugin_page_is_called', TRUE );
return $q;

}
else {
$q->set('my_plugin_page_is_called', FALSE );
return $q;

}

}
add_filter( 'parse_query', 'my_plugin_query_parser' );

function my_plugin_page_filter( $posts ) {

global $wp_query;

if( $wp_query->get('my_plugin_page_is_called') ) {      
if(isset($_GET['MeczId'])) {
 $T = getMecz($_GET['MeczId']);
 if(count($T) > 0) {
  include_once('lang.php');
 if(empty($LANG[$T->Kategoria])) { $L = (object) $LANG['default']; $LSTYL = "default"; } else { $L = (object) $LANG[$T->Kategoria];  }
 
$posts[0]->title_title = $T->Gosp.' vs '.$T->Gosc;
$posts[0]->post_content = '<meta http-equiv="Refresh" content="60">';
$CON = "<div class='mecz ".$TGole->Kategoria."'>";
$LEN = strlen($T->PktGosp.$T->PktGosc);
$Stadion = json_decode(stripslashes_deep($T->Stadion));

if($T->Kategoria == "Tenis") {

    $T->GospImg = '../wp-content/plugins/LiveApp/admin/img/Flags/'.$T->GospImg.'.png';                                                                     
    $T->GoscImg = '../wp-content/plugins/LiveApp/admin/img/Flags/'.$T->GoscImg.'.png';
     
}
else {

 if($T->GospImg == "") $T->GospImg = '../wp-content/plugins/LiveApp/admin/img/Flags/'.$T->Gosp.'.png';
     if($T->GoscImg == "") $T->GoscImg = '../wp-content/plugins/LiveApp/admin/img/Flags/'.$T->Gosc.'.png';
     
}

require_once('Admin/headers.php');


if(in_array($T->Kategoria,array("Siatkówka","Koszykówka","Tenis","Piłka ręczna", "Piłka nożna")) or ($LSTYL == "default" and $T->Gosc != "")) {
if($T->Stat != "" and $T->Stat != "trwa") { $T->Min = $T->Stat; } else { if(in_array($T->Kategoria,array("Siatkówka","Koszykówka","Tenis"))) $T->Min = $Stadion->sset; else $T->Min = $T->Min.'\''; }
$CON .= '<header><div class="herb"><img src="'.$T->GospImg.'" alt="'.$T->Gosp.'"></div><div class="team gosp">'.$T->Gosp.'</div><div class="goal"><span>'.$T->Min.'</span><div '.(($LEN > 5) ? 'style="font-size:21pt;padding-top:4px;" ' : '').' class="wyn"> '.$T->PktGosp.' : '.$T->PktGosc.'';

$CON .= '</div>';

$pieces = explode(',',$T->PodGol); $i=count($pieces);
foreach(array_reverse($pieces) as $SET) { $SETY .= '<span><b>'.$L->SetLabel.' '.$i.'</b> '.$SET.'</span>'; $i--; } 
if(in_array($T->Kategoria,array('Siatkówka','Koszykówka'))) { //$CON .= '<div style="width:100px;" class="podGol"><div class="sety" style="height:18px;">'.$SETY.'</div><a onClick="(jQuery(\'.sety\').css(\'height\') == \'18px\') ? jQuery(\'.sety\').animate({ \'height\':  \'100%\'}, \'slow\') : jQuery(\'.sety\').animate({ \'height\':  \'18px\'})">Rozwiń</a></div>'; 
if($T->PodGol == "") $T->PodGol = '0:0';
$pieces = explode(',',$T->PodGol);  $i=0;
foreach($pieces as $S) { $i++;
$P = explode(':',$S);
//if($P[0] > $P[1]) $P[0] = '<b>'.$P[0].'</b>'; else $P[1] = '<b>'.$P[1].'</b>';  
$PodGol .= '<span class="set"><i>'.$i.' '.$L->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>';
}
$CON .= '<div class="podGol sety"><div class="sets">'.$PodGol.'</div></div>';
} else if($T->Kategoria == 'Tenis' or ($LSTYL == "default" and $T->Gosc == "") or $T->Kategoria == "Losowanie") {

if($T->PodGol == "") $T->PodGol = '0:0';
$pieces = explode(',',$T->PodGol);  $i=0;
foreach($pieces as $S) { $i++;
$P = explode(':',$S);
//if($P[0] > $P[1]) $P[0] = '<b>'.$P[0].'</b>'; else $P[1] = '<b>'.$P[1].'</b>';  
$PodGol .= '<span class="'.(($i == 1 and $T->Status == 1) ? 'actualSet ' : '').'set"><i>'.$i.' '.$L->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>';
}
$CON .= '<div class="podGol sety"><div class="sets">'.$PodGol.'</div></div>';

} 
else $CON .= '<div class="podGol">'.$T->PodGol.'</div>';
$CON .= '</div><div class="team">'.$T->Gosc.'</div><div class="herb"><img src="'.$T->GoscImg.'" alt="'.$T->Gosc.'"></div></header>';
}
if($T->Kategoria == "Losowanie") {
$CON .= '<header></header>'; 
}
if(in_array($T->Kategoria,array("Skoki narciarskie","Kolarstwo","Biegi narciarskie", "Biathlon")) or ($LSTYL == "default" and $T->Gosc == "")) {
$TURO = loadTur($T->Turniej);
$T->TurniejId = $T->Turniej;
if($TURO[0]->Nazwa == "") $T->Turniej = ''; else $T->Turniej = $TURO[0]->Nazwa;  
if($T->Stat != "" and $T->Stat != "trwa") { $T->Min = $T->Stat; } else { if(in_array($T->Kategoria,array("Siatkówka","Koszykówka","Tenis"))) $T->Min = $Stadion->sset; else $T->Min = $T->Min.'\''; }
$CON .= '<header>';
if($T->Kategoria != "Inne") $CON .= '<div class="herb"><img src="'.$T->GospImg.'" alt="'.$T->Gosp.'"></div>';
$CON .= '<div class="team gosp" style="width:600px;padding-top:30px;text-align:left">'.(($T->Turniej != "") ? $T->Turniej.':' : '' ).' '.$T->Rozgrywki.' '.(($Stadion->Typ == "Drużynowy") ? '(Drużynowy)' : '').'</div></header>'; 
}

if($Stadion->name == "") $Stadion->name = "nieznany";
$CON .= '<div class="Live-data">'.$DAYS[date('N', strtotime( $T->Data))].' '.substr($T->Data,8,2).'.'.substr($T->Data,5,2).'.'.substr($T->Data,0,4).', '.substr($T->Data,11,5).' '.(($Stadion->name != "") ? '&bull; '.$Stadion->name.(($Stadion->city != "") ? ', '.$Stadion->city : '' ) : '').' &bull; '.$T->Rozgrywki.'</div>';



if(in_array($T->Kategoria,array('Piłka nożna'))) {
$CON .= '<table style="vertical-align:top"><tr><td><div id="boisko" style="background:url(\''.plugins_url( 'img/'.$T->Kategoria.'.png', __FILE__ ).'\')">';
$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp));
if($SkladGosp != NULL) foreach($SkladGosp as $P) { 

$CON .= '<div class="'.$T->GospKolor.'shirt player'.(($P->Zmiana != 'not') ? ' zmiana' : '').(($P->kartki != 'not') ? ' '.str_replace(' ','-',$P->kartki) : '').'" style="position:absolute;top:'.$P->top.';left:'.$P->left.'">'.(($P->kartki != 'not') ? ' <div class="kartka"><img class="flaga" src="'.plugins_url( 'img/'.$P->kartki.'.png', __FILE__ ).'" alt="kartka"></div>' : '').'<span class="nr">'.$P->nr.'</span>'.$P->name.' ';
$CON .= '</div>';
}
$SkladGosc = json_decode(stripslashes_deep($T->SkladGosc));
if($SkladGosc != NULL) foreach($SkladGosc as $P) { 
$CON .= '<div class="'.$T->GoscKolor.'shirt player'.(($P->Zmiana != 'not') ? ' zmiana' : '').(($P->kartki != 'not') ? ' '.str_replace(' ','-',$P->kartki) : '').'" style="position:absolute;top:'.$P->top.';left:'.$P->left.'">'.(($P->kartki != 'not') ? ' <div class="kartka"><img class="flaga" src="'.plugins_url( 'img/'.$P->kartki.'.png', __FILE__ ).'" alt="kartka"></div>' : '').'<span class="nr">'.$P->nr.'</span>'.$P->name.' ';
$CON .= '</div>';

}
$CON .= "</div></div>";
$CON .= "</td><td class='rezerwowi'><h2 class='widget-title buts'><a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl1\").delay(100).css(\"display\",\"block\"); '>Rezerwowi</a>".(($T->Kategoria != 'Coś') ? "<a onClick='jQuery(\".slides section\").css(\"display\",\"none\");jQuery(\".slides #sl2\").delay(100).css(\"display\",\"block\");'>Statystyki</a>" : '')."</h2><div class='slides'><section  style='display:none' id='sl1'><h3>".$T->Gosp." <span>Trener: ".(($T->GospTrener != "") ? $T->GospTrener : 'Brak informacji')."</span></h3>";

$SkladGosp = json_decode(stripslashes_deep($T->RezGosp)); $i=0;

$CON .= '<table style="width:100%"><tr><td style="Width:50%">';

if($SkladGosp != NULL) foreach($SkladGosp as $P) {  $i++;
if($i == 8) { $CON .= '</td><td style="Width:50%">'; }
$CON .= '<div class="player rez '.$T->GospKolor.'shirt player'.(($P->Zmiana != 'not') ? ' zmiana' : '').(($P->kartki != 'not') ? ' '.$P->kartki : '').'" ><span class="nr">'.$P->nr.'</span> '.$P->name.(($P->Zmiana != 'not' and $T->Kategoria == 'Piłka nożna') ? ' <img class="flaga" style="top:7px;" src="'.plugins_url( 'img/Zmiana.png', __FILE__ ).'" alt="zmiana">' : '').' ';  
$CON .= '</div>';
}
for($j=$i;$j<14;$j++) { if($j == 7) { $CON .= '</td><td style="Width:50%">'; } $CON.='<div class="player rez"></div>'; }

$CON .= '</td></tr></table>';

$CON .= '<h3 style="margin-top:5px;">'.$T->Gosc.' <span>Trener: '.(($T->GoscTrener != "") ? $T->GoscTrener : 'Brak informacji').'</span></h3>';

$SkladGosc = json_decode(stripslashes_deep($T->RezGosc)); $i=0;

$CON .= '<table style="width:100%"><tr><td style="Width:50%">';
if($SkladGosc != NULL) foreach($SkladGosc as $P) {  $i++;
if($i == 8) { $CON .= '</td><td style="Width:50%">'; }
$CON .= '<div class="player rez '.$T->GoscKolor.'shirt player'.(($P->Zmiana != 'not') ? ' zmiana' : '').(($P->kartki != 'not') ? ' '.$P->kartki : '').'" ><span class="nr">'.$P->nr.'</span> '.$P->name.(($P->Zmiana != 'not' and $T->Kategoria == 'Piłka nożna') ? ' <img class="flaga" style="top:7px;" src="'.plugins_url( 'img/Zmiana.png', __FILE__ ).'" alt="zmiana">' : '').' ';  
$CON .= '</div>';
}
for($j=$i;$j<14;$j++) { if($j == 7) { $CON .= '</td><td style="Width:50%">'; } $CON.='<div class="player rez"></div>'; }

$CON .= '</td></tr></table>';
$CON .= "</section><section id='sl2'>";

if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna','Koszykówka'))) {
$CON .= "<table style='width:100%;'><tr><td style='width:50%'><h3>".$T->Gosp."</h3></td><td style='width:50%;padding-left:2px;text-align:right'><h3>".$T->Gosc."</h3></td></tr></table><table style='width:100%;'><tr><td colspan='2' style='text-align:center;padding:5px;'><b>".$L->Pkty."</b></td></tr><tr><td style='width:50%'><p></p>";

if(in_array($T->Kategoria, array('Siatkówka','Piłka ręczna','Koszykówka'))) {

$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 
$SkladGosc = json_decode(stripslashes_deep($T->SkladGosc)); 
$KOL = (count($SkladGosp) < count($SkladGosc)) ? count($SkladGosc) : count($SkladGosp); $j=0;
if($SkladGosp != NULL) { 
function compareRows($a, $b)
{
if($a->Gole == 'not') $a->Gole = 0;
if($b->Gole == 'not') $b->Gole = 0;
    if ($a->Gole == $b->Gole) {
        return 0;
    }
    return ($a->Gole < $b->Gole) ? 1 : -1;
}
usort($SkladGosp, "compareRows");
$SkladGosp = array_slice($SkladGosp,0,5);
foreach($SkladGosp as $G) {  $j++;
if($G->Gole === "not") $G->Gole = 0;
$CON .= '<div class="player rez"><span class="name">'.$j.'. '.$G->name.'</span> <span class="pkt">'.$G->Gole.' pkt</span></div>';
} 
} else {$CON .= "<div class='player rez'>Brak</div>"; $j=1; }
$CON .= "<br></td><td style='width:50%;padding-left:2px;'>";

if($SkladGosc != NULL) { 
usort($SkladGosc, "compareRows");
$SkladGosc = array_slice($SkladGosc,0,5);
$j=0;
foreach($SkladGosc as $G) {  $j++;
if($G->Gole === "not") $G->Gole = 0;
$CON .= '<div class="player rez"><span class="name">'.$j.'. '.$G->name.'</span>  <span class="pkt">'.$G->Gole.' pkt</span></div>';
} 
} else { $CON .= "<div class='player rez'>Brak</div>"; $j=1;  }

} else {

$PktGosp = json_decode(stripslashes_deep('['.$T->StGosp.']')); 
$PktGosc = json_decode(stripslashes_deep('['.$T->StGosc.']')); 
$KOL = (count($PktGosp) < count($PktGosc)) ? count($PktGosc) : count($PktGosp); $j=0;
if($PktGosp != NULL) { $CON .= '<p></p>'; foreach($PktGosp as $G) {  $j++;
$CON .= '<div class="player rez"><img class="Live_kartka" src="'.plugins_url( 'img/'.$G->rodzaj.'.png', __FILE__ ).'" alt="gol"> '.$G->min.'\' '.$G->strzelec.'</div>';
} 
} else {$CON .= "<p></p><div class='player rez'>Brak</div>"; $j=1; }
for($i=$j;$i<$KOL;$i++) $CON .= '<div class="player rez"></div>';                                                                                                         
$CON .= "<br></td><td style='width:50%;padding-left:2px;'>";

$j=0;
if($PktGosc != NULL) { foreach($PktGosc as $G) {  $j++;
$CON .= '<div class="player rez"><img class="Live_kartka" src="'.plugins_url( 'img/'.$G->rodzaj.'.png', __FILE__ ).'" alt="gol"> '.$G->min.'\' '.$G->strzelec.'</div>';
} 
} else { $CON .= "<div class='player rez'>Brak</div>"; $j=1;  }
for($i=$j;$i<$KOL;$i++) $CON .= '<div class="player rez"></div>';
}
$CON .= "</td></tr></table>";
}

$CON .= "<table style='width:100%'><tr><td colspan='2' style='text-align:center;padding:5px;'><b>".$L->Kartki."</b></td></tr><tr><td style='width:50%'>";

$KaryGosp = json_decode(stripslashes_deep('['.$T->KaryGosp.']')); $j=0;
$KaryGosc = json_decode(stripslashes_deep('['.$T->KaryGosc.']'));
$KOL = (count($KaryGosp) < count($KaryGosc)) ? count($KaryGosc) : count($KaryGosp); 
if($KaryGosp != NULL) { foreach($KaryGosp as $G) { $j++;
$pieces = explode(".", $G->ukarany);
if(isset($pieces[1])) $name = $pieces[1]; else $name = $pieces[0];
$CON .= '<div class="player rez"><img class="Live_kartka" src="'.plugins_url( 'img/'.$G->kara.'.png', __FILE__ ).'" alt="kara">'.$G->min.'\' '.$name.'</div>';
}
} else {$CON .= "<div class='player rez'>Brak</div>"; $j=1; }
for($i=$j;$i<$KOL;$i++) $CON .= '<div class="player rez"></div>';

$CON .= "<br></td><td style='width:50%;padding-left:2px;'>";

$j=0;
if($KaryGosc != NULL) { foreach($KaryGosc as $G) {   $j++;
$pieces = explode(".", $G->ukarany);
if(isset($pieces[1])) $name = $pieces[1]; else $name = $pieces[0];
$CON .= '<div class="player rez"><img class="Live_kartka" src="'.plugins_url( 'img/'.$G->kara.'.png', __FILE__ ).'" alt="kara">'.$G->min.'\' '.$name.'</div>';
} 
} else {$CON .= "<div class='player rez'>Brak</div>";  $j=1; }
for($i=$j;$i<$KOL;$i++) $CON .= '<div class="player rez"></div>';

$CON .= "</td></tr></table></section>";
$CON .= "</td></table>";
}

if(in_array($T->Kategoria,array('Skoki narciarskie',"Biegi narciarskie","Biathlon")))  {

require_once('view/skoki.php');

}

if(in_array($T->Kategoria,array('Koszykówka')))  {

require_once('view/kosz.php');

}

if(in_array($T->Kategoria,array('Losowanie')))  {

require_once('view/losowanie.php');

}

if(in_array($T->Kategoria,array('Inne')))  {

require_once('view/inne.php');

}

if(in_array($T->Kategoria,array('Multirelacja')))  {

require_once('view/multirelacja.php');

}

if(in_array($T->Kategoria,array('Siatkówka')))  {

require_once('view/siatka.php');

}

if(in_array($T->Kategoria,array('Piłka ręczna')))  {

require_once('view/reczna.php');

}


if(in_array($T->Kategoria,array('Kolarstwo')))  {

require_once('kolarstwo.php');

}

$CON .= "<div class=\"LiveApp-share\">
<h3>Podziel się:</h3> [cresta-social-share]
</div>
[smallheader title='Minuta po minucie']<div class='wpisy'>";
  $KWESTIE = LoadWpisy($_GET['MeczId']);     
  if(count($KWESTIE) > 0) {
  foreach($KWESTIE as $K) {

  if($K->Min == "") $K->Min = 0;
  $CON .= '<div class="wpis '.str_replace(' ','-',$K->Rodzaj).'">';            
  if($T->Kategoria != 'Skoki narciarskie' and $T->Kategoria != "Losowanie" and $K->Min_display != "NULL") { $CON .= '<b class="min">'.(($K->Min_display != "") ? $K->Min_display : $K->Min.'\'').'</b>'; }
  if($K->Rodzaj != 'normal' and $K->Rodzaj != "Gosp" and $K->Rodzaj!= 'Gosc' and $K->Rodzaj!= 'GoscSet' and $K->Rodzaj!= 'GospSet' ) $CON .= '<img class="Live_Icon" src="'.plugins_url( 'img/'.$K->Rodzaj.'.png', __FILE__ ).'" alt=""> '; 
  if($K->Rodzaj == "Gosp" or $K->Rodzaj == "GospSet" or $K->Rodzaj == "SetDlaGosp") $CON .= '<img class="rounded Live_Icon" src="'.$T->GospImg.'" alt=""> '; 
  if($K->Rodzaj == "Gosc" or $K->Rodzaj == "GoscSet" or $K->Rodzaj == "SetDlaGosc" ) $CON .= '<img class="rounded Live_Icon" src="'.$T->GoscImg.'" alt=""> '; 
  if($K->Rodzaj == "GemDlaGosp") $CON .= '<img class="rounded Live_Icon" src="'.$T->GospImg.'" alt=""> '; 
 if($K->Rodzaj == "GemDlaGosc") $CON .= '<img class="rounded Live_Icon" src="'.$T->GoscImg.'" alt=""> ';      
  $CON .= stripslashes_deep($K->Text) .'</div>';
  }   
  } else $CON .= "Brak wpisów";
$CON .=  '</div></div>';
$posts[0]->post_content .= $CON;
} else {
$posts[0]->post_title = 'Brak relacji';
$posts[0]->post_content = '[header title="Brak relacji"]';
}
} else {
$posts[0]->post_title = 'Relacje Live';
$posts[0]->post_content = '<div class="wp_posts" style="text-align:center">';
 if(!$_GET['Apage']) $page=1; else $page = $_GET['Apage'];
  $ILE = 20;
  $OD = ($page-1)*$ILE;
  $MECZE = LoadData($OD, $ILE,'');
  
  if(count($MECZE) > 0) {
  
  
  $MECZE = splitCat($MECZE);
  
  foreach($MECZE as $S) {
  
  $posts[0]->post_content .=  '<h3 class="Kat">'.ucwords($S[0]->Kategoria).'</h3>';
  
  foreach($S as $M) {
  
    if($M->Kategoria == "Tenis") {
  
       $M->GospImg = plugins_url( 'img/Flags/'.$M->GospImg.'.png', __FILE__ );
       $M->GoscImg = plugins_url( 'img/Flags/'.$M->GoscImg.'.png', __FILE__ );
     
    } else {
   
    if($M->GospImg == "") {
       $M->GospImg = plugins_url( 'img/Flags/'.$M->Gosp.'.png', __FILE__ );
     }
     if($M->GoscImg == "") {
       $M->GoscImg = plugins_url( 'img/Flags/'.$M->Gosc.'.png', __FILE__ );
     }
     
   }  
  
  $TURNIEJ = loadTur($M->Turniej);
  $M->Turniej = $TURNIEJ[0]->Nazwa; 
   $posts[0]->post_content .= '<a class="small list mecz" href="BC/relacje-live/?MeczId='.$M->ID.'">'; 
  //$posts[0]->post_content .= '<label>'.$M->Kategoria.'</label>'.(($M->Rozgrywki != "") ? '<label>'.$M->Rozgrywki.'</label>' : '').'<a href="?MeczId='.$M->ID.'"><span>'.substr($M->Data,0,10).'</span><span class="team">'.$M->Gosp.'</span>  '.$M->PktGosp.' : '.$M->PktGosc.'<span class="team">'.$M->Gosc.'</span></a>';
   if(in_array($M->Kategoria,array('Piłka nożna', 'Siatkówka', 'Piłka ręczna', 'Koszykówka', 'Żużel', 'Tenis'))) {
   
    $posts[0]->post_content .=  '<table class="MiniMecz"><tr><td class="herb"><img src="'.$M->GospImg.'" alt="Gosp"></td><td class="team" style="text-align:right">'.$M->Gosp.'</td><td class="wynik"><div>'.$M->PktGosp.':'.$M->PktGosc.'</div></td><td  class="team">'.$M->Gosc.'</td><td class="herb"><img  src="'.$M->GoscImg.'" alt="Gość"></td></tr></table>';    
       
   }
   else if(in_array($M->Kategoria,array('Losowanie','Multirelacja'))) {
   
    $posts[0]->post_content .=  '<table class="MiniMecz"><tr><td style="padding-left:10px;">'.$M->Rozgrywki.'</td></tr></table>';    
    
   }
   else {
   
    $posts[0]->post_content .=  '<table class="MiniMecz"><tr><td class="herb"><img src="'.$M->GospImg.'" alt="Gosp"></td><td style="padding-left:10px;width:600px">'.$M->Rozgrywki.'</td></tr></table>';    
    
   }
  
   $Stadion = json_decode(stripslashes_deep($M->Stadion));

$DAYS = array('1' => 'poniedziałek','2' => 'wtorek','3' => 'środa','4' => 'czwartek','5' => 'piątek','6' => 'sobota','7' => 'niedziela');
$MONTHS = array('01' => 'styczeń','02' => 'luty','03' => 'marzec','04' => 'kwiecień','05' => 'maj','06' => 'czerwiec','07' => 'lipiec','08' => 'sierpień','09' => 'wrzesień','10' => 'październik','11' => 'listopad','12' => 'grudzień');

if($Stadion->name == "") $Stadion->name = "nieznany";
$posts[0]->post_content .= '<div class="Live-data">';

$timestamp = $M->Data;

$today = new DateTime(); // This object represents current date/time
$today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

$match_date = DateTime::createFromFormat( "Y-m-d H:i:s", $timestamp );
$match_date->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

$diff = $today->diff( $match_date );
$diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

switch( $diffDays ) {
    case 0:
        $posts[0]->post_content .=  "dzisiaj";
        break;
    case -1:
        $posts[0]->post_content .=  "wczoraj";
        break;
    case +1:
        $posts[0]->post_content .=  "jutro";
        break;
    default:
        $posts[0]->post_content .= $DAYS[date('N', strtotime( $M->Data))].', '.substr($M->Data,8,2).'.'.substr($M->Data,5,2).'.'.substr($M->Data,0,4); 
}

$posts[0]->post_content .= ', '.substr($M->Data,11,5).' '.(($Stadion->name != "") ? '&bull; '.$Stadion->name.(($Stadion->city != "") ? ', '.$Stadion->city : '' ) : '').' &bull; '.$M->Rozgrywki.'</div>';


    $posts[0]->post_content .= '</a>';
   } 
   }
   $posts[0]->post_content .= '</div>';
   
  } else $posts[0]->post_content .= "<br><br>Brak spotkań"; 
  $posts[0]->post_content .= "</div>";
  ?>
  
<?php $count = numData(); 
$Apage = 0;
if((($count-$ILE)/$ILE) > 0)  {
while(($count/$ILE) > 0) { $Apage++; $count = $count - $ILE;$posts[0]->post_content .= ' <a class="button'.(($Apage == $page) ? '-primary' : '').'" href="?page=LIVEAPP&Apage='.$Apage.'.html">'.$Apage.'</a>';  }
}

}
}

return $posts;

}
add_filter( 'the_posts', 'my_plugin_page_filter' );
?>