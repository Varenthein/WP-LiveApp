<?php if($Stadion->Typ == "Grupowe") {  ?>
<b>Grupy</b><br><br>
Dodaj grupę: <input type="text" ng-model="DodajJudge"> <input type="button" class="button" ng-click="addJudge()" value="Dodaj"><br> <br>   
<div ng-repeat="player in Judge"><input type="text" value="{{ player.name }}" ng-model="player.name"> <a ng-click="removeJudge(player)">Usuń</a>  </div>
<hr>

Dodaj drużynę: <input list="flags" type="text" ng-model="DodajGosp">  Kraj: <input list="flags" type="text" ng-model="Gospkraj">  Grupa:  <select ng-model="DodajGrupa"><option ng-repeat="team in Judge | orderBy: 'name'" ng-value=" team.name">{{team.name}}</option></select>  <input type="button" class="button" ng-click="addGrupa()" value="Dodaj"> <br><br>

<div style="max-height:150px;width:1350px;overflow:auto;"> 

<div ng-repeat="team in Judge | orderBy: 'poz'">
<b>{{ team.name }}</b>:<br><br>
<div ng-show="player.grupa == team.name" ng-repeat="player in GospPlayers | orderBy: 'poz'">
<input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  <input type="text" list="flags" value="{{ player.kraj }}" ng-model="player.kraj"> <a ng-click="removeGosp(player)">Usuń</a>  
<? } else { 

// PARY

?>
 Dodaj zawodnika: <input list="flags" type="text" ng-model="DodajGosp">  Kraj: <input list="flags" type="text" ng-model="Gospkraj">  <input type="button" class="button" ng-click="addGrupa()" value="Dodaj"> <br><br>

<div style="max-height:150px;width:1350px;overflow:auto;"> 

<div class="CoDrugi" ng-repeat="player in GospPlayers | orderBy: 'poz'">
<input type="text" value="{{ player.name }}" ng-model="player.name">  <input type="text" value="{{ player.kraj }}" list="flags" ng-model="player.kraj"> 
 <a ng-click="DoGory(player.poz,player.poz-1,player.name)">Do góry</a> |
  <a ng-click="NaDol(player.poz,player.poz+1,player.name)">Na dół</a> |
<a ng-click="removeGosp(player)">Usuń</a>  
<? } ?>
</div>
</div>
<input name="GospSklad" id="GospSklad" value="{{ GospPlayers }}" type="hidden">
<input name="GoscSklad" id="GoscSklad" value="{{ GoscPlayers }}" type="hidden">
<input name="Judge" id="Judge" value="{{ Judge }}" type="hidden">