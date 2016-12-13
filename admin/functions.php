<?php


function loadData($OD,$DO,$H=0)	{

global $wpdb;
                               
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
if($H == "0") { $res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `status` > 0 AND  (`data` > DATE_SUB(now(), INTERVAL 2 DAY)) ORDER BY `Data` DESC LIMIT ".intval($OD).", ".intval($DO).""); 
 }
else if($H == "all") { $res = $wpdb->get_results("SELECT * FROM $RELACJE ORDER BY `data` DESC LIMIT ".intval($OD).", ".intval($DO).""); }  
else if($H != "0") {
 $res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `Data`  >= CURDATE() - INTERVAL 1 DAY AND `status` > 0 ORDER BY `data` DESC LIMIT ".intval($OD).", ".intval($DO).""); }
else { $res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `status` = 1 ORDER BY `Data` DESC LIMIT ".intval($OD).", ".intval($DO)."");  }

$DATA = array();
foreach ($res as $rs) 
{
			 $DATA[] = $rs;
       //print $rs->Data.'<br>';
}
		return $DATA;
}

function loadImprezy($TYP)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `Turniej` = '".intval($TYP)."' ORDER BY `Data` DESC");
//exit( var_dump( $wpdb->last_query ) );  
$DATA = array();
foreach ($res as $rs) 
{
			 $DATA[] = $rs;
}
		return $DATA;
}		
  
function loadTurnieje($OD,$DO,$CAT = "")	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Turnieje"; 
if($CAT == "") {
if($DO == '0') $res = $wpdb->get_results("SELECT * FROM $RELACJE ORDER BY `Data` DESC");
else $res = $wpdb->get_results("SELECT * FROM $RELACJE ORDER BY `Data` DESC LIMIT ".intval($OD).", ".intval($DO)."");
} else {
 $res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `Kategoria` = '".$CAT."' ORDER BY `Data` DESC");
}
$DATA = array();
foreach ($res as $rs) 
{
			 $DATA[] = $rs;
}
		return $DATA;
}	


  
function loadTur($ID)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Turnieje"; 
$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($ID)."'");
		return $res;
}	

function numData()	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$wpdb->get_results("SELECT `ID` FROM $RELACJE");
		return $wpdb->num_rows;
}

function loadWpisy($ID)	{

global $wpdb;
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$res = $wpdb->get_results("SELECT * FROM $KWESTIE WHERE `RelID` = '".intval($ID)."' ORDER BY `Min`*1 DESC, `Data` DESC");
$DATA = array();
foreach ($res as $rs) 
{
			 $DATA[] = $rs;
}
		return $DATA;
}


function getMecz($ID)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($ID)."'");
		return $res[0];
}

function loadKluby($CO)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$res = $wpdb->get_results("SELECT DISTINCT `".htmlspecialchars($CO)."` FROM $RELACJE");
$DATA = array();
foreach ($res as $rs) 
{
			 $DATA[] = $rs;
}
		return $DATA;
}

function deleteData($ID) {

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$wpdb->query('DELETE FROM '.$RELACJE.' WHERE ID = '.intval($ID).' LIMIT 1');
$wpdb->query('DELETE FROM '.$KWESTIE.' WHERE RelID = '.intval($ID).' LIMIT 1');
}

function deleteWpis($ID) {

global $wpdb;
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$wpdb->query('DELETE FROM '.$KWESTIE.' WHERE ID = '.intval($ID).' LIMIT 1');
}


function deleteMecze($jak) {

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

if($jak == "All") $wpdb->query('DELETE FROM '.$RELACJE);
else if($jak == "Zakonczone") $wpdb->query('DELETE FROM '.$RELACJE.' WHERE `Status` = 0 AND `Data` < "'.date('Y-m-d H:i:s').'"');
}


function deleteTur($ID) {

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Turnieje"; 
$wpdb->query('DELETE FROM '.$RELACJE.' WHERE `ID` = "'.intval($ID).'"');
}

function wlaczSpotkanie($ID)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$wpdb->update($RELACJE, 
		array( 
			'Status' => 1
		),
		array(
			'ID' => intval($ID)
		));
}
function naZywo($ID, $Status)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$wpdb->update($RELACJE, 
		array( 
			'Status' => intval($Status)
		),
		array(
			'ID' => intval($ID)
		));
}

function changeStatus($ID, $STATUS)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

