<?php 
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
  
if($_GET['turnieje'] == "") {
if(isset($_GET['TID'])) {

$TURO = loadTur($_GET['TID']); 
foreach($TURO as $T) {
?>
<style type="text/css">
#footer-thankyou {
display:none;
}
</style>
<div ng-app="MyApp" ng-controller="mainController">
<script language="JavaScript">
                                       

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



$scope.Sortuj = function (NewPoz, NewName) {
angular.forEach($scope.Player, function(item) {
   if((item.poz >= NewPoz) & (item.name != NewName)) { item.poz++; console.log(item.name+'withNew'+item.poz);}
  //$scope.$apply();
});
}

$scope.DoGory = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.Player, function(item) {
   if(item.name == NewName) { item.poz = NewPoz;}
   if((item.poz == NewPoz) & (item.name != NewName)) { item.poz++;}
  //$scope.$apply();
});
}


$scope.NaDol = function (OldPoz,NewPoz, NewName) {
angular.forEach($scope.Player, function(item) {
   if(item.name == NewName) { item.poz = NewPoz;}
   if((item.poz == NewPoz) & (item.name != NewName)) { item.poz--;}
  //$scope.$apply();
});
}

$scope.Player = <?= ($T->Sklad != "") ? stripslashes_deep($T->Sklad) : '[]'?>;
$scope.Gosppoz = $scope.Player.length+1;
$scope.addPlayer = function () {
    $scope.Player.push({
        name: $scope.DodajPlayer,
        poz: $scope.Gosppoz,
        kraj: $scope.Gospkraj,
        punkty: $scope.Gosppkty,
        first:  $scope.Gospstrata,
        kraj:  $scope.Gospkraj
    });
    
    $scope.Sortuj($scope.Gosppoz,  $scope.DodajPlayer);
    
    $scope.DodajPlayer = "";
    $scope.Gospkraj = "";
    $scope.Gosppkty = "";
    $scope.Gospstrata = "";
    $scope.Gosppoz = $scope.Player.length+1;
    $scope.Gospkraj = "";
};



 $scope.removePlayer = function(item){
    $scope.Player.splice($scope.Player.indexOf(item), 1);
  }





// This makes any element draggable

});


</script>
 
  <form action="?page=LIVEAPP&Turnieje&TID=<?=$_GET['TID']?>" method="POST">
  
  <h2><?= $T->Nazwa?></h2>
  <b>Klasyfikacja generalna</b><br><br>
  
  <? if($T->Typ == "Drużynowe") { ?>
  Dodaj drużynę: <input type="text" ng-model="DodajPlayer"> Pozycja: <input type="number" style="width:50px" ng-model="Gosppoz"> Punkty:  <input type="number"  ng-model="Gosppkty">  Strata: <input type="number"  ng-model="Gospstrata">  <input type="button" class="button" ng-click="addPlayer()" value="Dodaj"><br><br> 
<div ng-repeat="player in Player | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur>  Drużyna:  <input type="text" value="{{ player.name }}" ng-model="player.kraj">  Punkty:  <input type="number" style="width:70px" value="{{ player.punkty }}" ng-model="player.punkty"> Strata:  <input style="width:150px" type="text" value="{{ player.first }}" ng-model="player.first"> <a ng-click="removePlayer(player)">Usuń</a> <a ng-click="DoGory(player.poz,player.poz-1,player.name)">Do góry</a> <a ng-click="NaDol(player.poz,player.poz+1,player.name)">Na dół</a>
</div>  
<? } else { ?>
 Dodaj zawodnika: <input type="text" ng-model="DodajPlayer"> Pozycja: <input type="number" style="width:50px" ng-model="Gosppoz"> Kraj: <input list="flags" type="number" ng-model="Gospkraj"> Punkty:  <input type="number"  ng-model="Gosppkty">  Strata: <input type="number"  ng-model="Gospstrata"> <input type="button" class="button" ng-click="addPlayer()" value="Dodaj"><br><br> 
<div ng-repeat="player in Player | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input type="text" value="{{ player.kraj }}" ng-model="player.kraj"> Strata:  <input style="width:150px" type="text" value="{{ player.first }}" ng-model="player.first"> Punkty:  <input type="number" style="width:70px" value="{{ player.punkty }}" ng-model="player.punkty"> <a ng-click="removePlayer($index)">Usuń</a>
</div>  
<? } ?>
<input type="hidden" name="Sklad" value="{{Player}}">   <br>
  <input class="button-primary" type="submit" name="ZapiszTur" value="Zapisz">
  
  <datalist id="flags">
<?php 
 $dir    = '../wp-content/plugins/LiveApp/admin/img/Flags';
$files = scandir($dir);
foreach($files as $file) {
if($file != '.' and $file != '..') print '<option>'.str_replace('.png','',$file).'</option>';
}                     
 ?>                   
</datalist>
  
  </form>
  </div>
<?php

}
?>


