<?php

function mt_LIVEAPP() {

  
	  global $wpdb;
	 
   $RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
   $KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 
		
	echo '<div><h2>Relacje <input style="margin-left:20px;" class="button" type="button" onClick="window.location=\'?page=LIVEAPP&Turnieje\'" value="Zarządzaj turniejami"> </h2> </div>';


	if(isset($_POST['dodajMecz']))
	{      
  if($_POST['godzina'] < 10) $_POST['godzina'] += "0"; 
  if($_POST['minuta'] < 10) $_POST['minuta'] += "0"; 
	addMecz($_POST['gosp'],$_POST['gosc'],$_POST['kategoria'], $_POST['data']." ".$_POST['godzina'].":".$_POST['minuta'].":00", $_POST['autor'], $_POST['turniej'], $_POST['upload_image_gosp'], $_POST['upload_image_gosc']);
	echo '<div class="updated"><h3>Spotkanie zostało dodane!</h3></div><br/>';
	}
  
  if(isset($_POST['dodajTurniej']))
	{      
	dodajTurniej($_POST['Nazwa'],$_POST['Sklad'],$_POST['kategoria'],$_POST['typ']);
	echo '<div class="updated"><h3>Turniej został dodany!</h3></div><br/>';
	}

	if(isset($_GET['deleteMecz']))
	{
	deleteData($_GET['ID']);
	echo '<div class="error"><h3>Usunięto!</h3></div><br/>';
	}
  
  if(isset($_GET['deleteTurniej']))
	{
	deleteTur($_GET['ID']);
	echo '<div class="error"><h3>Usunięto!</h3></div><br/>';
	}
  
  if(isset($_GET['deleteWpis']))
	{
	deleteWpis($_GET['ID']);
	echo '<div class="error"><h3>Usunięto!</h3></div><br/>';
	}
  
  if(isset($_GET['CzyscMecze']))
	{ 
   deleteMecze($_GET['CzyscMecze']);
	 echo '<div class="error"><h3>Usunięto!</h3></div><br/>';  
  }
  if(isset($_GET['WlaczSpotkanie']))
	{
	wlaczSpotkanie($_GET['ID']);
	echo '<div class="updated"><h3>Transmisja została uruchomiona!</h3></div><br/>';
	}
   if(isset($_GET['WlaczNaZywo']))
	{
	naZywo($_GET['ID'],2);
	echo '<div class="updated"><h3>Transmisja jest teraz w trybie na żywo!</h3></div><br/>';
	}
   if(isset($_GET['WylaczNaZywo']))
	{
	naZywo($_GET['ID'],1);
	echo '<div class="updated"><h3>Transmisja  nie jest teraz w trybie na żywo!</h3></div><br/>';
	}
  if(isset($_POST['ChangeStatus']))
	{
	changeStatus($_GET['ID'], $_POST['MeczStatus']);
	echo '<div class="updated"><h3>Zmieniono!</h3></div><br/>';
	}
  
  if(isset($_GET['WylaczSpotkanie']))
	{
	wylaczSpotkanie($_GET['ID']);
	echo '<div class="updated"><h3>Transmisja została zakończona!</h3></div><br/>';
	}
  
   if(isset($_GET['czyscKary']))
	{
	czyscKary($_GET['ID']);
	}
  
  if(isset($_POST['ChangeGosp']))
	{
	ChangeGosp($_POST['ZmienGosp'],$_POST["DoZmianyGosp"],$_POST['min'],$_POST['wpis'], 'Gosp');
	echo '<div class="updated"><h3>Zmiana została przeprowadzona!</h3></div><br/>';
	}
  
  if(isset($_POST['AddPktGosp']))
	{
  Punktuj($_POST['strzelecGosp'],$_POST['min'],$_POST['wpis'], 'Gosp', $_POST['BramkaGosp']);
	echo '<div class="updated"><h3>Dodano!</h3></div><br/>';
	}
  if(isset($_POST['AddPktGosc']))
	{
	Punktuj($_POST['strzelecGosc'],$_POST['min'],$_POST['wpis'], 'Gosc', $_POST['BramkaGosc']);
	echo '<div class="updated"><h3>Dodano!</h3></div><br/>';
	}
  
   if(isset($_POST['KarzGosp']))
	{
  Ukarz($_POST['ukaranyGosp'],$_POST['GospKara'], $_POST['min'],$_POST['wpis'], 'Gosp');
	echo '<div class="updated"><h3>Ukarano!</h3></div><br/>';
	}
  if(isset($_POST['KarzGosc']))
	{
	Ukarz($_POST['ukaranyGosc'],$_POST['GoscKara'], $_POST['min'],$_POST['wpis'], 'Gosc');
	echo '<div class="updated"><h3>Ukarano!</h3></div><br/>';
	}
  
  if(isset($_POST['ChangeGosc']))
	{
	ChangeGosp($_POST['ZmienGosc'],$_POST["DoZmianyGosc"],$_POST['min'],$_POST['wpis'], 'Gosc');
	echo '<div class="updated"><h3>Zmiana została przeprowadzona!</h3></div><br/>';
	}
  
  if(isset($_POST['ZmienId']))
	{
	edytujMecz($_POST['gosp'],$_POST['gosc'],$_POST['kategoria'], $_POST['data'], $_POST['komentator'], $_POST['turniej'], $_POST['ZmienId']);
	echo '<div class="updated"><h3>Zrobiono!</h3></div><br/>';
	}
   
   if(isset($_POST['setTur']))
	{
	SetTurniej($_POST['Sklad'],$_POST['Turniej'],$_GET['ID']);
	echo '<div class="updated"><h3>Zrobiono!</h3></div><br/>';
	}
   
  if(isset($_POST['ZmienTur']))
	{
  edytujTurniej($_POST['Nazwa'],$_POST['ZmienTur'],$_POST['kategoria'],$_POST['typ']);
	echo '<div class="updated"><h3>Zrobiono!</h3></div><br/>';
	}
   if(isset($_POST['dodajWpis']))
	{
	dodajWpis($_POST['wpis'], $_POST['min'], $_GET['ID'], $_POST['RodzajWpisu'], $_POST['dmin'], $_POST['strzelecGosp'], $_POST['strzelecGosc'], $_POST['IlePktGosp'], $_POST['IlePktGosc'], $_POST['PktGospTenis'],  $_POST['PktGoscTenis'], $_POST['GospSklad'], $_POST['Judge'], $_POST['spotkanie']);
	echo '<div class="updated"><h3>Dodano wpis!</h3></div><br/>';
	}
   if(isset($_POST['edytujWpis']))
	{
	edytujWpis($_POST['wpis'], $_POST['min'], $_POST['WPISID'], $_POST['RodzajWpisu'], $_POST['dmin']);
	echo '<div class="updated"><h3>Zrobione!</h3></div><br/>';
	}
  
   if(isset($_POST['ZapiszTur']))
	{
	ZapiszTurniej($_POST['Sklad'],$_GET['TID']);
	echo '<div class="updated"><h3>Zapisano!</h3></div><br/>';
	}
  
  if(isset($_POST['DoGory']))
	{
	doGory($_POST['pozycja'], $_POST['WpisID']);
	echo '<div class="updated"><h3>Zrobione!</h3></div><br/>';
	}
   if(isset($_POST['NaDol']))
	{
	NaDol($_POST['pozycja'], $_POST['WpisID']);
	echo '<div class="updated"><h3>Zrobione!</h3></div><br/>';
	}
   
  if(isset($_POST['zapiszMecz']) and !isset($_POST['dodajWpis']))                                                                                                                                         
	{
  if($_POST['godzina'] < 10) $_POST['godzina'] += "0"; 
  if($_POST['minuta'] < 10) $_POST['minuta'] += "0"; 
	edytujMecz($_POST['gosp'],$_POST['gosc'],$_POST['kategoria'],  $_POST['data']." ".$_POST['godzina'].":".$_POST['minuta'].":00", $_POST['autor'], $_POST['turniej'], $_POST['id'],$_POST['PktGosp'], $_POST['PktGosc'],  $_POST['Min'], $_POST['SkladGosp'], $_POST['SkladGosc'], $_POST['KaryGosp'], $_POST['KaryGosc'], $_POST['PktGospS'], $_POST['PktGoscS'], $_POST['upload_image_gosp'], $_POST['upload_image_gosc'], $_POST['RezGosp'], $_POST['RezGosc'], $_POST['KolorGosp'], $_POST['KolorGosc'], $_POST['TrenerGosp'], $_POST['TrenerGosc'], '{ "name": "'.$_POST['sname'].'", "image": "'.$_POST['upload_image_stadion'].'", "city": "'.$_POST['scity'].'", "sset": "'.$_POST['sset'].'", "Typ": "'.$_POST['Typ'].'", "Impreza": "'.$_POST['sImpreza'].'", "Rozmiar": "'.$_POST['sRozmiar'].'", "logo": "'.$_POST['upload_image_logo'].'"}', $_POST['PodGol'], $_POST['Judge'], $_POST['GoleGosp'], $_POST['GoleGosc'], $_POST['KaryGosp'], $_POST['KaryGosc'], $_POST['Faza'],'Boisko',$_POST['tur']);
	echo '<div class="updated"><h3>Zrobiono!</h3></div><br/>';
	}
  
  if(isset($_POST['zapiszRest']))                                                                                                                                         
	{
  if($_POST['godzina'] < 10) $_POST['godzina'] += "0"; 
  if($_POST['minuta'] < 10) $_POST['minuta'] += "0"; 
	edytujMecz($_POST['gosp'],$_POST['gosc'],$_POST['kategoria'],  $_POST['data']." ".$_POST['godzina'].":".$_POST['minuta'].":00", $_POST['autor'], $_POST['turniej'], $_POST['id'],$_POST['PktGosp'], $_POST['PktGosc'],  $_POST['Min'], $_POST['SkladGosp'], $_POST['SkladGosc'], $_POST['KaryGosp'], $_POST['KaryGosc'], $_POST['PktGospS'], $_POST['PktGoscS'], $_POST['upload_image_gosp'], $_POST['upload_image_gosc'], $_POST['RezGosp'], $_POST['RezGosc'], $_POST['KolorGosp'], $_POST['KolorGosc'], $_POST['TrenerGosp'], $_POST['TrenerGosc'], '{ "name": "'.$_POST['Stadion'].'", "image": "'.$_POST['upload_image_stadion'].'", "LiczbaMiejsc": "'.$_POST['LiczbaMiejsc'].'", "RokBudowy": "'.$_POST['RokBudowy'].'", "Opis": "'.$_POST['StadionOpis'].'"}', $_POST['PodGol'], $_POST['Judge'], $_POST['GoleGosp'], $_POST['GoleGosc'], $_POST['KaryGosp'], $_POST['KaryGosc'],'', 'Rest');
	echo '<div class="updated"><h3>Zrobiono!</h3></div><br/>';
	}
  
  ?>
    <script type="text/javascript">

   jQuery(document).ready(function() {

   jQuery('.data').Zebra_DatePicker({

  view: 'years'

});

 });
 </script>
 
 <?php if(isset($_GET['Komentuj'])) { 
 
 $T = getMecz($_GET['ID']);
 if(count($T) > 0) {
 include_once('lang.php');
 if(empty($LANG[$T->Kategoria])) { $L = (object) $LANG['default']; $LSTYL = "default"; } else { $L = (object) $LANG[$T->Kategoria];  }
     $Stadion = json_decode(stripslashes_deep($T->Stadion));
 ?>
  <script language="JavaScript">
jQuery(document).ready(function() {
jQuery('#upload_image_button, #upload_image2_button, #upload_image_stadion, #upload_logo_button').click(function() {
if(jQuery(this).attr('id') == "upload_image_button") { img = '#upload_image'; formfield = jQuery('#upload_image').attr('name'); } else if(jQuery(this).attr('id') == "upload_image2_button") { img = '#upload_image2';  formfield = jQuery('#upload_image2').attr('name'); } 
else if(jQuery(this).attr('id') == "upload_logo_button") { img = '#upload_logo';  formfield = jQuery('#upload_logo').attr('name'); } 
else { img = '#upload_stadion';  formfield = jQuery('#upload_stadion').attr('name'); }
tb_show('', 'media-upload.php?type=image&TB_iframe=true');
return false;
});
jQuery('#WpisForm input, #WpisForm textarea, #WpisForm select').prop('disabled',false);
<? if($T->Kategoria != 'Skoki narciarskie') { ?>
jQuery('#BoiskoForm input, #BoiskoForm textarea, #BoiskoForm select').change(function() {              
jQuery('#WpisForm').css('opacity','0.5');
jQuery('#WpisForm input, #WpisForm textarea, #WpisForm select').prop('disabled',true);
});
<? } ?>

window.send_to_editor = function(html) {
imgurl = jQuery('img',html).attr('src');
jQuery(img).val(imgurl);
tb_remove();
}

});



var app = angular.module("MyApp", []);

app.directive('modelChangeBlur', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
            link: function(scope, elm, attr, ngModelCtrl) {
            if (attr.type === 'radio' || attr.type === 'checkbox') return;

            elm.unbind('input').unbind('keydown').unbind('change');
            elm.bind('blur', function() {
                scope.$apply(function() {
                    ngModelCtrl.$setViewValue(elm.val());
                });         
            });
        }
    };
});                                                                                                                               


app.controller("mainController", function ($scope) {

// Item List Arrays


$scope.GospPlayers = <? if($T->SkladGosp != "") echo stripslashes_deep($T->SkladGosp) ;else echo '[]'?>;
$scope.GoscPlayers = <? if($T->SkladGosc != "") echo stripslashes_deep($T->SkladGosc); else echo '[]'?>;
$scope.GospRez = <? if($T->RezGosp != "") echo stripslashes_deep($T->RezGosp); else  echo '[]'?>;
$scope.GoscRez = <? if($T->RezGosc != "") echo stripslashes_deep($T->RezGosc); else echo '[]'?>;
$scope.Judge = <? if($T->Judge != "") echo stripslashes_deep($T->Judge); else echo '[]'?>;
$scope.GospGole = <? if($T->StGosp != "") echo '['.stripslashes_deep($T->StGosp).']'; else echo '[]'?>;
$scope.GoscGole = <? if($T->StGosc != "") echo '['.stripslashes_deep($T->StGosc).']'; else echo '[]'?>;
$scope.GospKary = <? if($T->KaryGosp != "") echo ''.stripslashes_deep($T->KaryGosp).''; else echo '[]'?>;
$scope.GoscKary = <? if($T->KaryGosc != "") echo '['.stripslashes_deep($T->KaryGosc).']'; else echo '[]'?>;

$scope.Goscpoz = $scope.GoscPlayers.length+1;


$scope.addGosp = function () {
    $scope.GospPlayers.push({
        name: $scope.DodajGosp,
        top: '0px',
        left: '0px',
        kartki: 'not',
        Zmiana: 'not',
        Gole: 'not',
        nr: '00'
    });
      $scope.DodajGosp = "";
  
};

 $scope.addSpotkanie = function () {
 
     $scope.GospPlayers.push({
        typ: $scope.TypRelacji,
        gosp: $scope.RelGosp,   
        gosc: $scope.RelGosc,
        golegosp: $scope.RelGGosp,
        golegosc: $scope.RelGGosc,
        min: $scope.RelMin,
        sety: $scope.RelSety,
        konkurs: $scope.RelKonkurs
        }); 
        
        $scope.TypRelacji = "";
        $scope.RelGosp = "";   
        $scope.RelGosc = "";
        $scope.RelGGosp = "";
        $scope.RelGGosc = "";
        $scope.RelMin = "";
        $scope.RelSety = "";
        $scope.RelKonkurs = "";                                              

};

    $scope.addGrupa = function () {
    
    var ilePrzed = 0;
    angular.forEach($scope.GospPlayers, function(item) {
    if(item.grupa == $scope.DodajGrupa) { ilePrzed++; }
    });
    
    ilePrzed++;
    
     $scope.GospPlayers.push({
        name: $scope.DodajGosp,   
        grupa: $scope.DodajGrupa,  
        poz: ilePrzed,
        kraj: $scope.Gospkraj
        });                                               

   $scope.DodajGosp = "";
    $scope.DodajGrupa = "";
    $scope.Gospkraj = "";

};

    $scope.addZawodnik = function () {
        
    var ilePrzed = 0;
    var breakIt = 0;
    angular.forEach($scope.GospPlayers, function(item) {
    if(item.poz <= $scope.Gosppoz) { item.poz++; }
    if(item.name <= $scope.DodajGosp) { item.poz++; }
    });
     
     if(breakIt == 0) {
     $scope.GospPlayers.push({
        name: $scope.DodajGosp,
        poz: $scope.Gosppoz,
        kraj: $scope.Gospkraj,
        nota: $scope.Gospnota
    });
  
  
    $scope.DodajGosp = "";
    $scope.Gosppoz = "";
    $scope.Gospkraj = "";
    $scope.Gospnota = "";
    
    }
    
};


    $scope.addSkoczek = function () {
    
    <? if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == "TCS") { ?>var gosp = jQuery.parseJSON($scope.DodajGosp); <? } ?>
    
    var ilePrzed = 0;
    var breakIt = 0;
    angular.forEach($scope.GospPlayers, function(item) {
    if(item.kraj == $scope.Gospkraj) { ilePrzed++; }
    if(item.name == <? if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == "TCS") { print 'gosp.name'; } else { print '$scope.DodajGosp'; }?>) breakIt = 1;
    console.log(item.kraj+item.name+"="+$scope.Gospkraj);
    //$scope.$apply();
    });
    
    ilePrzed++;
    
    if(breakIt == 0) {
    
  
     $scope.GospPlayers.push({
        <? if($Stadion->Typ == "Drużynowe") { ?>
        poz: ilePrzed,
        <? } else if($Stadion->Typ == "TCS" and $T->KaryGosp == "") { ?>
        poz: gosp.poz,
        left: $scope.GospPlayers.length+1,
        ranking: $scope.GospRanking,
        <? } else { ?>                                                          
        poz: $scope.Gosppoz,
        <? } ?>
        name: <? if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == "TCS") { print 'gosp.name'; } else { print '$scope.DodajGosp'; } ?>,
        kraj:  <? if($Stadion->Typ == "Indywidualne"  or $Stadion->Typ == "TCS") { print 'gosp.kraj'; } else {   print '$scope.Gospkraj'; }?>,
        <? if($T->KaryGosp != "" ) { ?>
        <? if($Stadion->Typ == "Indywidualne") print 'first: gosp.first,'; ?>
        sec: $scope.Gospfirst,
        <? } else { ?>
        first: $scope.Gospfirst,
        <? } ?>
        nota: $scope.Gospnota
    });
   
   <? if($Stadion->Typ == "Indywidualne" or $Stadion->Typ == "TCS" and $T->KaryGosp != "") { ?>
   angular.forEach($scope.GospPlayers, function(item) {
   if((item.poz >= $scope.Gosppoz) & (item.name != gosp.name)) { item.poz++;}
  })
  <? } ?>
  <? if($Stadion->Typ == "TCS" and $T->KaryGosp == "" ) { ?>
   angular.forEach($scope.GospPlayers, function(item) {
   if((item.ranking >= $scope.GospRanking) & (item.name != gosp.name)) { item.ranking++;}
  })
  <? } ?>
  
  
   $scope.DodajGosp = "";
    $scope.Gospnota = "";
    $scope.Gospfirst = "";
    $scope.Gospkraj = "";
    $scope.Gosppoz  = "";
    $scope.GospRanking = "";
    



  }
};