if($STATUS == "Zawody przerwane") {

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{

$Stadion = json_decode(stripslashes_deep($rs->Stadion));



if($rs->KaryGosp == "") {
$STATUS = "Odwołane";
}
else {

if($Stadion->Typ == "Drużynowe") {
$JUDGE = json_decode(stripslashes_deep($rs->Judge));
$TEAMS = array();

foreach($JUDGE as $T) {
$TEAMS[] = (object) array('name' => $T->name, 'nota' => '', 'poz' => $T->poz, 'zawodnicy' => $T->zawodnicy);
}
$teams = json_encode($TEAMS,JSON_UNESCAPED_UNICODE);
$wpdb->update($RELACJE, 
		array( 
			'KaryGosc' => "",
      'SkladGosp' => $teams,
		),
		array(
			'ID' => intval($ID)
		));
} else {
$wpdb->update($RELACJE, 
		array( 
			'KaryGosc' => "",
      'SkladGosp' => $rs->KaryGosp,
		),
		array(
			'ID' => intval($ID)
		));
}
}
}
}
if($STATUS == "Koniec pierwszej serii") {

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{

$Stadion = json_decode(stripslashes_deep($rs->Stadion));

if($Stadion->Typ == "Drużynowe") {

$wpdb->update($RELACJE, 
		array( 
			'KaryGosp' => $rs->SkladGosp,
      'SkladGosp' => '',
		),
		array(
			'ID' => intval($ID)
		));


} else {
$GUEST = array();
$SkladGosp = json_decode(stripslashes_deep($rs->SkladGosp));
foreach($SkladGosp as $P) {
$GUEST[$P->name] = $P->first;
}
$SkladGosc = json_decode(stripslashes_deep($rs->SkladGosc));
foreach($SkladGosc as $P) {
$P->first = $GUEST[$P->name];
}
$SkladGosc = json_encode($SkladGosc,JSON_UNESCAPED_UNICODE);

$wpdb->update($RELACJE, 
		array( 
			'KaryGosp' => $rs->SkladGosp,
      'SkladGosp' => '',
      'SkladGosc' => $SkladGosc
		),
		array(
			'ID' => intval($ID)
		));
}

}
}

if($STATUS == "Koniec drugiej serii") {

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{
$Stadion = json_decode(stripslashes_deep($rs->Stadion));

if($Stadion->Typ == "Drużynowe") {

$JUDGE = json_decode(stripslashes_deep($rs->Judge));
$TEAMS = array();

foreach($JUDGE as $T) {
$TEAMS[] = (object) array('name' => $T->name, 'nota' => '', 'poz' => $T->poz, 'zawodnicy' => $T->zawodnicy);
}

$teams = json_encode($TEAMS,JSON_UNESCAPED_UNICODE);

$wpdb->update($RELACJE, 
		array( 
			'KaryGosc' => $rs->SkladGosp,
      'SkladGosp' => $teams,
		),
		array(
			'ID' => intval($ID)
		));


} 
else {
$wpdb->update($RELACJE, 
		array( 
			'KaryGosc' => $rs->SkladGosp,
		),
		array(
			'ID' => intval($ID)
		));
}
}
}


if($STATUS == "Początek pierwszej serii") {

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{
$wpdb->update($RELACJE, 
		array( 
			'KaryGosc' => '',
      'KaryGosp' => '',
		),
		array(
			'ID' => intval($ID)
		));
}
}

$wpdb->update($RELACJE, 
		array( 
			'Stat' => $STATUS
		),
		array(
			'ID' => intval($ID)
		));
}



function wylaczSpotkanie($ID)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$wpdb->update($RELACJE, 
		array( 
			'Status' => 0
		),
		array(
			'ID' => intval($ID)
		));
}


function czyscKary($ID)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{
print $rs->SkladGosp;
$rs->SkladGosp = str_replace('\"kartki\":\"Zolta\"','\"kartki\":\"not\"',$rs->SkladGosp);
$rs->SkladGosp = str_replace('\"kartki\":\"Czerwona\"','\"kartki\":\"not\"',$rs->SkladGosp);
$rs->SkladGosc = str_replace('\"kartki\":\"Zolta\"','\"kartki\":\"not\"',$rs->SkladGosc);
$rs->SkladGosc = str_replace('\"kartki\":\"Czerwona\"','\"kartki\":\"not\"',$rs->SkladGosc);
$wpdb->update($RELACJE, 
		array( 
			'KaryGosp' => '',
      'KaryGosc' => '',
      'SkladGosp' => $rs->SkladGosp,
      'SkladGosc' => $rs->SkladGosc
		),
		array(
			'ID' => intval($ID)
		));
}    
}

