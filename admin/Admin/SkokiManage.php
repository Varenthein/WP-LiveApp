<div class="AlwaysSeen">
<br>
<b>Wyniki live</b><br><br>


<?if($Stadion->Typ == 'Drużynowe') { ?> 

<? if($T->KaryGosc != "" or $T->Stat == "Zawody przerwane") { ?>

<!-- USTAW OSTATECZNE WYNIKI -->

<div ng-repeat="team in GospPlayers | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ team.poz }}" ng-model="team.poz" model-change-blur> <input type="text" value="{{ team.name }}" ng-model="team.name"> Zawodnicy: <input type="text" value="{{ team.zawodnicy }}" ng-model="team.zawodnicy">   
  Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" value="{{ team.nota }}" ng-model="team.nota"> <a ng-click="removeGosp(team)">Usuń</a>

<? } else  { ?>

Dodaj zawodnika: <input type="text" ng-model="DodajGosp">  Kraj:  <select ng-model="Gospkraj"><option ng-repeat="team in Judge | orderBy: 'name'" ng-value=" team.name">{{team.name}}</option></select>  Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>
<div style="max-height:150px;width:1350px;overflow:auto;"> 

<div class="DruzynowkaTeam" ng-repeat="team in Judge | orderBy: 'poz'">
    <div class="DruzynowkaTeam" ng-show="player.kraj == team.name" ng-repeat="player in GospPlayers | orderBy: 'poz'">
       <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input model-change-blur list="flags" type="text" value="{{ player.kraj }}" ng-model="player.kraj"> 
        
<? if($T->KaryGosp == "" or $T->KaryGosc != "") { ?>
Wynik pierwszej serii:  <input style="width:150px" type="text" value="{{ player.first }}" ng-model="player.first"> 
           
<? } if($T->KaryGosp != "") { ?> 
Wynik drugiej serii:  <input style="width:150px" type="text" value="{{ player.sec }}" ng-model="player.sec">
<? } ?>

  Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" value="{{ player.nota }}" ng-model="player.nota"> <a ng-click="removeGosp(player)">Usuń</a>
     </div>
     <br>
</div>
<? } ?>

<? } else { ?>  

<? if($T->KaryGosp == "" or $T->Stat == "Zawody przerwane") { ?>     

<? if($Stadion->Typ == "TCS" and $T->KaryGosp == "") { ?>

Dodaj zawodnika: <select ng-model="DodajGosp"><optgroup ng-repeat="player in GoscPlayers | orderBy: 'poz' | limitTo: 25" label="Para nr {{player.poz}}"><option value="{{player}}">{{player.poz}}. {{player.name}}</option><option value="{{GoscPlayers[GoscPlayers.length - player.poz]}}">{{GoscPlayers[GoscPlayers.length - player.poz].poz}}. {{GoscPlayers[GoscPlayers.length - player.poz].name}}</option></optgroup></select>  Ranking ind:  <input style="width:150px" type="text" ng-model="GospRanking">  Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>

<? } else { ?>

Dodaj zawodnika: <select ng-model="DodajGosp"><option ng-repeat="player in GoscPlayers | orderBy: 'poz'" value="{{player}}">{{player.poz}}. {{player.name}}</option></select>  Pozycja: <input type="number" style="width:50px"  ng-model="Gosppoz"> Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>

<? } ?>
 
<? } else { ?>

<? if($T->KaryGosp == "") { ?>

Dodaj zawodnika: <select ng-model="DodajGosp"><option ng-repeat="player in GoscPlayers | orderBy: 'poz'" value="{{player}}">{{player.poz}}. {{player.name}}</option></select> Pozycja: <input type="number" style="width:50px" ng-model="Gosppoz">  Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>

<? } else { 

if($Stadion->Typ == "TCS") { ?>

Dodaj zawodnika: <select ng-model="DodajGosp"><option ng-repeat="player in GospKary | orderBy: 'poz'" value="{{player}}" ng-hide="player.top">{{player.poz}}. {{player.name}}</option></select> Pozycja: <input type="number" style="width:50px" ng-model="Gosppoz">  Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>

<? } else { ?>

Dodaj zawodnika: <select ng-model="DodajGosp"><option ng-repeat="player in GospKary | orderBy: 'poz'" value="{{player}}" ng-hide="player.odpada">{{player.poz}}. {{player.name}}</option></select> Pozycja: <input type="number" style="width:50px" ng-model="Gosppoz">  Wynik skoku:  <input style="width:150px" type="text" ng-model="Gospfirst"> Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" ng-model="Gospnota"> <input type="button" class="button" ng-click="addSkoczek()" value="Dodaj"> <br><br>

<? } ?>

<? } ?>


<? }?>

<div style="max-height:150px;width:1350px;overflow:auto;"> 

<? if($Stadion->Typ == "TCS" and $T->KaryGosp == "") { ?>

<!-- TCS PARY -->
                           
<div class="CoDrugi" ng-style="{opacity: player.top == 1 ? '0.5' : '1.0'}"  ng-repeat="player in GospPlayers | orderBy: 'left'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input list="flags" type="text" value="{{ player.kraj }}" ng-model="player.kraj">  

<? if($T->KaryGosp == "" or $T->KaryGosc != "" or $T->Stat == "Zawody przerwane") { ?>
Wynik pierwszej serii:  <input style="width:150px" type="text" value="{{ player.first }}" ng-model="player.first"> 
<? } if($T->KaryGosp != "" and $T->Stat != "Zawody przerwane") { ?> 
Wynik drugiej serii:  <input style="width:150px" type="text" value="{{ player.sec }}" ng-model="player.sec">
<? } ?>
  
  Rangking ind.:  <input  type="text" style="width:70px" value="{{ player.ranking }}" ng-model="player.ranking"> 
  
  Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" value="{{ player.nota }}" ng-model="player.nota"> 
  <a ng-click="IndexDoGory(player.left,player.left-1,player.name)">Do góry</a> |
  <a ng-click="IndexNaDol(player.left,player.left+1,player.name)">Na dół</a> |
  <a ng-click="removeGosp(player)">Usuń</a>
  Odpada: <input type="checkbox"  value="{{player.top}}" ng-model="player.top" ng-true-value="true" ng-false-value="false">
</div>

<? } else {?> 

<div ng-repeat="player in GospPlayers | orderBy: 'poz'">
  <input type="number" style="width:50px" value="{{ player.poz }}" ng-model="player.poz" model-change-blur> <input type="text" value="{{ player.name }}" ng-model="player.name">  Kraj:  <input list="flags" type="text" value="{{ player.kraj }}" ng-model="player.kraj">  

<? if($T->KaryGosp == "" or $T->KaryGosc != "" or $T->Stat == "Zawody przerwane") { ?>
Wynik pierwszej serii:  <input style="width:150px" type="text" value="{{ player.first }}" ng-model="player.first"> 
<? } if($T->KaryGosp != "" and $T->Stat != "Zawody przerwane") { ?> 
Wynik drugiej serii:  <input style="width:150px" type="text" value="{{ player.sec }}" ng-model="player.sec">
<? } ?>

  Rezultat:  <input min="0.01" type="text" style="width:70px" step="0.01" value="{{ player.nota }}" ng-model="player.nota"> 
   <? if($T->KaryGosp == "") { ?> Odpada: <input type="checkbox" ng-model="player.odpada"
           ng-true-value="'YES'" ng-false-value="'NO'"> <? } ?> 
  <a ng-click="DoGory(player.poz,player.poz-1,player.name)">Do góry</a> |
  <a ng-click="NaDol(player.poz,player.poz+1,player.name)">Na dół</a> |
  <a ng-click="removeGosp(player)">Usuń</a>
</div>

<? } ?>
<? } ?>

</div>
<hr>
<input name="GospSklad" value="{{ GospPlayers }}" type="hidden">
</div>