$scope.DoGory = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.GospPlayers, function(item) {
   if(item.name == NewName) { item.poz = NewPoz;}
   if((item.poz == NewPoz) & (item.name != NewName)) { item.poz++;}
  //$scope.$apply();
});
}


$scope.NaDol = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.GospPlayers, function(item) {
   if(item.name == NewName) { item.poz = NewPoz;}
   if((item.poz == NewPoz) & (item.name != NewName)) { item.poz--;}
  //$scope.$apply();
});
}

$scope.IndexDoGory = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.GospPlayers, function(item) {
   if(item.name == NewName) { item.left = NewPoz;}
   if((item.left == NewPoz) & (item.name != NewName)) { item.left++;}
  //$scope.$apply();
});
}


$scope.IndexNaDol = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.GospPlayers, function(item) {
   if(item.name == NewName) { item.left = NewPoz;}
   if((item.left == NewPoz) & (item.name != NewName)) { item.left--;}
  //$scope.$apply();
});
}


$scope.Sortuj = function (NewPoz, NewName) {
angular.forEach($scope.GospPlayers, function(item) {
   if((item.poz >= NewPoz) & (item.name != NewName)) { item.poz++; console.log(item.name+'with'+item.poz);}
  //$scope.$apply();
});
}
$scope.SortujGosc = function (NewPoz, NewName) {
angular.forEach($scope.GoscPlayers, function(item) {
   if((item.poz >= NewPoz) & (item.name != NewName)) { item.poz++; console.log(item.name+'with'+item.poz);}
  //$scope.$apply();
});
}