function changeGosp($Z, $NA, $MIN, $WPIS, $TYP)	{

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 


$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{

$MIN = $rs->Min;


$N = json_decode(stripslashes_deep($Z));
$Z = json_decode(stripslashes_deep($NA));

print $N->name;
print '<br>'.$Z->name;


/*if(($NA != "") && ($Z !="")) { 

$NEWP = '{\"name\":\"'.$P->name.'\",\"top\":\"'.$G->top.'\",\"left\":\"'.$G->left.'\",\"kartki\":\"'.$P->kartki.'\",\"Zmiana\":\"'.$MIN.'\",\"Gole\":\"'.$P->Gole.'\",\"nr\":\"'.$P->nr.'\"}';
$NEWG = '{\"name\":\"'.$G->name.'\",\"top\":\"'.$P->top.'\",\"left\":\"'.$P->left.'\",\"kartki\":\"'.$G->kartki.'\",\"Zmiana\":\"'.$MIN.'\",\"Gole\":\"'.$G->Gole.'\",\"nr\":\"'.$G->nr.'\"}';
}  */
       if($TYP == "Gosp") {
       
       $Sklad = json_decode(stripslashes_deep($rs->SkladGosp));
       foreach($Sklad as $P) {
      if($Z->name == $P->name) { $P->name = $N->name; $P->Gole = $N->Gole; $P->Zmiana = $MIN; $P->kartki = $N->kartki; $P->nr = $N->nr; }
       }
       $rs->SkladGosp = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       
       $Sklad = json_decode(stripslashes_deep($rs->RezGosp));
       foreach($Sklad as $P) {
       if($N->name == $P->name)  {  $P->name = $Z->name; $P->Gole = $Z->Gole; $P->Zmiana = $MIN; $P->kartki = $Z->kartki; $P->nr = $Z->nr;  }
       }
       $rs->RezGosp = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       
			 //$rs->SkladGosp = str_replace($NA, $NEWP, $rs->SkladGosp);
       //$rs->RezGosp = str_replace($Z, $NEWG, $rs->RezGosp);
       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosp' => $rs->SkladGosp,
      'RezGosp' => $rs->RezGosp,
		   ),
	     array(
			'ID' => intval($_GET['ID'])
		   ));
       } else {
       
       $Sklad = json_decode(stripslashes_deep($rs->SkladGosc));
    
       foreach($Sklad as $P) {
       if($Z->name == $P->name) { $P->name = $N->name; $P->Gole = $N->Gole; $P->Zmiana = $MIN; $P->kartki = $N->kartki; $P->nr = $N->nr; }
       }
       $rs->SkladGosc = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       
       $Sklad = json_decode(stripslashes_deep($rs->RezGosc));
 
       foreach($Sklad as $P) {
       if($N->name == $P->name)  {  $P->name = $Z->name; $P->Gole = $Z->Gole; $P->Zmiana = $MIN; $P->kartki = $Z->kartki; $P->nr = $Z->nr;  }
       }
       
       $rs->RezGosc = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosc' => $rs->SkladGosc,
      'RezGosc' => $rs->RezGosc,
		   ),
	     array(
			 'ID' => intval($_GET['ID'])
		   ));
       }
       


//$WPIS = '<div class="Live_info"><img class="Live_img" src="'.plugins_url( 'img/Zmiana.png', __FILE__ ).'" alt="Zmiana"> <b class="label">Zmiana:</b><p></p><b>'.$P->name.'</b> wchodzi, <b>'.$G->name.'</b> schodzi</div>'.$WPIS;    
//$wpdb->insert( $KWESTIE, array( 'Min' => $MIN, 'Text' => $WPIS, 'Data' => date('Y-m-d H:i:s'), 'RelID' => intval($_GET['ID']) ));
$wpdb->update($RELACJE, 
		array('Min' => $MIN),
		array(
			'ID' => intval($_GET['ID'])
		));
}
}

