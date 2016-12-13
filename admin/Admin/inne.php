<br><br>
Dodaj zawodnika: <input type="text" ng-model="DodajGosp"> Poz: <input type="text" ng-model="Gosppoz" style="width:30px;" value="{{GospPlayers.length+1}}"> Kraj:  <input type="text" ng-model="Gospkraj" list="flags"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>
<hr>
Wyniki:

<div ng-repeat="player in GospPlayers  | orderBy: 'poz'">
  <input type="text" style="width:30px;" ng-model="player.poz">
  <input type="text" ng-model="player.name">
  <input type="text" ng-model="player.kraj" list="flags">
  <input type="text" ng-model="player.nota">
</div>