$scope.addJudge = function () {
    
    $scope.Judge.push({
        name: $scope.DodajJudge,
        <? if($T->Kategoria == "Skoki narciarskie") { ?>poz: $scope.Judge.length+1 <? }?>
    });
     //$scope.GospPlayers.push({ poz: 1, kraj: $scope.DodajJudge });
     //$scope.GospPlayers.push({ poz: 2, kraj: $scope.DodajJudge });
     //$scope.GospPlayers.push({ poz: 3, kraj: $scope.DodajJudge });
     //$scope.GospPlayers.push({ poz: 4, kraj: $scope.DodajJudge });
    //setTimeout(function() {jQuery('.player').draggable({ containment: "#boisko" }); }, 1000);

    $scope.DodajJudge= "";
    $scope.Goscpoz = $scope.Goscpoz + 1;
  
};

$scope.addGosc = function () {
    $scope.GoscPlayers.push({
        name: $scope.DodajGosc,
        top: '0px',
        left: '0px',
        kartki: 'not',
        Zmiana: 'not',
        Gole: 'not',
        nr: '00'
    });
    
    //setTimeout(function() {jQuery('.player').draggable({ containment: "#boisko" }); }, 1000);
  
    $scope.DodajGosc = "";
};

$scope.addGoscSkoczek = function () {

    var breakIt = 0;
    angular.forEach($scope.GoscPlayers, function(item) {
    if(item.name == $scope.DodajGosc) { breakIt = 1; }
    });
    
    if(breakIt == 0 && $scope.DodajGosc != "") {
    $scope.GoscPlayers.push({
        name: $scope.DodajGosc,
        kraj: $scope.Gosckraj,
        poz: $scope.Goscpoz
    });
    
    $scope.SortujGosc($scope.Goscpoz,  $scope.DodajGosc);
    $scope.DodajGosc = "";
    $scope.Goscpoz = $scope.GoscPlayers.length+1;
    $scope.Gosckraj = "";
    
    }
    
    
    //setTimeout(function() {jQuery('.player').draggable({ containment: "#boisko" }); }, 1000);
   
};


$scope.addRezGosp = function () {
    $scope.GospRez.push({
        name: $scope.DodajRezGosp,
        top: '0px',
        left: '0px',
        kartki: 'not',
        Zmiana: 'not',
        Gole: 'not',
        nr: '00'
    });
  
    $scope.DodajRezGosp = "";
  
};


$scope.addRezGosc = function () {
    $scope.GoscRez.push({
        name: $scope.DodajRezGosc,
        top: '0px',
        left: '0px',
        kartki: 'not',
        Zmiana: 'not',
        Gole: 'not',
        nr: '00'
    });

    $scope.DodajRezGosc = "";
  
};

 $scope.removeGosp = function(item){
    $scope.GospPlayers.splice($scope.GospPlayers.indexOf(item), 1);  ;
  }
 $scope.removeGosc = function(item){
    $scope.GoscPlayers.splice($scope.GoscPlayers.indexOf(item), 1);
  }
 $scope.removeRezGosp = function(index){
    $scope.GospRez.splice(index, 1);
  }
 $scope.removeRezGosc = function(index){
    $scope.GoscRez.splice(index, 1);
  }
  $scope.removeJudge = function(judge) {
  console.log($scope.GospPlayers);
  var i = $scope.GospPlayers.length;
  while (i--){
    if ($scope.GospPlayers[i].kraj == judge.name){
        $scope.GospPlayers.splice(i, 1);
    }
  }
    $scope.Judge.splice($scope.Judge.indexOf(judge), 1);
  }
  $scope.removeGolGosp = function(index){
    $scope.GospGole.splice(index, 1);
  }
  $scope.removeGolGosc = function(index){
    $scope.GoscGole.splice(index, 1);
  }
    $scope.removeKaraGosp = function(index){
    $scope.GospKary.splice(index, 1);
  }
  $scope.removeKaraGosc = function(index){
    $scope.GoscKary.splice(index, 1);
  }
  $scope.removeGoleGosp = function(index) {
  if($scope.GospPlayers[index].Gole == 1 || $scope.GospPlayers[index].Gole == 'not' ) $scope.GospPlayers[index].Gole = 'not'; else $scope.GospPlayers[index].Gole = $scope.GospPlayers[index].Gole-1;
  $scope.$apply();
};
  $scope.removeGoleGosc = function(index) {
  if($scope.GoscPlayers[index].Gole == 1 || $scope.GoscPlayers[index].Gole == 'not') $scope.GoscPlayers[index].Gole = 'not'; else $scope.GoscPlayers[index].Gole = $scope.GoscPlayers[index].Gole-1;
  $scope.$apply();
};
  $scope.removeKaryGosc = function(index) {
   if($scope.GoscPlayers[index].kartki == "Czerwona" || $scope.GoscPlayers[index].kartki == "Druga zolta") { 
   $scope.GoscPlayers[index].kartki = "Zolta"; } 
   else  { $scope.GoscPlayers[index].kartki = 'not'; }
  $scope.$apply();
};
  $scope.removeKaryGosp = function(index) {
  if($scope.GospPlayers[index].kartki == "Czerwona" || $scope.GospPlayers[index].kartki == "Druga zolta" ) { $scope.GospPlayers[index].kartki = "Zolta"; } else { $scope.GospPlayers[index].kartki = 'not'; }
  $scope.$apply();
};



   
$scope.prepareForm = function() {

jQuery("#SkladGosp").val(angular.toJson($scope.GospPlayers));
jQuery("#SkladGosc").val(angular.toJson($scope.GoscPlayers));
jQuery("#RezGosp").val(angular.toJson($scope.GospRez));
jQuery("#RezGosc").val(angular.toJson($scope.GoscRez));


setTimeout(function(){jQuery("#BoiskoForm").submit()},1000);
}

$scope.prepareWpisForm = function() {

jQuery("#SkladGosp").val(angular.toJson($scope.GospPlayers));
jQuery("#SkladGosc").val(angular.toJson($scope.GoscPlayers));
jQuery("#RezGosp").val(angular.toJson($scope.GospRez));
jQuery("#RezGosc").val(angular.toJson($scope.GoscRez));
jQuery("#Judge").val(angular.toJson($scope.Judge));
var input = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "dodajWpis").val("true");
jQuery('#WpisForm').append(jQuery(input));

setTimeout(function(){jQuery("#WpisForm").submit()},1000);
}

$scope.prepareFormSec = function() {

jQuery("#Judge").val(angular.toJson($scope.Judge));
jQuery("#GoleGosp").val(angular.toJson($scope.GospGole));
jQuery("#GoleGosc").val(angular.toJson($scope.GoscGole));
jQuery("#KaryGosp").val(angular.toJson($scope.GospKary));
jQuery("#KaryGosc").val(angular.toJson($scope.GoscKary));


setTimeout(function(){jQuery("#RestForm").submit()},1000);
}


// This makes any element draggable

});

// Usage: <div draggable>Foobar</div>
app.directive('draggable', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            element.draggable({
                cursor: "move",
                scope: { top: '=', left: '=' },
                stop: function (event, ui) {
                if(attrs.type == "Gosp") {
                 scope.GospPlayers[scope.$index].top = ui.position.top + "px";
                 scope.GospPlayers[scope.$index].left = ui.position.left + "px";
                }
                else {
                 scope.GoscPlayers[scope.$index].top = ui.position.top + "px";
                 scope.GoscPlayers[scope.$index].left = ui.position.left + "px";
                }
               
                scope.$apply();
                },
                replace: true,
            });
        }
    };
});  





function textarea_to_tinymce(id) {
    if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
        tinyMCE.execCommand('mceAddEditor', false, id);
    }
}
                                                                                                                 
function EditWpis(ids) {
 jQuery(".Fog textarea").val(jQuery('#wpis'+ids+' .text').html());
 jQuery(".Fog input[name='min']").val(jQuery('#wpis'+ids+' input[name="min"]').val());
 jQuery(".Fog input[name='dmin']").val(jQuery('#wpis'+ids+' input[name="dmin"]').val());
 jQuery(".Fog input[name='WPISID']").val(ids);
 jQuery(".Fog input:radio[value='"+jQuery('#wpis'+ids+' input[name="rodzaj"]').val()+"']").prop('checked', true);
 textarea_to_tinymce('wpisEditText');
 jQuery(".Fog").fadeIn();
 window.scrollTo(0,0);   
}

</script>
<?php 
//if(in_array($T->Kategoria, array("Skoki narciarskie","Kolarstwo")) and $T->Turniej == "") {
//include 'dostosujTur.php';
//exit();
//}
?>
<div class="Fog">
<div class="WpisEditor">
<form  action="?page=LIVEAPP&Komentuj=1&ID=<?= $T->ID;?>" method="POST">   
<input name="WPISID" type="hidden" value="">
<h2>Edytuj wpis</h2>
Minuta: <input type="text" style="width:100px;" value="" name="min"><br><br> 
Godzina: <input type="text" style="width:100px;" value="" name="dmin"><br><br> 
Rodzaj wpisu: 
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) { echo '<br><br><b>Rzut karny</b>: ';  echo '<input type="radio" name="RodzajWpisu" value="Gosp"> Gospodarz'; 
echo '<input type="radio" name="RodzajWpisu" value="Gosc"> Gość <br><br>'; } ?> 
<input type="radio" checked name="RodzajWpisu" value="normal"> Normalny 
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Zmiana"> Zmiana'; ?> 
<? if($T->Kategoria == 'Koszykówka') echo '<input type="radio" name="RodzajWpisu" value="Dyskwalifikacja"> Dyskwalifikacja'; ?> 
<? if($T->Kategoria == 'Koszykówka') echo '<input type="radio" name="RodzajWpisu" value="RzutWolny"> Rzut wolny'; ?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Zolta"> Żółta kartka';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Druga zolta"> Druga żółta';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input name="RodzajWpisu" type="radio" value="Czerwona"> Czerwona kartka';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna')))  echo '<input type="radio" name="RodzajWpisu" value="Gol"> Gol ';?>
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="karny"> Rzut karny ';?>
<? if(!in_array($T->Kategoria,array('Biegi narciarskie','Skoki narciarskie','Losowanie'))){  ?><input type="radio" name="RodzajWpisu" value="Foul"> Gwizdek  <? } ?>
 <input type="radio" name="RodzajWpisu" value="Special"> Wyróżnione 