function Punktuj($Z, $MIN, $WPIS, $TYP, $RODZAJ, $KAT = "", $BRAMKI = 1, $KAT="")	{

if($BRAMKI < 1) $BRAMKI = 1;

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 


$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{
$MIN = $rs->Min;

$Z = json_decode(stripslashes_deep($Z));


       if($TYP == "Gosp") {
			 if($KAT != "Gospodarz" and $KAT != "Gość") { 
       
       if(in_array($KAT,array('Koszykówka','Siatkówka', 'Piłka ręczna'))) { 
       $Sklad = json_decode(stripslashes_deep($rs->SkladGosp));
       foreach($Sklad as $P) {
       if($Z->name == $P->name) $P->Zmiana = '1'; else $P->Zmiana = "";
       }
       $rs->SkladGosp = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       } 
        $Sklad = json_decode(stripslashes_deep($rs->SkladGosp));
       foreach($Sklad as $P) {
       if($Z->name == $P->name) $P->Gole = $P->Gole + $BRAMKI;
       }
       $rs->SkladGosp = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       
       
       $GOL = '{"strzelec":"'.$Z->name.'","min":"'.$MIN.'","team":"'.$TYP.'","rodzaj":"'.$RODZAJ.'"}';
       if($rs->StGosp == "") $rs->StGosp = $GOL; else $rs->StGosp .= ", ".$GOL;   }

       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosp' => $rs->SkladGosp,
      'StGosp' => $rs->StGosp,
      'PktGosp' => $rs->PktGosp + $BRAMKI
		   ),
	     array(
			'ID' => intval($_GET['ID'])
		   ));
       

       } else {
       if($KAT != "Gospodarz" and $KAT != "Gość") { 
       
         if(in_array($KAT,array('Koszykówka','Siatkówka','Piłka ręczna'))) {
       $Sklad = json_decode(stripslashes_deep($rs->SkladGosc));
       foreach($Sklad as $P) {
       if($Z->name == $P->name) $P->Zmiana = '1'; else $P->Zmiana = "";
       }
       $rs->SkladGosc = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       }
        $Sklad = json_decode(stripslashes_deep($rs->SkladGosc));
       foreach($Sklad as $P) {
       if($Z->name == $P->name) $P->Gole = $P->Gole + $BRAMKI;
       }
       $rs->SkladGosc = json_encode($Sklad, JSON_UNESCAPED_UNICODE);
       
       
       $GOL = '{"strzelec":"'.$Z->name.'","min":"'.$MIN.'","team":"'.$TYP.'","rodzaj":"'.$RODZAJ.'"}';
       if($rs->StGosc == "") $rs->StGosc = $GOL; else $rs->StGosc .= ", ".$GOL; }  
       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosc' => $rs->SkladGosc,
      'StGosc' => $rs->StGosc,
      'PktGosc' => $rs->PktGosc + $BRAMKI
		   ),
	     array(
			 'ID' => intval($_GET['ID'])
		   ));
       }
       
       
       
//if(strlen($WPIS)>0) $wpdb->insert( $KWESTIE, array( 'Min' => $MIN, 'Text' => $WPIS, 'Data' => date('Y-m-d H:i:s'), 'RelID' => intval($_GET['ID']) ));
$wpdb->update($RELACJE, 
		array('Min' => $MIN),
		array(
			'ID' => intval($_GET['ID'])
		));
 
       
}
}

function Ukarz($Z, $KARA, $MIN, $WPIS, $TYP)	{


global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{


$MIN = $rs->Min;
$P = json_decode(stripslashes_deep($Z));


       if($TYP == "Gosp") {
       $rs->SkladGosp = json_decode(stripslashes_deep($rs->SkladGosp));
			 foreach($rs->SkladGosp as $T) {
       if($P->name == $T->name) {  $T->kartki = $KARA;} 
       }
       $rs->SkladGosp = json_encode($rs->SkladGosp,JSON_UNESCAPED_UNICODE);
       $KARA = '{"ukarany":"'.$P->name.'", "kara": "'.$KARA.'","min":"'.$MIN.'","team":"'.$TYP.'"}';
       if($rs->KaryGosp == "") $rs->KaryGosp = $KARA; else $rs->KaryGosp .= ", ".$KARA;
       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosp' => $rs->SkladGosp,
      'KaryGosp' => $rs->KaryGosp
		   ),
	     array(
			'ID' => intval($_GET['ID'])
		   ));
       } else {
       $rs->SkladGosc = json_decode(stripslashes_deep($rs->SkladGosc));
			 foreach($rs->SkladGosc as $T) {
       if($P->name == $T->name) {  $T->kartki = $KARA;} 
       }
       $rs->SkladGosc = json_encode($rs->SkladGosc,JSON_UNESCAPED_UNICODE);
       $KARA = '{"ukarany":"'.$P->name.'", "kara": "'.$KARA.'","min":"'.$MIN.'","team":"'.$TYP.'"}';
       if($rs->KaryGosc == "") $rs->KaryGosc = $KARA; else $rs->KaryGosc .= ", ".$KARA;
       $wpdb->update($RELACJE, 
		   array( 
			'SkladGosc' => $rs->SkladGosc,
      'KaryGosc' => $rs->KaryGosc
		   ),       
	     array(
			 'ID' => intval($_GET['ID'])
		   ));
       }    
//if(strlen($WPIS)>0) $wpdb->insert( $KWESTIE, array( 'Min' => $MIN, 'Text' => $WPIS, 'Data' => date('Y-m-d H:i:s'), 'RelID' => intval($_GET['ID']) )); 
$wpdb->update($RELACJE, 
		array('Min' => $MIN),
		array(
			'ID' => intval($_GET['ID'])
		));
       
}
}

