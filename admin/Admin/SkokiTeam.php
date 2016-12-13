<?php ?>
<b>Drużyny</b><br><br>
Dodaj drużynę: <input type="text" ng-model="DodajJudge"> <input type="button" class="button" ng-click="addJudge()" value="Dodaj"><br> <br>   
<div ng-repeat="player in Judge"><input type="text" value="{{ player.name }}" ng-model="player.name"> <a ng-click="removeJudge(player)">Usuń</a>  </div>
<hr>

<b>Lista startowa</b><br><br>
<div style="max-height:150px;width:1300px;overflow:auto;">
<div ng-repeat="player in Judge | orderBy: 'poz'">
<input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz">   Kraj:  <input type="text" list="flags"  value="{{ player.name }}" ng-model="player.name"> Zawodnicy: <input type="text" value="{{ player.zawodnicy }}" ng-model="player.zawodnicy">  <a ng-click="removeJudge(player)">Usuń</a>
</div> 
</div>