<? if(!in_array($T->Kategoria,array('Skoki narciarskie','Losowanie','Multirelacja'))) echo '<input type="radio" name="RodzajWpisu" value="Kontuzja"> Kontuzja';?> 
<? if($T->Kategoria == 'Tenis') { echo '<input type="radio" name="RodzajWpisu" value="As"> As/Meczowa'; }?> 
<? if($T->Kategoria == 'Siatkówka') {  
echo '<input type="radio" name="RodzajWpisu" value="As"> As/Meczowa'; 
echo '<input type="radio" name="RodzajWpisu" value="GospSet"> Gospodarz ';
echo '<input type="radio" name="RodzajWpisu" value="GoscSet"> Gość'; 
} ?> 
<? if($T->Kategoria == 'Tenis') {  
echo '<input type="radio" name="RodzajWpisu" value="GemDlaGosp"> Gem dla '.$T->Gosp.' ';
echo '<input type="radio" name="RodzajWpisu" value="GemDlaGosc"> Gem dla '.$T->Gosc.' '; 
echo '<input type="radio" name="RodzajWpisu" value="SetDlaGosp"> Set dla '.$T->Gosp.' ';
echo '<input type="radio" name="RodzajWpisu" value="SetDlaGosc"> Set dla '.$T->Gosc.' '; 
echo '<input type="radio" name="RodzajWpisu" value="RozpocznijSet"> Rozpocznij set '; 
echo '<input type="radio" name="RodzajWpisu" value="Skrecz"> Krecz'; 
} ?> 
<? if($T->Kategoria == 'Skoki narciarskie') {  
echo '<input type="radio" name="RodzajWpisu" value="Dyskwalifikacja"> Dyskwalifikacja '; 
echo ' <input type="radio" name="RodzajWpisu" value="Kontuzja"> Kontuzja '; 
} ?> 
<? if(in_array($T->Kategoria,array('Siatkówka','Piłka ręczna','Koszykówka'))) echo '<input type="radio" name="RodzajWpisu" value="Time"> Czas';?> 
<? if(in_array($T->Kategoria,array('Skoki narciarskie'))) echo '<input type="radio" name="RodzajWpisu" value="TimeSkoki"> Początek/Koniec serii';?> 
<? if(in_array($T->Kategoria,array('Tenis'))) echo '<input type="radio" name="RodzajWpisu" value="Time"> Przerwa';?> 
<? if($T->Kategoria == 'Piłka ręczna') echo '<input type="radio" name="RodzajWpisu" value="Kara"> Kara'; ?> 
<br><br>Tekst:<br> <br>
<textarea name="wpis" id="wpisEditText"></textarea><br>
<input class="button-primary" type="submit" name="edytujWpis" value="Dodaj">  <input class="buttony" type="submit" name="dodajWpis" value="Anuluj" onClick="jQuery('.Fog').fadeOut()">
</form>
</div>
</div>

    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
 <div ng-app="MyApp" ng-controller="mainController">
  <form id="BoiskoForm"  action="?page=LIVEAPP&Komentuj=1&ID=<?= $T->ID;?>" method="POST">   
    <input name="id" type="hidden" value="<?=$T->ID?>">
    <input name="zapiszMecz"  type="hidden" value="1">
    <input name="Judge"  type="hidden" value="{{Judge}}">
    <input name="SkladGosp" id="SkladGosp" type="hidden" value="{{GospPlayers}}">
    <input name="SkladGosc" id="SkladGosc" type="hidden" value="{{GoscPlayers}}">
    <input name="RezGosp" id="RezGosp" type="hidden"  value="{{GospRez}}">
    <input name="RezGosc" id="RezGosc" type="hidden"  value="{{GoscRez}}">
  
   <?if($T->Kategoria == "Skoki narciarskie") { //SKOKI ?>
   
    Kategoria: <select name="kategoria"><option value="<?= $T->Kategoria?>"><?=$T->Kategoria ?> (teraz)</option><option>Piłka nożna</option><option>Piłka ręczna</option><option>Siatkówka</option><option>Koszykówka</option><option>Tenis</option><option>Skoki narciarskie</option><option>Multirelacja</option><option>Losowanie</option><option>Inne</option></select>
     Gospodarz: <input list="kluby" type="text" value="<?= $T->Gosp?>" name="gosp"> 
    <?php if(!in_array($T->Kategoria,array('Losowanie','Multirelacja'))) { ?> 
     <input id="upload_image" type="hidden" size="36" name="upload_image_gosp" value="<?php echo $T->GospImg; ?>" /> 
		<input id="upload_image_button" class="button insert-media add_media" type="button" value="Wybierz grafikę" /> 
     <? } ?>
      <?php 
    $Stadion = json_decode(stripslashes_deep($T->Stadion));
    ?>
    <?      
$TUR = loadTurnieje(0,0,$T->Kategoria); 
$TURO = loadTur($T->Turniej); 
echo '  Turniej: <select name="tur">';
foreach($TURO as $TA) { echo '<option value="'.$TA->ID.'">'.$TA->Nazwa.' (Teraz)</option>'; }
echo '<option value="brak">Pojedyncze zawody</option>';
foreach($TUR as $To) echo '<option  value="'.$To->ID.'">'.$To->Nazwa.'</option>';
if($Stadion->Typ == '') $Stadion->Typ = 'Indywidualne';
echo '</select>     Rozgrywki: <input list="turnieje" value="'.$T->Rozgrywki.'" type="text" name="turniej">  ';    ?>
<br><br> 
<input id="upload_logo" type="hidden" size="36" name="upload_image_logo" value="<?php echo $Stadion->logo; ?>" /> 
		<input id="upload_logo_button" class="button insert-media add_media" type="button" value="Wybierz logo" /> 
  Typ: <select name="Typ"><option value="<?= $Stadion->Typ?>"><?=$Stadion->Typ?> (teraz)</option><option>Indywidualne</option><option>Drużynowe</option><option>TCS</option></select>
  Rozmiar skoczni: <input name="sRozmiar"  value="<?= $Stadion->Rozmiar?>" type="text">
  Skocznia: <input type="text" value="<?= $Stadion->name?>" name="sname">,  Miasto: <input type="text" value="<?= $Stadion->city?>" name="scity">
    <br><br>

Data: <input class="data" value="<?= substr($T->Data,0,10)?>" id="data" type="text" name="data">
    Godzina: <input  style="width:50px;" type="number" value="<?= substr($T->Data,11,2)?>" name="godzina">:<input value="<?= substr($T->Data,14,2)?>" style="width:50px;" type="number" name="minuta">
    Autor: <select name="autor">
<?php 
$blogusers = get_users( 'orderby=nicename' );
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
	echo '<option '.(($user->id == $T->Komentator) ? 'selected' : '').' value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . '</option>';
}
 ?>
</select> <br><br>
   
   
   <? } else { ?>
   
     Kategoria: <select name="kategoria"><option value="<?= $T->Kategoria?>"><?=$T->Kategoria ?> (teraz)</option><option>Piłka nożna</option><option>Piłka ręczna</option><option>Siatkówka</option><option>Koszykówka</option><option>Tenis</option><option>Skoki narciarskie</option><option>Multirelacja</option><option>Losowanie</option><option>Inne</option></select>
      <?php 
    $Stadion = json_decode(stripslashes_deep($T->Stadion));
    ?> 
    Rozgrywki: <input list="turnieje" value="<?= $T->Rozgrywki?>" type="text" name="turniej"> 
    <input id="upload_logo" type="hidden" size="36" name="upload_image_logo" value="<?php echo $Stadion->logo; ?>" /> 
		<input id="upload_logo_button" class="button insert-media add_media" type="button" value="Wybierz logo" /> 
    <? if($T->Kategoria != 'Skoki narciarskie' and $T->Kategoria != "Losowanie") { ?>  
    Faza: <input value="<?= $T->Faza?>" type="text" name="Faza">     
    Stadion: <input type="text" value="<?= $Stadion->name?>" name="sname">, <? }  else print 'Miasto: '?><input type="text" value="<?= $Stadion->city?>" name="scity">
    <? if($T->Kategoria == 'Skoki narciarskie') { ?> Rozmiar skoczni: <input name="sRozmiar"  value="<?= $Stadion->Rozmiar?>" type="text"> <? }?>
    <? if(!in_array($T->Kategoria,array('Losowanie','Multirelacja','Inne'))) { ?><br><br>Gospodarz: <input list="kluby" type="text" value="<?= $T->Gosp?>" name="gosp"> <input id="upload_image" type="hidden" size="36" name="upload_image_gosp" value="<?php echo $T->GospImg; ?>" />
    
        <?php if($T->Kategoria == "Tenis") { ?> 
              Kraj: <input id="upload_image" type="text" list="flags" name="upload_image_gosp" value="<?php echo $T->GospImg; ?>" />
         <? } ?> 
     
		 <? } else { ?>
    <input id="upload_image" type="hidden" size="36" name="upload_image_gosp" value="<?php echo $T->GospImg; ?>" /> 
     <input id="upload_image_button" class="button insert-media add_media" type="button" value="<?= ($T->Kategoria == "Inne") ? 'Wybierz zdjęcie' : 'Wybierz logo'?>" /> 
    <? } ?>
     <? if(in_array($T->Kategoria,array("Skoki narciarskie","Kolarstwo"))) { 
    
$TUR = loadTurnieje(0,0); 
$TURO = loadTur($T->Turniej); 
echo ' Impreza: <input name="sImpreza"  value="'.$Stadion->Impreza.'" type="text">  Turniej: <select name="tur">';
foreach($TURO as $TA) { echo '<option value="'.$TA->ID.'">'.$TA->Nazwa.' (Teraz)</option>'; }
echo '<option value="brak">Pojedyncze zawody</option>';
foreach($TUR as $To) echo '<option  value="'.$To->ID.'">'.$To->Nazwa.'</option>';
if($Stadion->Typ == '') $Stadion->Typ = 'Indywidualne';
echo '</select> Typ: <select name="Typ"><option>'.$Stadion->Typ.'</option><option>Indywidualne"</option><option>Drużynowe</option><option>TCS</option></select>';   
} ?>
     <?php if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Koszykówka',"Piłka ręczna"))) { ?> Kolor koszulki: <select name="KolorGosp"><option selected><?= $T->GospKolor ?></option><option>Bialy</option><option>Czerwony</option><option>Zielony</option><option>Zolty</option><option>Czarny</option><option>Niebieski</option><option>Pomaranczowy</option><option>Brazowy</option><option>Rozowy</option><option>Szary</option><option>Fioletowy</option></select> Trener: <input type="text" value="<?= $T->GospTrener?>" name="TrenerGosp">     <br><br> <? } ?>

    <?php if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Koszykówka',"Piłka ręczna","Tenis")) or $LSTYL == "default" and !in_array($T->Kategoria,array('Losowanie','Multirelacja','Inne'))) { ?>
    Gość: <input list="kluby" type="text" value="<?= $T->Gosc?>" name="gosc"> <input id="upload_image2" type="hidden" size="36" name="upload_image_gosc" value="<?php echo $T->GoscImg; ?>" />
                 
                 <?php if($T->Kategoria == "Tenis") { ?> 
              Kraj: <input id="upload_image" type="text" list="flags" name="upload_image_gosc" value="<?php echo $T->GoscImg; ?>" />
                 <? } ?> 
    
		<!--<input id="upload_image2_button" class="button insert-media add_media" type="button" value="Wybierz grafikę" />  -->
   <?php if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Koszykówka',"Piłka ręczna"))) { ?> 
     Kolor koszulki: <select name="KolorGosc"><option selected><?= $T->GoscKolor ?></option><option>Bialy</option><option>Czerwony</option><option>Zielony</option><option>Zolty</option><option>Czarny</option><option>Niebieski</option><option>Pomaranczowy</option><option>Brazowy</option><option>Rozowy</option><option>Szary</option><option>Fioletowy</option></select> Trener: <input type="text" value="<?= $T->GoscTrener?>" name="TrenerGosc"><? } } ?><br><br> 