function addMecz($GOSP, $GOSC, $KAT, $DATA, $KOMENTATOR, $TURNIEJ, $GOSPIMG, $GOSCIMG) {
		
global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$wpdb->insert( $RELACJE, array( 'Gosp' => $GOSP, 'Gosc' => $GOSC, 'Kategoria' => $KAT, 'Data' => $DATA,  'Komentator' => $KOMENTATOR, 'Rozgrywki' => $TURNIEJ, 'PktGosp' => 0, 'PktGosc' => 0, 'min' => 0, 'GospImg' => $GOSPIMG, 'GoscImg' => $GOSCIMG, 'GospKolor' => 'Bialy', 'GoscKolor' => 'Czerwony', 'PodGol' => '0:0' ) );
}

function dodajTurniej($NAZWA,$SKLAD,$KATEGORIA,$RODZAJ) {
		
global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Turnieje"; 
$PLAYERS = $wpdb->prefix . "LiveApp_Players"; 

$wpdb->insert( $RELACJE, array( 'Nazwa' => $NAZWA, 'Data' => date("Y-m-d H:i:s"), 'Sklad' => $SKLAD, 'Kategoria' => $KATEGORIA, 'Typ' => $RODZAJ)  );
$lastid = $wpdb->insert_id;
//exit( var_dump( $wpdb->last_query ) );      
$PLAYER= json_decode(stripslashes_deep($SKLAD));
foreach($PLAYER as $P) {
$wpdb->insert( $PLAYERS, array( 'Turniej' => $lastid, 'RelID' => 'tournament', 'Kol' => $P->name, 'Kol2' => $P->kraj)  );
}

}

function dodajWpis($WPIS, $MIN, $ID, $RODZAJ, $DMIN, $GOSP = "", $GOSC = "", $PKTGOSP = "", $PKTGOSC = "", $TENISG ="", $TENISC ="", $SKLADGOSP = "", $JUDGE = "", $SPOTKANIE = "") {
		
global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($_GET['ID'])."' LIMIT 1");
foreach ($res as $rs) 
{
if($SPOTKANIE != "") {

 if(empty($LANG[$S0>typ])) { $LA = (object) $LANG['default']; $LSTYL = "default"; } else { $LA = (object) $LANG[$S->typ];  }

$S = json_decode(stripslashes_deep($SPOTKANIE));

if(in_array($S->typ,array('Piłka nożna','Piłka ręczna','Koszykówka','Siatkówka','Tenis','Żużel'))) {

$HEAD = '<header>
<div class="herb">'.((file_exists('../wp-content/plugins/LiveApp/admin/img/Flags/'.$S->gosp.'.png') ==  1 ) ? '<img alt="'.$S->gosp.'" src="'.plugins_url( 'img/Flags/'.$S->gosp.'.png', __FILE__ ).'">' : '').'</div>
<div class="team gosp">'.$S->gosp.'</div>
<div class="goal"><span>'.$S->min.'</span>
<div class="wyn"> '.$S->golegosp.' : '.$S->golegosc.'</div>
';

if($S->sety == "") {

$HEAD .= '<div class="podGol">'.$S->typ.'</div>';

} else {

$pieces = explode(',',$S->sety);  $i=0;
foreach($pieces as $SET) { $i++;
$P = explode(':',$SET);  
if($S->typ == "Tenis") $PodGol .= '<span class="'.(($i == 1) ? 'actualSet ' : '').'set"><i>'.$i.' '.$LA->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>'; else $PodGol .= '<span class="set"><i>'.$i.' '.$LA->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>';
}
$HEAD.= '<div class="podGol sety"><div class="sets">'.$PodGol.'</div></div>';

}

$HEAD .= '
</div>
<div class="team">'.$S->gosc.'</div>
<div class="herb">'.((file_exists('../wp-content/plugins/LiveApp/admin/img/Flags/'.$S->gosc.'.png') == 1) ? '<img alt="'.$S->gosc.'" src="'.plugins_url( 'img/Flags/'.$S->gosc.'.png', __FILE__ ).'">' : '').'</div>
</header>';

} else {

$HEAD = '<header>
<div style="width:100%;text-align:left;display:block" class="team gosp">'.$S->konkurs.'</div>
<div class="miejsce">1. '.$S->gosp.'</div>
<div class="miejsce">2. '.$S->gosc.'</div>
<div class="miejsce">3. '.$S->golegosp.'</div>
</header> <br><br>';


}

$WPIS = $HEAD.$WPIS;
$DMIN = "NULL";

}

if($SKLADGOSP != "") {
$wpdb->update($RELACJE, 
		array('SkladGosp' => $SKLADGOSP),
		array(
			'ID' => intval($ID)
		));
}
if($JUDGE != "") {
$wpdb->update($RELACJE, 
		array('Judge' => $JUDGE),
		array(
			'ID' => intval($ID)
		));
}
if($RODZAJ == 'GemDlaGosp' or $RODZAJ == "GemDlaGosc") { 
if($rs->PodGol == "") $rs->PodGol = '0:0';
$ALL = explode(',',$rs->PodGol);
$AktualSet = explode(':',$ALL[0]);
$GPkt = $AktualSet[0];
$CPkt = $AktualSet[1];
if($RODZAJ == 'GemDlaGosp') $GPkt++; else $CPkt++; 
$newPodGol = $GPkt.':'.$CPkt;
$ALL[0] = $newPodGol; $rs->PodGol = '';
foreach($ALL as $S) { 
$rs->PodGol .= $S.','; 
}
$rs->PodGol = substr($rs->PodGol,0,-1);
$wpdb->update($RELACJE, 
		array('PodGol' => $rs->PodGol),
		array(
			'ID' => intval($ID)
		));
 //exit( var_dump( $wpdb->last_query ) );   
}
if($RODZAJ == 'SetDlaGosp' or $RODZAJ == "SetDlaGosc") { 
if($RODZAJ == 'SetDlaGosp') $rs->PktGosp++; else $rs->PktGosc++;
$wpdb->update($RELACJE, 
		array('PktGosp' => $rs->PktGosp, 'PktGosc' => $rs->PktGosc),
		array(
			'ID' => intval($ID)
		));
}
if($RODZAJ == 'RozpocznijSet') { 

$rs->PodGol = '0:0,'.$rs->PodGol;
$ALL = explode(',',$rs->PodGol);
$STAT = count($ALL)." set";
$wpdb->update($RELACJE, 
		array('PodGol' => $rs->PodGol, 'Stat' => $STAT),
		array(
			'ID' => intval($ID)
		));
}
//if($TENISG != "") $DMIN = $TENISG.":".$TENISC;
if(in_array($rs->Kategoria,array('Siatkówka','Koszykówka','Tenis','Piłka ręczna'))) {
if($GOSP != "") { if($rs->Kategoria == "Siatkówka") $rs->PktGosp++; else $rs->PktGosp = $rs->PktGosp + $PKTGOSP; } 
if($GOSC != "") { if($rs->Kategoria == "Siatkówka") $rs->PktGosc++; else $rs->PktGosc = $rs->PktGosc + $PKTGOSC; } 
if($GOSP != "") { Punktuj($GOSP, $MIN, $WPIS, 'Gosp', 'normal', $GOSP, $PKTGOSP, $rs->Kategoria); } 
if($GOSC != "") {  Punktuj($GOSC, $MIN, $WPIS, 'Gosc', 'normal', $GOSC, $PKTGOSC, $rs->Kategoria); } 
if($rs->Kategoria == "Siatkówka" && $DMIN == "" ) $DMIN = $rs->PktGosp.':'.$rs->PktGosc; 
} 
}