<?php
}else {
?> 

<div ng-app="MyApp" ng-controller="mainController">
<script language="JavaScript">


                                          

var app = angular.module("MyApp", []);

app.controller("mainController", function ($scope) {

$scope.GospPlayers = [];
$scope.addGosp = function () {
    $scope.GospPlayers.push({
        name: $scope.DodajGosp,
        kraj: 'Polska',
    });
    

    $scope.DodajGosp = "";
  
};



 $scope.removeGosp = function(index){
    $scope.GospPlayers.splice(index, 1);
  }





// This makes any element draggable

});


</script>

  
  <form action="?page=LIVEAPP&Turnieje&DodajTurniej" method="POST">
   <input type="hidden" name="Sklad" value="{{GospPlayers}}">
    Nazwa turnieju: <input type="text" name="Nazwa"> <br><br>
    Kategoria: <select name="kategoria"><option>Żużel</option><option>Kolarstwo</option><option>Skoki narciarskie</option><option>Biathlon</option><option>Biegi narciarskie</option> <option>Łyżwiarstwo szybkie</option><option>Multirelacja</option></select>
    Typ: <select name="typ"><option>Drużynowe</option><option>Indywidualne</option><option>TCS</option></select><br><br>
    Dodaj zawodnika: <input type="text" ng-model="DodajGosp"> <input type="button" class="button" ng-click="addGosp()" value="Dodaj"><br><br> 
<div ng-repeat="player in GospPlayers">
   <input type="text" value="{{ player.name }}" ng-model="player.name"> <input type="text" value="{{ player.kraj }}" ng-model="player.kraj">
   <a ng-click="removeGosp($index)">Usuń</a>
</div>
 <br><br>
    <input class="button-primary" type="submit" name="dodajTurniej" value="Dodaj">
  </form>
  <hr>
  
  <table class="wp-list-table widefat fixed striped users">
	<thead>
		<tr>
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Wybierz wszystko</label><input type="checkbox" id="cb-select-all-1"></th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Turniej</th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Kategoria/Typ</th><th style="" class="manage-column column-role" id="posts" scope="col">Działania</th>
    </tr>
	</thead>

	<tbody data-wp-lists="list:user" id="the-list">
	
  <?php 
 
  if(!$_GET['Apage']) $page=1; else $page = $_GET['Apage'];
  $ILE = 20;
  $OD = ($page-1)*$ILE;
  $MECZE = LoadTurnieje($OD, $ILE);
     
  if(count($MECZE) > 0) {
  foreach($MECZE as $M) {
  echo '<tr id="mecz'.$M->ID.'"><td><input type="checkbox" value="1" class="administrator" id="user_1" name="users[]"></td><td>'.$M->Nazwa.' </td><td>'.$M->Kategoria.'/'.$M->Typ.' </td><td> <button class="button" onClick="jQuery.ajax(\'?page=LIVEAPP&deleteTurniej=1&ID='.$M->ID.'\');jQuery(\'#mecz'.$M->ID.'\').fadeOut()">Usuń</button> <button class="button" onClick="jQuery(\'#mecz'.$M->ID.', .Mecz_edit\').fadeOut(\'slow\',function(){jQuery(\'#mecz'.$M->ID.'EDIT\').delay(600).fadeIn();})">Szybka edycja</button> <button class="button-primary" onClick=\'window.location="?page=LIVEAPP&Turnieje&TID='.$M->ID.'"\'>Edytuj</button></td></tr>';
   echo '<form method="POST" action="?page=LIVEAPP&Turnieje&DodajTurniej"><tr id="mecz'.$M->ID.'EDIT" style="display:none" class="Mecz_edit"><input type="hidden" name="ZmienTur" value="'.$M->ID.'"><td><input type="checkbox" value="1" class="administrator" id="user_1" name="users[]"></td><td><input type="text" name="Nazwa" value="'.$M->Nazwa.'"> </td><td><select name="kategoria"><option value="'.$M->Kategoria.'">'.$M->Kategoria.' (teraz)</option><option>Żużel</option><option>Kolarstwo</option><option>Skoki narciarskie</option><option>Biathlon</option><option>Biegi narciarskie</option> <option>Łyżwiarstwo szybkie</option><option>Multirelacja</option></select>/<select name="typ"><option value="'.$M->Typ.'">'.$M->Typ.' (teraz)</option><option>Drużynowe</option><option>Indywidualne</option><option>TCS</option></select></td><td> <button class="button-primary" type="submit">Zapisz</button> <input type="button" class="button" onClick="jQuery(\'.Mecz_edit\').fadeOut(\'slow\',function(){jQuery(\'#mecz'.$M->ID.'\').delay(600).fadeIn();})" value="Anuluj"></td></tr></form>';
  } 
  
  } else print "<tr><td></td><td>Brak spotkań</td><td></td></tr>";
  ?>
  
  </tbody>

	<tfoot>
   				<tr>
				<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Wybierz wszystko</label><input type="checkbox" id="cb-select-all-1"></th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Turniej</th><th style="" class="manage-column column-username sortable desc" id="username" scope="col">Kategoria/Typ</th><th style="" class="manage-column column-role" id="posts" scope="col">Działania</th>
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

}
}
?>
</div>