Data: <input class="data" value="<?= substr($T->Data,0,10)?>" id="data" type="text" name="data">
    <? if($T->Kategoria == "Losowanie") { ?>
  Typ: <select name="Typ"><option value="<?= (($Stadion->Typ != "Grupowe") ? 'Pary' : 'Grupowe' )?>"><?= (($Stadion->Typ != "Grupowe") ? 'Pary' : 'Grupowe' )?> (teraz)</option><option><?= (($Stadion->Typ == "Grupowe") ? 'Pary' : 'Grupowe' )?></option></select>
    <? } ?>
    Godzina: <input  style="width:50px;" type="number" value="<?= substr($T->Data,11,2)?>" name="godzina">:<input value="<?= substr($T->Data,14,2)?>" style="width:50px;" type="number" name="minuta">
    Autor: <select name="autor">
<?php 
$blogusers = get_users( 'orderby=nicename' );
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
	echo '<option '.(($user->id == $T->Komentator) ? 'selected' : '').' value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . '</option>';
}
 ?>
</select> <br><br>  
<? } ?>

<?php if(in_array($T->Kategoria,array('Skoki narciarskie'))) { ?>

<? if($Stadion->Typ == "Drużynowe") { 

include_once('Admin/SkokiTeam.php');

 } else { ?>
<b>Lista startowa</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosc"> Poz: <input  type="number" style="width:50px" ng-model="Goscpoz">  Kraj:  <input type="text" list="flags" ng-model="Gosckraj"> <input type="button" class="button" ng-click="addGoscSkoczek()" value="Dodaj"><br><br> 
<div style="max-height:150px;width:1300px;overflow:auto;"><div ng-repeat="player in GoscPlayers | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz"  model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input type="text" list="flags"  value="{{ player.kraj }}" ng-model="player.kraj"> <a ng-click="removeGosc(player)">Usuń</a>
</div> 
</div>
<? } ?>


<?php } ?>

<?php if(in_array($T->Kategoria,array('Kolarstwo'))) { ?>

<b>Klasyfikacja</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosp"> <input type="button" class="button" ng-click="addGosp()" value="Dodaj"><br><br> 
<div ng-repeat="player in GospPlayers | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ $index+1 }}" ng-model="player.poz"> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input type="text" value="{{ player.kraj }}" ng-model="player.kraj">  Drużyna:  <input style="width:150px" type="text" value="{{ player.team }}" ng-model="player.team">  Czas:  <input style="width:150px" type="text" value="{{ player.czas }}" ng-model="player.czas"> <a ng-click="removeGosp(player)">Usuń</a>
</div>
<?php /*
<br>
<b>Lista startowa</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosc"> <input type="button" class="button" ng-click="addGosc()" value="Dodaj"><br><br> 
<div ng-repeat="player in GoscPlayers | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz"> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input type="text" value="{{ player.kraj }}" ng-model="player.kraj"> <a ng-click="removeGosc(player)">Usuń</a>
</div> */?>


<?php } ?>

<?php if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Koszykówka',"Piłka ręczna","Tenis"))) { ?>
<hr>
<h2><?= $T->Gosp?> vs <?= $T->Gosc?> <input type="number" name="PktGosp" style="width:70px;height:30px;font-size:12pt;text-align:center;" placeholder="0" value="<?=$T->PktGosp ?>">:<input type="number" name="PktGosc" style="width:70px;height:30px;font-size:12pt;text-align:center;" placeholder="0" value="<?=$T->PktGosc ?>"> <? if(in_array($T->Kategoria,array("Siatkówka","Koszykówka","Tenis"))) echo ''.$L->Set.': <input type="text" value="'.$Stadion->sset.'" style="width:200px;" name="sset">'; ?> <?= $L->ResInfo ?>: <input type="text" name="PodGol" style="width:200px;" placeholder="0" value="<?=$T->PodGol ?>">  <input class="button-primary" type="button" ng-click="prepareForm()" value="Zapisz"></h2> 
<? } else echo '<br><input class="button-primary" type="button" ng-click="prepareForm()" value="Zapisz">';?>
<?// if($T->Kategoria == 'Piłka nożna') echo 'Minuta: <input type="text" name="Min" style="width:100px;" placeholder="0" value="'.$T->Min.'"><br>';?>
<?php if(in_array($T->Kategoria,array('Piłka nożna'))) { ?>
<h2>Taktyka</h2>
<table><tr><td style="padding=right:30px;">
<div id="boisko" style="background:url('<?= plugins_url( 'img/'.$T->Kategoria.'.png', __FILE__ )?>')">
 <div ng-repeat="player in GospPlayers" type="Gosp" draggable='{ containment: "#boisko" }' class="player" ng-style="{ 'position': 'absolute', 'left': player.left, 'top': player.top }" id="">{{ player.name }}  </div>
 <div ng-repeat="player in GoscPlayers" type="Gosc" draggable='{ containment: "#boisko" }' class="player" ng-style="{  'position': 'absolute', 'left': player.left, 'top': player.top }" id="">{{ player.name }}</div>
</div>
</td><td>
<table><tr>
<td><b>Skład gospodarzy</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosp"> <input type="button" class="button" ng-click="addGosp()" value="Dodaj"><br><br> 
<div ng-repeat="player in GospPlayers">
    <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name"> <a ng-click="removeGosp(player)">Usuń</a>
</div>
</td>
<td><b>Skład gości</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosc"> <input type="button" class="button" ng-click="addGosc()" value="Dodaj"><br><br>  
<div ng-repeat="player in GoscPlayers">
    <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name">  <a ng-click="removeGosc(player)">Usuń</a>
</div>
</td>
</tr></table><br>
<table><tr><br>
<td><b>Rezerwowi gospodarzy</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajRezGosp"> <input type="button" class="button" ng-click="addRezGosp()" value="Dodaj"><br> <br> 
<div ng-repeat="player in GospRez">
     <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name"> <a ng-click="removeRezGosp($index)">Usuń</a>
</div>
</td>
<td><b>Rezerwowi gości</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajRezGosc"> <input type="button" class="button" ng-click="addRezGosc()" value="Dodaj"><br> <br>   
<div  ng-repeat="player in GoscRez">
    <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name"> <a ng-click="removeRezGosc($index)">Usuń</a>
</div>
</td>
</tr></table><br>
</td></tr></table>
<? } ?>

<?php if(in_array($T->Kategoria,array('Koszykówka','Siatkówka','Piłka ręczna'))) { ?>
<h2>Taktyka</h2>
<table><tr>
<td><b>Skład gospodarzy</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosp"> <input type="button" class="button" ng-click="addGosp()" value="Dodaj"><br><br> 
<div ng-repeat="player in GospPlayers">
    <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name">
       <? if($T->Kategoria == "Siatkówka") { ?>
       Kapitan: <input type="checkbox"  value="{{player.top}}" ng-model="player.top" ng-true-value="true" ng-false-value="false">  Libero: <input type="checkbox"  value="{{player.left}}" ng-model="player.left" ng-true-value="true" ng-false-value="false">
       <? } else if($T->Kategoria == "Piłka ręczna") { ?>
       Kapitan: <input type="checkbox"  value="{{player.top}}" ng-model="player.top" ng-true-value="true" ng-false-value="false">  Bramkarz: <input type="checkbox"  value="{{player.left}}" ng-model="player.left" ng-true-value="true" ng-false-value="false">
       <? } else { ?>
       Kapitan: <input type="checkbox"  value="{{player.kartki}}" ng-model="player.kartki" ng-true-value="true" ng-false-value="false">
       <? } ?>
      <a ng-click="removeGosp(player)">Usuń</a>
</div>
</td>
<td><b>Skład gości</b><br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosc"> <input type="button" class="button" ng-click="addGosc()" value="Dodaj"><br><br>  
<div ng-repeat="player in GoscPlayers">
    <input type="number" style="width:50px" value="{{ player.nr }}" ng-model="player.nr"> <input type="text" value="{{ player.name }}" ng-model="player.name">    <? if($T->Kategoria == "Siatkówka") { ?>
       Kapitan: <input type="checkbox"  value="{{player.top}}" ng-model="player.top" ng-true-value="true" ng-false-value="false">  Libero: <input type="checkbox"  value="{{player.left}}" ng-model="player.left" ng-true-value="true" ng-false-value="false">
       <? } else if($T->Kategoria == "Piłka ręczna") { ?>
       Kapitan: <input type="checkbox"  value="{{player.top}}" ng-model="player.top" ng-true-value="true" ng-false-value="false">  Bramkarz: <input type="checkbox"  value="{{player.left}}" ng-model="player.left" ng-true-value="true" ng-false-value="false">
       <? } else { ?>
       Kapitan: <input type="checkbox"  value="{{player.kartki}}" ng-model="player.kartki" ng-true-value="true" ng-false-value="false">
       <? } ?>
  <a ng-click="removeGosc(player)">Usuń</a>
</div>
</td>
</tr></table><br>

<? } ?>


</form>
<hr>  
<form id="WpisForm" action="?page=LIVEAPP&Komentuj=1&ID=<?= $T->ID;?>#dodajWpis" method="POST">
<a name="dodajWpis"></a>
<? if($T->Kategoria == 'Skoki narciarskie') { 
  include_once('Admin/SkokiManage.php');
 } ?>
 <? 