//exit( var_dump( $wpdb->last_query ) );
$wpdb->insert( $KWESTIE, array( 'Min' => $MIN, 'Text' => $WPIS, 'Data' => date('Y-m-d H:i:s'), 'RelID' => $ID, 'Rodzaj' => $RODZAJ, 'Min_display' => $DMIN ));
$wpdb->update($RELACJE, 
		array('Min' => $MIN),
		array(
			'ID' => intval($ID)
		));

}

function edytujWpis($WPIS, $MIN, $ID, $RODZAJ, $DMIN) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$wpdb->update($KWESTIE, array( 'Min' => $MIN, 'Text' => $WPIS, 'Rodzaj' => $RODZAJ, 'Min_display' => $DMIN ),
		array(
			'ID' => intval($ID)
		));
}
function SetTurniej($SKLAD, $TURNIEJ, $ID) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Relacje"; 

print 
$wpdb->update($KWESTIE, array( 'SkladGosp' => $SKLAD, 'SkladGosc' => $SKLAD, 'Turniej' => $TURNIEJ ),
		array(
			'ID' => intval($ID)
		));
}
function ZapiszTurniej($SKLAD,  $ID) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Turnieje"; 

$wpdb->update($KWESTIE, array( 'Sklad' => $SKLAD ),
		array(
			'ID' => intval($ID)
		));
}

function edytujTurniej($NAZWA,$ID,$KAT,$TYP) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Turnieje"; 

$wpdb->update($KWESTIE, array( 'Nazwa' => $NAZWA, 'Kategoria' => $KAT, 'Typ' => $TYP ),
		array(
			'ID' => intval($ID)
		));
}

