<h3>Wybierz turniej</h3>
<form method="POST" action="?page=LIVEAPP&Komentuj=1&ID=<?=$_GET['ID']?>">
<?php 
if(isset($_GET['TurID'])) {
$TUR = loadTurnieje(0,0); 
$TURO = loadTur($_GET['TurID']); 
echo '<select disabled>';
if($_GET['TurID'] == "") { $TURO[0] = new stdClass; $TURO[0]->ID = 'brak'; $TURO[0]->Nazwa = "Pojedyncze zawody"; }
foreach($TURO as $T) { echo '<option value="'.$T->ID.'">'.$T->Nazwa.'</option>';
echo '<option value="brak">Pojedyncze zawody</option>';
foreach($TUR as $To) echo '<option onClick="window.location=\'admin.php?page=LIVEAPP&Komentuj=1&ID='.$_GET['ID'].'&TurID='.$To->ID.'\'" value="'.$To->ID.'">'.$To->Nazwa.'</option>';
echo '</select><input type="hidden" name="Turniej" value="'.$T->ID.'">';
?>
<div ng-app="MyGracz" ng-controller="mainController2">
<script language="JavaScript">
                                        
var app = angular.module("MyGracz", []);

app.controller("mainController2", function ($scope) {

$scope.Gracze = <?= ($T->Sklad != "") ? stripslashes_deep($T->Sklad) : '[]'?>;
$scope.addGracz = function () {
    $scope.Gracze.push({
        name: $scope.DodajGracz,
        kraj: 'Polska'
    });
    

    $scope.DodajGracz = "";
  
};



 $scope.removeGracz = function(index){
    $scope.Gracze.splice(index, 1);
  }


// This makes any element draggable

});


</script>
<h3>Wybierz zawodników</h3>
Dodaj zawodnika: <input type="text" ng-model="DodajGracz"> <input type="button" class="button" ng-click="addGracz()" value="Dodaj"><br><br> 
<div ng-repeat="player in Gracze">
   <input type="text" value="{{ player.name }}" ng-model="player.name"> <input type="text" value="{{ player.kraj }}" ng-model="player.kraj">
   <a ng-click="removeGracz($index)">Usuń</a>
</div>
 <br><br>
<?php 

?>
<input type="hidden" name="Sklad" value="{{Gracze}}">
<input class="button-primary" type="submit" name="setTur" value="Dalej">
</div>
<?php
}
} else {
$TUR = loadTurnieje(0,0); 
echo '<select><option value="brak" onClick="window.location=\'admin.php?page=LIVEAPP&Komentuj=1&ID='.$_GET['ID'].'&TurID\'">Pojedyncze zawody</option>';
foreach($TUR as $T) echo '<option onClick="window.location=\'admin.php?page=LIVEAPP&Komentuj=1&ID='.$_GET['ID'].'&TurID='.$T->ID.'\'" value="'.$T->ID.'">'.$T->Nazwa.'</option>';
echo '</select>';
}

?>
</form>