if($T->Kategoria == "Losowanie") { 

include_once('Admin/losowanie.php');

}
if($T->Kategoria == "Inne") { 

include_once('Admin/inne.php');

}
if($T->Kategoria == "Multirelacja") { 

include_once('Admin/Multirelacja.php');

}?>
<br>
<h2>Dodaj wpis <? if($T->Kategoria == "Skoki narciarskie"  or $T->Kategoria == "Losowanie" or $T->Kategoria == "Multirelacja") echo '<input class="button-primary" type="button" style="margin-left:10px;" ng-click="prepareWpisForm()" name="dodajWpis" value="Dodaj">';?></h2>
 <table><tr><td style="width:800px;padding-right:10px;">
 <?php if($T->Kategoria == 'OldTenis') { ?>
 Aktualny gem: <select name="PktGospTenis"><option>0</option><option>15</option><option>30</option><option>40</option><option>Ad</option></select> : <select name="PktGoscTenis"><option>0</option><option>15</option><option>30</option><option>40</option><option>Ad</option></select>
 <?php } ?>
 <?php if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna','Koszykówka')) or $LSTYL == "default") { ?> Minuta: <input type="text" style="width:100px;" value="<?= $T->Min?>" name="min"> 
 <? } ?>
 <? if(!in_array($T->Kategoria,array('Skoki narciarskie','Koszykówka','Losowanie'))) { ?><?= $L->Display_min ?>: <input type="text" style="width:100px;" name="dmin"> <? } ?>
 <? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) { echo '<div style="text-align:right;display:inline-block;width:250px;"><b>Rzut karny</b>: ';  echo '<input type="radio" name="RodzajWpisu" value="Gosp"> Gospodarz'; 
echo '<input type="radio" name="RodzajWpisu" value="Gosc"> Gość </div>'; } ?> 

<br>
<div style="line-height:200%;margin-top:2px;margin-bottom:5px;">Rodzaj wpisu: <input type="radio" checked name="RodzajWpisu" value="normal"> Normalny 
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Zmiana"> Zmiana'; ?> 
<? if($T->Kategoria == 'Koszykówka') echo '<input type="radio" name="RodzajWpisu" value="Dyskwalifikacja"> Dyskwalifikacja'; ?> 
<? if($T->Kategoria == 'Koszykówka') echo '<input type="radio" name="RodzajWpisu" value="RzutWolny"> Rzut wolny'; ?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Zolta"> Żółta kartka';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="Druga zolta"> Druga żółta';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Siatkówka','Piłka ręczna'))) echo '<input name="RodzajWpisu" type="radio" value="Czerwona"> Czerwona kartka';?> 
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna')))  echo '<input type="radio" name="RodzajWpisu" value="Gol"> Gol ';?>
<? if(in_array($T->Kategoria,array('Piłka nożna','Piłka ręczna'))) echo '<input type="radio" name="RodzajWpisu" value="karny"> Rzut karny ';?>
<? if(!in_array($T->Kategoria,array('Biegi narciarskie','Skoki narciarskie','Losowanie'))){  ?><input type="radio" name="RodzajWpisu" value="Foul"> Gwizdek  <? } ?>
 <input type="radio" name="RodzajWpisu" value="Special"> Wyróżnione 
<? if(!in_array($T->Kategoria,array('Skoki narciarskie','Losowanie','Multirelacja'))) echo '<input type="radio" name="RodzajWpisu" value="Kontuzja"> Kontuzja';?> 
<? if($T->Kategoria == 'Tenis') { echo '<input type="radio" name="RodzajWpisu" value="As"> As/Meczowa'; }?> 
<? if($T->Kategoria == 'Siatkówka') {  
echo '<input type="radio" name="RodzajWpisu" value="As"> As/Meczowa'; 
echo '<input type="radio" name="RodzajWpisu" value="GospSet"> Gospodarz ';
echo '<input type="radio" name="RodzajWpisu" value="GoscSet"> Gość'; 
} ?> 
<? if($T->Kategoria == 'Tenis') {  
echo '<input type="radio" name="RodzajWpisu" value="GemDlaGosp"> Gem dla '.$T->Gosp.' ';
echo '<input type="radio" name="RodzajWpisu" value="GemDlaGosc"> Gem dla '.$T->Gosc.' '; 
echo '<input type="radio" name="RodzajWpisu" value="SetDlaGosp"> Set dla '.$T->Gosp.' ';
echo '<input type="radio" name="RodzajWpisu" value="SetDlaGosc"> Set dla '.$T->Gosc.' '; 
echo '<input type="radio" name="RodzajWpisu" value="RozpocznijSet"> Rozpocznij set '; 
echo '<input type="radio" name="RodzajWpisu" value="Skrecz"> Krecz'; 
} ?> 
<? if($T->Kategoria == 'Skoki narciarskie') {  
echo '<input type="radio" name="RodzajWpisu" value="Dyskwalifikacja"> Dyskwalifikacja '; 
echo ' <input type="radio" name="RodzajWpisu" value="Kontuzja"> Kontuzja '; 
} ?> 
<? if(in_array($T->Kategoria,array('Siatkówka','Piłka ręczna','Koszykówka'))) echo '<input type="radio" name="RodzajWpisu" value="Time"> Czas';?> 
<? if(in_array($T->Kategoria,array('Skoki narciarskie'))) echo '<input type="radio" name="RodzajWpisu" value="TimeSkoki"> Początek/Koniec serii';?> 
<? if(in_array($T->Kategoria,array('Tenis'))) echo '<input type="radio" name="RodzajWpisu" value="Time"> Przerwa';?> 
<? if($T->Kategoria == 'Piłka ręczna') echo '<input type="radio" name="RodzajWpisu" value="Kara"> Kara'; ?> 
</div>
<? if(in_array($T->Kategoria,array('Piłka ręczna','Koszykówka'))) { ?>
Pkt gosp: <select name="strzelecGosp"><option></option><option>Gospodarz</option><option value="{{ p }}" ng-repeat="p in GospPlayers">{{ p.name }}</option>
</select> <? if($T->Kategoria == "Koszykówka") { echo ' za <select style="width:50px;" name="IlePktGosp"><option></option><option>1</option><option>2</option><option>3</option></select> pkt'; } ?>  
Pkt gosć: <select name="strzelecGosc"><option></option><option>Gość</option><option value="{{ p }}" ng-repeat="p in GoscPlayers">{{ p.name }}</option>
</select><? if($T->Kategoria == "Koszykówka") { echo ' za <select style="width:50px;" name="IlePktGosc"><option></option><option>1</option><option>2</option><option>3</option></select> pkt'; } ?> 
<br>
<hr>
<? } ?>
<? if($T->Kategoria == "Multirelacja") { echo 'Dodaj wynik: <select name="spotkanie"><option></option><option ng-repeat="player in GospPlayers | orderBy: \'typ\'" ng-show="player.typ == \'Piłka nożna\' || player.typ == \'Piłka ręczna\' || player.typ == \'Koszykówka\' || player.typ == \'Żużel\' || player.typ == \'Tenis\' || player.typ == \'Siatkówka\'"  value="{{player}}">{{player.typ}}: {{player.gosp}} vs {{player.gosc}}</option><option ng-repeat="player in GospPlayers | orderBy: \'typ\'" ng-show="player.typ == \'Kolarstwo\' || player.typ == \'Biegi narciarskie\' || player.typ == \'Skoki narciarskie\' || player.typ == \'Biathlon\' || player.typ == \'Łyżwiarstwo szybkie\'" value="{{player}}">{{player.typ}}: {{player.gosp}} vs {{player.gosc}}</option></select>'; } ?> 
 </td><td></td><tr><td style="width:800px;padding-right:10px;height:350px;padding-top:5px;">
Tekst:<br> <br>
<?php 
$settings = array(
'quicktags' => array('buttons' => 'em,strong,link',),
'text_area_name'=>'wpisEditor',//name you want for the textarea
'quicktags' => true,
'tinymce' => true,
'editor_class' => 'DodajWpisTextarea'
);
$id = 'wpis';//has to be lower case
wp_editor('',$id,$settings);?><br>
<? if($T->Kategoria != "Skoki narciarskie" and $T->Kategoria != "Losowanie") echo '<input class="button-primary" type="button"  ng-click="prepareWpisForm()" name="dodajWpis" value="Dodaj">';?>
<hr>
</td><td style="padding-top:30px;">
<? if(!in_array($T->Kategoria,array('Tenis','Skoki narciarskie','Koszykówka','Losowanie','Multirelacja')) and $LSTYL != "default") { ?>
<h3>Akcje</h3>
<? if($T->Kategoria == 'Piłka nożna') { ?>
<b><?= $L->Dodajstrzelca?>:</b> <br><br>
Gosp: <select name="strzelecGosp"><option value="{{ p }}" ng-repeat="p in GospPlayers">{{ p.name }}</option>
</select> <? if($T->Kategoria == "Piłka nożna") { ?> <input type="radio" name="BramkaGosp" value="GolSmall" checked> Zwykła <input type="radio" name="BramkaGosp" value="karny"> Karny <?php } ?> &nbsp;  <input class="button-primary" type="submit" name="AddPktGosp" value="Dodaj"><br><br>
Gość: <select name="strzelecGosc"><option value="{{ p }}" ng-repeat="p in GoscPlayers">{{ p.name }}</option>
</select><? if($T->Kategoria == "Piłka nożna") { ?> <input type="radio" name="BramkaGosc" value="GolSmall" checked> Zwykła <input type="radio" name="BramkaGosc" value="karny"> Karny<?php } ?> &nbsp; <input class="button-primary" type="submit" name="AddPktGosc" value="Dodaj">
<br>   
<hr>
<? } ?>
<b><?= $L->Ukarzzawodnika?></b> <br><br>
Gosp: <select name="ukaranyGosp"><option value="{{ p }}" ng-repeat="p in GospPlayers">{{ p.name }}</option>
</select> Kara: <select style="width:100px" name="GospKara"><? if(in_array($T->Kategoria,array('Piłka nożna', 'Siatkówka', 'Piłka ręczna'))) { ?><option>Zolta</option><option>Czerwona</option><option value="Druga zolta">Druga zolta</option> <? } ?><? if($T->Kategoria == "Koszykówka") { ?><option>Dyskwalifikacja</option> <? } ?></select>&nbsp;  <input class="button-primary" type="submit" name="KarzGosp" value="Ukarz"> <br><br>
Gość: <select name="ukaranyGosc"><option value="{{ p }}" ng-repeat="p in GoscPlayers">{{ p.name }}</option>
</select> Kara: <select style="width:100px" name="GoscKara"><? if(in_array($T->Kategoria,array('Piłka nożna', 'Siatkówka', 'Piłka ręczna'))) { ?><option>Zolta</option><option>Czerwona</option><option value="Druga zolta">Druga zolta</option> <? } ?><? if($T->Kategoria == "Koszykówka") { ?><option>Dyskwalifikacja</option> <? } ?></select>&nbsp;  <input class="button-primary" type="submit" name="KarzGosc" value="Ukarz">
<hr>

<? if(!in_array($T->Kategoria,array('Siatkówka','Piłka ręczna'))) { ?>
<b><?= $L->WprowadzZmiane?>:</b> <br><br>
Gosp: <select name="ZmienGosp">
<option value="{{ p }}" ng-repeat="p in GospRez">{{ p.name }}</option>
</select> za <select name="DoZmianyGosp">
<option value="{{ p }}" ng-repeat="p in GospPlayers">{{ p.name }}</option>
</select>&nbsp;  <input class="button-primary" type="submit" name="ChangeGosp" value="Zmien"> <br><br>
Gość: <select name="ZmienGosc">                                                                              
<option value="{{ p }}" ng-repeat="p in GoscRez">{{ p.name }}</option>
</select> za <select name="DoZmianyGosc">
<option value="{{ p }}" ng-repeat="p in GoscPlayers">{{ p.name }}</option>
</select>&nbsp;  <input class="button-primary" type="submit" name="ChangeGosc" value="Zmien">
<hr>
<? } ?>
<? if(in_array($T->Kategoria,array('Piłka nożna', 'Koszykówka', "Tenis"))) { ?>
<b>Ustaw status:</b> <br><br>
Status: <select name="MeczStatus"><option value="<?= stripslashes_deep($T->Stat) ?>" selected><?= stripslashes_deep($T->Stat) ?> (teraz)</option><option>trwa</option><option>Nie rozpoczęto</option><option>Mecz przerwany</option><option>Przerwa</option><option>Koniec</option></select>&nbsp;  <input class="button-primary" type="submit" name="ChangeStatus" value="Dodaj">
<br>   
<hr>
<? } } ?>