function DoGory($POZ, $ID) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$res = $wpdb->get_results("SELECT * FROM $KWESTIE WHERE `RelID` = '".intval($_GET['ID'])."' ORDER BY `Min`*1 DESC, `Data` DESC LIMIT ".($POZ-2).", 1");
foreach ($res as $WYZSZY) 
{
$res2 = $wpdb->get_results("SELECT * FROM $KWESTIE WHERE `ID` = '".intval($ID)."' LIMIT 1");
foreach ($res2 as $NIZSZY) 
{
$wpdb->update($KWESTIE, array( 'Min' => $WYZSZY->Min, 'Data' => $WYZSZY->Data ),
		array(
			'ID' => $NIZSZY->ID
		));
$wpdb->update($KWESTIE, array( 'Min' => $NIZSZY->Min, 'Data' => $NIZSZY->Data ),
		array(
			'ID' => $WYZSZY->ID
		));    
}
}
}

function NaDol($POZ, $ID) {
		
global $wpdb; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 

$res = $wpdb->get_results("SELECT * FROM $KWESTIE WHERE `RelID` = '".intval($_GET['ID'])."'  ORDER BY `Min` DESC, `Data` DESC LIMIT ".$POZ.", 1");
$POZ.", 1";
foreach ($res as $NIZSZY) 
{
print $NISZSZY->Min;
$res2 = $wpdb->get_results("SELECT * FROM $KWESTIE WHERE `ID` = '".intval($ID)."' LIMIT 1");
foreach ($res2 as $WYZSZY) 
{
$wpdb->update($KWESTIE, array( 'Min' => $WYZSZY->Min, 'Data' => $WYZSZY->Data ),
		array(
			'ID' => $NIZSZY->ID
		));
$wpdb->update($KWESTIE, array( 'Min' => $NIZSZY->Min, 'Data' => $NIZSZY->Data ),
		array(
			'ID' => $WYZSZY->ID
		));    
}
}
}