<? if($T->Kategoria == "Skoki narciarskie") { ?>
<h3>Akcje</h3>
Status: <select name="MeczStatus"> 
<option value="<?= stripslashes_deep($T->Stat) ?>" selected><?= stripslashes_deep($T->Stat) ?> (teraz)</option>
<option>Początek pierwszej serii</option>
<option>Koniec pierwszej serii</option>
<option>Początek drugiej serii</option>
<option>Koniec drugiej serii</option> 
<option>Zawody przerwane</option> 
</select>
 <input class="button-primary" type="submit" name="ChangeStatus" value="Dodaj">
<? } ?>
</td></tr></table>

</form>

<br>
<? if(!in_array($T->Kategoria,array('Tenis','Skoki narciarskie','Koszykówka','Losowanie','Multirelacja')) and $LSTYL != "default") { ?><a onClick="(jQuery('#RestForm').css('display') == 'none') ? jQuery('#RestForm').fadeIn() : jQuery('#RestForm').fadeOut()">Pokaż/ukryj resztę</a><? } ?>
<form id="RestForm" style="display:none" action="?page=LIVEAPP&Komentuj=1&ID=<?= $T->ID;?>" method="POST"> 
 <input name="id" type="hidden" value="<?=$T->ID?>">
<input name="zapiszRest"  type="hidden" value="1">
  <input name="Judge" id="Judge" type="hidden" value="{{Judge}}">
    <input name="SkladGosp" type="hidden" value="{{GospPlayers}}">
    <input name="SkladGosc" type="hidden" value="{{GoscPlayers}}">
    <input name="RezGosp" type="hidden" value="{{GospRez}}">
    <input name="RezGosc" type="hidden" value="{{GoscRez}}">
    <input name="GoleGosp" id="GoleGosp" type="hidden" value="<?=stripslashes_deep($T->StGosp) ?>">
    <input name="GoleGosc" id="GoleGosc" type="hidden" value="<?=stripslashes_deep($T->StGosc) ?>">
    <input name="KaryGosp" id="KaryGosp" type="hidden" value="<?=stripslashes_deep($T->KaryGosp) ?>">
    <input name="KaryGosc" id="KaryGosc" type="hidden" value="<?=stripslashes_deep($T->KaryGosc) ?>">  
<? if(in_array($T->Kategoria,array('Piłka nożna','Koszykówka'))) { ?>
<h3><?= $L->Boisko?></h3>
<i>Gole</i><br><br>
<table><tr>
<td><b>Gospodarz</b><br><br>
<div ng-repeat="player in GospPlayers" ng-show="player.Gole != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">Gole: <input type="text" value="{{ player.Gole }}" style="width:150px;" ng-model="player.Gole" disabled> <br><a ng-click="removeGoleGosp($index)">Kasuj gola</a>
</div>
<div ng-repeat="player in GospRez" ng-show="player.Gole != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">Gole: <input type="text" value="{{ player.Gole }}" style="width:150px;" ng-model="player.Gole" disabled> <br><a ng-click="removeGoleGosp($index)">Kasuj gola</a>
</div>
</td>
<td><b>Gość</b><br><br>
<div ng-repeat="player in GoscPlayers" ng-show="player.Gole != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name"> Gole: <input type="text" value="{{ player.Gole }}" style="width:150px;" ng-model="player.Gole" disabled><br><a ng-click="removeGoleGosc($index)">Kasuj gola</a>
</div>
<div ng-repeat="player in GoscRez" ng-show="player.Gole != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">Gole: <input type="text" value="{{ player.Gole }}" style="width:150px;" ng-model="player.Gole" disabled> <br><a ng-click="removeGoleGosp($index)">Kasuj gola</a>
</div>
</td>
</tr></table><br>
<i>Kartki</i><br><br>
<table><tr>
<td><b>Gospodarz</b><br><br>
<div ng-repeat="player in GospPlayers" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name"> Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled> <br><a ng-click="removeKaryGosp($index)">Kasuj karę</a>
</div>
<div ng-repeat="player in GospRez" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name"> Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled> <br><a ng-click="removeKaryGosp($index)">Kasuj karę</a>
</div>
</td>
<td><b>Gosć</b><br><br>
<div ng-repeat="player in GoscPlayers" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">  Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled><br><a ng-click="removeKaryGosc($index)">Kasuj karę</a>
</div>
<div ng-repeat="player in GoscRez" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">  Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled><br><a ng-click="removeKaryGosc($index)">Kasuj karę</a>
</div>
</td>
</tr></table><br>
<hr>
<h3>Statystyki</h3>
<? if($T->Kategoria == "Piłka nożna") {?>
<i>Gole</i><br><br>
<table><tr>
<td><b>Gospodarz</b><br><br>
<div ng-repeat="player in GospGole">
     <input type="text" value="{{ player.strzelec }}" ng-model="player.strzelec"> <br> <a ng-click="removeGolGosp($index)">Usuń gola</a>
</div>
</td>
<td><b>Gość</b><br><br>
<div ng-repeat="player in GoscGole">
     <input type="text" value="{{ player.strzelec }}" ng-model="player.strzelec"> <br><a ng-click="removeGolGosc($index)">Usuń gola</a>
</div>
</td>
</tr></table><br>
<? } ?>
<i>Kartki</i><br><br>
<table><tr>
<td><b>Gospodarz</b><br><br>
<div ng-repeat="player in GospKary">
     <input type="text" value="{{ player.ukarany }}" ng-model="player.ukarany"> Kara: <input type="text" value="{{ player.kara }}" style="width:150px;  ng-model="player.kartki" disabled> <br> <a ng-click="removeKaraGosp($index)">Usuń karę</a>
</div> 
 
</td>
<td><b>Gość</b><br><br>
<div ng-repeat="player in GoscKary">
     <input type="text" value="{{ player.ukarany }}" ng-model="player.ukarany"> Kara: <input type="text" value="{{ player.kara }}" style="width:150px;  ng-model="player.kartki" disabled><br> <a ng-click="removeKaraGosc($index)">Usuń karę</a>
</div>  
</td>
</tr></table><br>
<?  } ?>

<? if(in_array($T->Kategoria,array('Siatkówka','Piłka ręczna'))) { ?>
<br>
<i>Kartki</i><br><br>
<table><tr>
<td><b>Gospodarz</b><br><br>
<div ng-repeat="player in GospPlayers" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name"> Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled> <br><a ng-click="removeKaryGosp($index)">Kasuj karę</a>
</div>
<div ng-repeat="player in GospRez" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name"> Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled> <br><a ng-click="removeKaryGosp($index)">Kasuj karę</a>
</div>
</td>
<td><b>Gosć</b><br><br>
<div ng-repeat="player in GoscPlayers" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">  Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled><br><a ng-click="removeKaryGosc($index)">Kasuj karę</a>
</div>
<div ng-repeat="player in GoscRez" ng-show="player.kartki != 'not'">
<input type="text" value="{{ player.name }}" ng-model="player.name">  Kara: <input type="text" value="{{ player.kartki }}" style="width:150px;  ng-model="player.kartki" disabled><br><a ng-click="removeKaryGosc($index)">Kasuj karę</a>
</div>
</td>
</tr></table><br>
<? } ?>



<input class="button-primary" type="button" ng-Click="prepareFormSec()" value="Zapisz">
<hr> 

<datalist id="kluby">
<?php 
 $KLUBY = LoadKluby('Gosp');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Gosp.'">';
  }
  }
  $KLUBY = LoadKluby('Gosc');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Gosc.'">';
  }
  }
 ?>
</datalist>
<datalist id="flags">
<?php 
 $dir    = '../wp-content/plugins/LiveApp/admin/img/Flags';
$files = scandir($dir);
foreach($files as $file) {
if($file != '.' and $file != '..') print '<option>'.str_replace('.png','',$file).'</option>';
}                     
 ?>                   
</datalist>
<datalist id="turnieje">
<?php 
 $KLUBY = LoadKluby('Rozgrywki');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Rozgrwyki.'">';
  }
  }
 ?>
 
</datalist>
</form> 

<h2>Wszystkie wpisy</h2>
<div class="wpisy adminWpisy" style="height:600px;width:850px;overflow:auto;">
<?php 
  $KWESTIE = LoadWpisy($_GET['ID']);
     
  if(count($KWESTIE) > 0) { $i=0;
  foreach($KWESTIE as $K) {  $i++;
  echo '<div class="wpis '.$K->Rodzaj.'" id="wpis'.$K->ID.'"><form action="?page=LIVEAPP&Komentuj=1&ID='.$T->ID.'" method="POST">';
  if($T->Kategoria != 'Skoki narciarskie' and $T->Kategoria != "Losowanie" and $K->Min_display != 'NULL'){  echo '<b class="min">'.(($K->Min_display != "") ? $K->Min_display : $K->Min.'\'').'</b>'; }
  print '<input type="hidden" name="min" value="'.$K->Min.'"><input type="hidden" name="dmin" value="'.$K->Min_display.'"><input type="hidden" name="rodzaj" value="'.$K->Rodzaj.'"><input type="hidden" name="WpisID" value="'.$K->ID.'"><input type="hidden" name="pozycja" value="'.$i.'">'; 
  if($K->Rodzaj != 'normal' and $K->Rodzaj != "Gosp" and $K->Rodzaj!= 'Gosc' and $K->Rodzaj!= 'GoscSet' and $K->Rodzaj!= 'GospSet'   ) echo '<img class="Live_Icon" src="'.plugins_url( 'img/'.$K->Rodzaj.'.png', __FILE__ ).'" alt=""> '; 
  if($K->Rodzaj == "Gosp" or $K->Rodzaj == "GospSet" ) echo '<img class="Live_Icon" src="'.$T->GospImg.'" alt=""> '; 
  if($K->Rodzaj == "Gosc" or $K->Rodzaj == "GoscSet" ) echo '<img class="Live_Icon" src="'.$T->GoscImg.'" alt=""> ';      
  echo '<span class="text">';
  echo stripslashes_deep($K->Text);?>
  </span>
  <br><br><hr>
   <input class="button-primary" type="button" onClick="EditWpis('<?= $K->ID?>')" name="usunWpis" value="Edytuj"> <input class="button" type="button" onClick="jQuery.ajax('?page=LIVEAPP&deleteWpis=1&ID=<?=$K->ID?>');jQuery('#wpis<?=$K->ID?>').fadeOut()" name="usunWpis" value="Usuń">  <input class="button" type="submit" name="DoGory" value="Do góry"> <input class="button" type="submit" name="NaDol" value="Na dół">  
  </form></div><hr>
  <?php
  }  
  print "</div>"; 
  } else print "Brak wpisów";
  ?>
 <?php } else echo '<div class="error"><h3>Transmisja nie istnieje!</h3></div><br/>';  
 print '</div>';
 
 } else if(isset($_GET['Turnieje'])) {
  require_once('turnieje.php');
 } else { ?>
 
<script language="JavaScript">
jQuery(document).ready(function() {
jQuery('#upload_image_button, #upload_image2_button').click(function() {
if(jQuery(this).attr('id') == "upload_image_button") { img = '#upload_image'; formfield = jQuery('#upload_image').attr('name'); } else { img = '#upload_image2';  formfield = jQuery('#upload_image2').attr('name'); }
tb_show('', 'media-upload.php?type=image&TB_iframe=true');
return false;
});

window.send_to_editor = function(html) {
imgurl = jQuery('img',html).attr('src');
jQuery(img).val(imgurl);
tb_remove();
}

});
</script>
  
  <form action="?page=LIVEAPP" method="POST">
    Gospodarz: <input list="kluby" type="text" name="gosp">
		<input id="upload_image" type="hidden" size="36" name="upload_image_gosp" value="<?php echo $gearimage; ?>" />
		<input id="upload_image_button" class="button insert-media add_media" type="button" value="Wybierz grafikę" /><br><br>
    Gość: <input list="kluby" type="text" name="gosc"> 
    		<input id="upload_image2" type="hidden" size="36" name="upload_image_gosc" value="<?php echo $gearimage; ?>" />
		<input id="upload_image2_button" class="button insert-media add_media" type="button" value="Wybierz grafikę" />
    <br> <br>
    Kategoria: <select name="kategoria"><option>Piłka nożna</option><option>Piłka ręczna</option><option>Siatkówka</option><option>Koszykówka</option><option>Tenis</option><option>Skoki narciarskie</option><option>Multirelacja</option><option>Losowanie</option><option>Inne</option></select>
    Rozgrywki: <input list="turnieje" type="text" name="turniej">
    Data: <input class="data" value="<?= date('Y-m-d')?>" id="data" type="text" name="data">
    Godzina: <input  style="width:50px;" type="number" value="<?= date('H')?>" name="godzina">:<input value="<?= date('i')?>" style="width:50px;" type="number" name="minuta">
    Autor: <select name="autor">
<?php 
$blogusers = get_users( 'orderby=nicename' );
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
	echo '<option value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . '</option>';
}
 ?>
</select> 
    <input class="button-primary" type="submit" name="dodajMecz" value="Dodaj">
    
<datalist id="kluby">
<?php 
 $KLUBY = LoadKluby('Gosp');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Gosp.'">';
  }
  }
  $KLUBY = LoadKluby('Gosc');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Gosc.'">';
  }
  }
 ?>
</datalist>
<datalist id="turnieje">
<?php 
 $KLUBY = LoadKluby('Rozgrywki');
     
  if(count($KLUBY) > 0) {
  foreach($KLUBY as $K) {
  echo '<option value="'.$K->Rozgrwyki.'">';
  }
  }
 ?>
</datalist>
  </form>
  <hr>
  
  <table class="wp-list-table widefat fixed striped users">
	<thead>
		<tr>
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Wybierz wszystko</label><input type="checkbox" id="cb-select-all-1"></th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Gospodarz</th><th style="" class="manage-column column-name sortable desc" id="name" scope="col">Gość</th><th style="" class="manage-column column-role" id="role" scope="col">Kategoria/Turniej</th><th style="" class="manage-column column-role" id="role" scope="col">Data</th><th style="" class="manage-column column-role" id="posts" scope="col">Działania</th>
    </tr>
	</thead>

	<tbody data-wp-lists="list:user" id="the-list">
	
  <?php 
 
  if(!$_GET['Apage']) $page=1; else $page = $_GET['Apage'];
  $ILE = 20;
  $OD = ($page-1)*$ILE;
  $MECZE = LoadData($OD, $ILE, 'all');
     
  if(count($MECZE) > 0) {
  foreach($MECZE as $M) {
  echo '<tr id="mecz'.$M->ID.'"><td><input type="checkbox" value="1" class="administrator" id="user_1" name="users[]"></td><td>'.$M->Gosp.' </td> <td> '.$M->Gosc.'</td><td>'.$M->Kategoria.'/'.$M->Rozgrywki.'</td><td> '.$M->Data.'</td><td> <button class="button" onClick="jQuery.ajax(\'?page=LIVEAPP&deleteMecz=1&ID='.$M->ID.'\');jQuery(\'#mecz'.$M->ID.'\').fadeOut()">Usuń</button> '.(($M->Status == 0) ? '<button class="button" onClick=\'window.location="?page=LIVEAPP&WlaczSpotkanie=1&ID='.$M->ID.'"\'>Włącz</button>' : '<button class="button" onClick=\'window.location="?page=LIVEAPP&WylaczSpotkanie=1&ID='.$M->ID.'"\'>Wyłącz</button>');
  
  echo (($M->Status == 2) ? ' <button class="button" onClick=\'window.location="?page=LIVEAPP&WylaczNaZywo=1&ID='.$M->ID.'"\'>Na żywo off </button>' : ' <button class="button" onClick=\'window.location="?page=LIVEAPP&WlaczNaZywo=1&ID='.$M->ID.'"\'>Włącz na żywo</button>');
  
  echo ' <button class="button" onClick="jQuery(\'#mecz'.$M->ID.', .Mecz_edit\').fadeOut(\'slow\',function(){jQuery(\'#mecz'.$M->ID.'EDIT\').delay(600).fadeIn();})">Edytuj</button><button class="button-primary" onClick=\'window.location="?page=LIVEAPP&Komentuj=1&ID='.$M->ID.'"\'>Komentuj</button></td></tr>';
   echo '<form method="POST"><tr id="mecz'.$M->ID.'EDIT" style="display:none" class="Mecz_edit"><input type="hidden" name="ZmienId" value="'.$M->ID.'"><td><input type="checkbox" value="1" class="administrator" id="user_1" name="users[]"></td><td><input type="text" name="gosp" value="'.$M->Gosp.'"> </td> <td><input type="text" name="gosc" value="'.$M->Gosc.'"></td><td><select name="kategoria"><option value="'.$M->Kategoria.'">'.$M->Kategoria.' (teraz)</option><option>Piłka nożna</option><option>Piłka ręczna</option><option>Siatkówka</option><option>Koszykówka</option><option>Tenis</option><option>Skoki narciarskie</option><option>Multirelacja</option><option>Losowanie</option><option>Inne</option></select><input type="text" name="turniej" value="'.$M->Rozgrywki.'"></td><td><input type="text" name="data" value="'.$M->Data.'"></td><td> <button class="button-primary" type="submit">Zapisz</button> <input type="button" class="button" onClick="jQuery(\'.Mecz_edit\').fadeOut(\'slow\',function(){jQuery(\'#mecz'.$M->ID.'\').delay(600).fadeIn();})" value="Anuluj"></td></tr></form>';
  } 
  
  } else print "<tr><td></td><td>Brak spotkań</td><td></td><td></td><td></td><td></td></tr>";
  ?>
  
  </tbody>

	<tfoot>
   				<tr>
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Wybierz wszystko</label><input type="checkbox" id="cb-select-all-1"></th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Gospodarz</th><th style="" class="manage-column column-name sortable desc" id="name" scope="col">Gość</th><th style="" class="manage-column column-role" id="role" scope="col">Kategoria/Turniej</th><th style="" class="manage-column column-role" id="role" scope="col">Data</th><th style="" class="manage-column column-role" id="posts" scope="col">Działania</th>
    </tr>	</tfoot>
          
</table>
<br>
Działania<br><br>
 <button onClick="window.location='?page=LIVEAPP&CzyscMecze=All'" class="button">Usuń wszystkie</button>  <button  onClick="window.location='?page=LIVEAPP&CzyscMecze=Zakonczone'" class="button">Usuń zakończone</button>
 
 <hr>
<?php $count = numData(); 
$Apage = 0;
if((($count-$ILE)/$ILE) > 0)  {
while(($count/$ILE) > 0) { $Apage++; $count = $count - $ILE; echo ' <a class="button'.(($Apage == $page) ? '-primary' : '').'" href="?page=LIVEAPP&Apage='.$Apage.'.html">'.$Apage.'</a>';  }
}
?>
 
  <?php
  }
  
  

 }


?>