function edytujMecz($GOSP, $GOSC, $KAT, $DATA, $KOMENTATOR, $TURNIEJ, $ID, $PKTGOSP = 0, $PKTGOSC = 0, $MIN = 0, $SKLADGOSP = "", $SKLADGOSC = "", $KARYGOSP = "", $KARYGOSC = "", $STGOSP = "", $STGOSC = "", $GOSPIMG = "", $GOSCIMG = "", $REZGOSP = "", $REZGOSC = "", $KOLGOSP = "", $KOLGOSC = "", $TRENERGOSP = "", $TRENERGOSC = "", $STADION = "", $PODGOL = "", $JUDGE = "", $GOLEGOSP = "", $GOLEGOSC = "", $KARYGOSP = "", $KARYGOSC = "", $FAZA = "", $TYP = "", $TUR="") {


$GOLEGOSP = str_replace(array("[","]"),'',$GOLEGOSP);
$GOLEGOSC = str_replace(array("[","]"),'',$GOLEGOSC);
$KARYGOSP = str_replace(array("[","]"),'',$KARYGOSP);
$KARYGOSC = str_replace(array("[","]"),'',$KARYGOSC);

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$wpdb->show_errors = TRUE;
$wpdb->suppress_errors = FALSE;

if($TYP == "Boisko") { $toChange = array( 	'Gosp' => $GOSP, 'Gosc' => $GOSC, 'Kategoria' => $KAT, 'Data' => $DATA, 'Rozgrywki' => $TURNIEJ,  'Komentator' => $KOMENTATOR, 'PktGosp' => $PKTGOSP, 'PktGosc' => $PKTGOSC, 'SkladGosp' => $SKLADGOSP, 'SkladGosc' => $SKLADGOSC, 'GospImg' => $GOSPIMG, 'GoscImg' => $GOSCIMG, 'RezGosp' => $REZGOSP, 'RezGosc' => $REZGOSC, 'GospKolor' => $KOLGOSP, 'GoscKolor' => $KOLGOSC, 'GospTrener' => $TRENERGOSP, 'GoscTrener' => $TRENERGOSC, 'Stadion' => $STADION, 'PodGol' => $PODGOL, 'Faza' => $FAZA, 'Turniej' => $TUR, 'Judge' => $JUDGE); } else if($TYP == "Rest") {
$toChange = array(  'SkladGosp' => $SKLADGOSP, 'SkladGosc' => $SKLADGOSC, 'RezGosp' => $REZGOSP, 'RezGosc' => $REZGOSC, 'Judge' => $JUDGE, 'StGosp' => $GOLEGOSP, 'StGosc' => $GOLEGOSC, 'KaryGosp' =>  $KARYGOSP, 'KaryGosc' => $KARYGOSC );
}
else {  $toChange = array(  'Gosp' => $GOSP, 'Gosc' => $GOSC, 'Kategoria' => $KAT, 'Data' => $DATA, 'Rozgrywki' => $TURNIEJ	); }

    $wpdb->update($RELACJE, 
		$toChange,
		array(
			'ID' => intval($ID)
		));
    
    //var_dump( $wpdb->last_query );
//exit( var_dump( $wpdb->last_query ) );
}

	/*Function for reading ads from saved database*/
  /*
	function readmetaads()
	{
		global $wpdb;
		 $table_name = $wpdb->prefix . "METAAPP_ADS"; 
		 global $wpdb;
		 $res = $wpdb->get_results("SELECT METAAPP_AD_NAME FROM $table_name");
		 $count = 0;
		 foreach ($res as $rs) 
		 {
			 $DATA[$count]=$rs->METAAPP_AD_NAME;
			 $count++;
			 }
		return $DATA;
		}

	Function for inserting Ads data into Database
	function insert($IN_AD_NAME,$IN_AD_CODE,$IN_AD_STYLE)
	{
		global $wpdb;
   		$table_name = $wpdb->prefix . "METAAPP_ADS"; 
  		global $wpdb;
		$AD_NAME = $IN_AD_NAME;
		$AD_CODE = $IN_AD_CODE;
		$AD_STYLE = $IN_AD_STYLE;

  	$rows_affected = $wpdb->insert( $table_name, array( 'METAAPP_AD_NAME' => $AD_NAME, 'METAAPP_AD_CODE' => $AD_CODE, 'METAAPP_AD_STYLE' => $AD_STYLE ) );
	}

	Function for Updating Ads data after modifying into database table
	function update($IN_AD_ID,$IN_AD_CODE,$IN_AD_STYLE)	{
	
		global $wpdb;
 		$table_name = $wpdb->prefix . "METAAPP_ADS"; 
  		global $wpdb;
		$wpdb->update($table_name, 
		array( 
			'METAAPP_AD_CODE' => $IN_AD_CODE,
			'METAAPP_AD_STYLE' => $IN_AD_STYLE
		),
		array(
			'METAAPP_AD_ID' => $IN_AD_ID
		)
 
	);

}

	Function for Deleting data from database table
	function delete($IN_AD_ID)	{
		global $wpdb;
 		$table_name = $wpdb->prefix . "METAAPP_ADS"; 
  		global $wpdb;
		$wpdb->query('DELETE FROM '.$table_name.' WHERE METAAPP_AD_ID = '.$IN_AD_ID);
}

		Registering Styles for Plugin's Setting Option Page/
    	function add_stylesheet() {
       
            wp_register_style('base-style', plugins_url('style.css',__FILE__), array(), '1', 'screen'); 
			wp_enqueue_style('base-style');
    }
	
	Funtion to Load JS (JavaScript) File
	function pw_load_scripts() {
	wp_enqueue_script('custom-js', plugins_url('script.js',__FILE__));
	wp_localize_script('custom-js', 'pw_script_vars', array(
			'ad' => __(readmetaads())
		));
}

 	Function for Deleting database while uninstall the plugin
	function uninstall() {

		global $wpdb;
   		$table_name = $wpdb->prefix . "METAAPP_ADS"; 
  		global $wpdb;
		$wpdb->query('DROP TABLE '.$table_name);
}

Funtion for Adding Button on Plugin's setting option page
function Adsbutton() {
    global $typenow;
    checking for user permissions*
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
   	return;
    }
    verifying post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
	checking if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_tinymce_plugin");
		add_filter('mce_buttons', 'register_my_tc_button');
	}
}
Funtion for Changing Button Script
function add_tinymce_plugin($plugin_array) {
   	$plugin_array['AP_tc_button'] = plugins_url( '/button.js', __FILE__ );
   	return $plugin_array;
}
Function to Register Buttons with WordPress*
function register_my_tc_button($buttons) {
   array_push($buttons, "AP_tc_button");
   return $buttons;
}
*/


//function LIVEAPP_menu() {
// add_menu_page('AddPlayer', 'AddPlayer', 5, 'addplayer', 'mt_toplevel_page');
//}
//add_action( 'admin_menu', 'LIVEAPP_menu' );

function LIVEAPP_menu() {
   add_menu_page('Relacje', 'Relacje', 5, 'LIVEAPP', 'mt_LIVEAPP');
}

function load_CSS() {
	wp_register_style( 'myCss', plugins_url('admin/default.css', __FILE__) );
  wp_enqueue_style( 'myCss' );
}

function load_JS() {
	wp_enqueue_script('custom-js', plugins_url('zebra_datepicker.js',__FILE__));
	wp_enqueue_script('jquery-ui-droppable');
  wp_enqueue_script('jquery-ui-draggable');
  wp_enqueue_script('custom-angular', plugins_url('angular.js',__FILE__	));
  //wp_enqueue_script('custom-angular-drag', plugins_url('angular-dragdrop.min.js',__FILE__	));
}

function wp_gear_manager_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles() {
wp_enqueue_style('thickbox');
}