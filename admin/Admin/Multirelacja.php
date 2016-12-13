<b>Spotkania/pojedynki</b><br><br>
Dodaj: 
<select ng-model="TypRelacji"><option value="Piłka nożna">Piłka nożna</option><option value="Piłka ręczna">Piłka ręczna</option><option value="Siatkówka">Siatkówka</option><option value="Koszykówka">Koszykówka</option> <option value="Żużel">Żużel</option><option value="Kolarstwo">Kolarstwo</option><option value="Tenis">Tenis</option><option value="Skoki narciarskie">Skoki narciarskie</option><option value="Biathlon">Biathlon</option><option value="Biegi narciarskie">Biegi narciarskie</option> <option value="Łyżwiarstwo szybkie">Łyżwiarstwo szybkie</option></select>
<br><br>

<div ng-show="TypRelacji == 'Piłka nożna' || TypRelacji == 'Piłka ręczna'">
Gospodarz: <input type="text" ng-model="RelGosp"> 
Gość: <input type="text" ng-model="RelGosc">  
Wynik <input type="text" style="width:50px" ng-model="RelGGosp">:<input type="text" style="width:50px" ng-model="RelGGosc"> Min/Godzina/Status: <input type="text" style="width:100px" ng-model="RelMin"> 
</div>

<div ng-show="TypRelacji == 'Siatkówka'">
Gospodarz: <input type="text" ng-model="RelGosp"> 
Gość: <input type="text" ng-model="RelGosc"> 
Sety: <input type="text" ng-model="RelSety">
Wynik <input type="text" style="width:50px" ng-model="RelGGosp">:<input type="text" style="width:50px" ng-model="RelGGosc"> Set/Godzina/Status: <input type="text" style="width:100px" ng-model="RelMin"> 
</div>

<div ng-show="TypRelacji == 'Koszykówka'">
Gospodarz: <input type="text" ng-model="RelGosp"> 
Gość: <input type="text" ng-model="RelGosc"> 
Kwarty: <input type="text" ng-model="RelSety">
Wynik <input type="text" style="width:50px" ng-model="RelGGosp">:<input type="text" style="width:50px" ng-model="RelGGosc"> Kwarta/Godzina/Status: <input type="text" style="width:100px" ng-model="RelMin"> 
</div>

<div ng-show="TypRelacji == 'Tenis'">
Gospodarz: <input type="text" ng-model="RelGosp"> 
Gość: <input type="text" ng-model="RelGosc"> 
Sety: <input type="text" ng-model="RelSety">
Wynik <input type="text" style="width:50px" ng-model="RelGGosp">:<input type="text" style="width:50px" ng-model="RelGGosc"> Set/Godzina/Status: <input type="text" style="width:100px" ng-model="RelMin"> 
</div>


<div ng-show="TypRelacji == 'Żużel'">
Gospodarz: <input type="text" ng-model="RelGosp"> 
Gość: <input type="text" ng-model="RelGosc"> 
Wynik <input type="text" style="width:50px" ng-model="RelGGosp">:<input type="text" style="width:50px" ng-model="RelGGosc"> Bieg/Godzina/Status: <input type="text" style="width:100px" ng-model="RelMin"> 
</div>

<div ng-show="TypRelacji == 'Kolarstwo'">
Nazwa konkursu: <input type="text" ng-model="RelKonkurs"><br><br>
1 miejsce: <input type="text" ng-model="RelGosp"><br><br> 
2 miejsce: <input type="text" ng-model="RelGosc"><br><br>  
3 miejsce: <input type="text" ng-model="RelGGosp"><br><br> 
</div>

<div ng-show="TypRelacji == 'Skoki narciarskie'">
Nazwa konkursu: <input type="text" ng-model="RelKonkurs"><br><br>
1 miejsce: <input type="text" ng-model="RelGosp"><br><br> 
2 miejsce: <input type="text" ng-model="RelGosc"><br><br>  
3 miejsce: <input type="text" ng-model="RelGGosp"><br><br> 
</div>

<div ng-show="TypRelacji == 'Biathlon'">
Nazwa konkursu: <input type="text" ng-model="RelKonkurs"><br><br>
1 miejsce: <input type="text" ng-model="RelGosp"><br><br> 
2 miejsce: <input type="text" ng-model="RelGosc"><br><br>  
3 miejsce: <input type="text" ng-model="RelGGosp"><br><br> 
</div>

<div ng-show="TypRelacji == 'Łyżwiarstwo szybkie'">
Nazwa konkursu: <input type="text" ng-model="RelKonkurs"><br><br>
1 miejsce: <input type="text" ng-model="RelGosp"><br><br> 
2 miejsce: <input type="text" ng-model="RelGosc"><br><br>  
3 miejsce: <input type="text" ng-model="RelGGosp"><br><br> 
</div>

<div ng-show="TypRelacji == 'Biegi narciarskie'">
Nazwa konkursu: <input type="text" ng-model="RelKonkurs"><br><br>
1 miejsce: <input type="text" ng-model="RelGosp"><br><br> 
2 miejsce: <input type="text" ng-model="RelGosc"><br><br>  
3 miejsce: <input type="text" ng-model="RelGGosp"><br><br> 
</div>
          
<input type="button" class="button" ng-click="addSpotkanie()" value="Dodaj"><br> <br>
   
<hr>

<div style="max-height:150px;width:1350px;overflow:auto;"> 


<br><b>Piłka nożna</b>:<br><br>
<div ng-show="player.typ == 'Piłka nożna'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}">  
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Min/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min"value="{{player.min}}"> 
</div>

<br><b>Piłka ręczna</b>:<br><br>
<div ng-show="player.typ == 'Piłka ręczna'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}">  
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Min/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min" value="{{player.min}}"> 
</div>

<br><b>Siatkówka</b>:<br><br>
<div ng-show="player.typ == 'Siatkówka'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"> 
Sety: <input type="text" ng-model="player.sety" value="{{player.sety}}">
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Set/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min" value="{{player.min}}"> 
</div>

<br><b>Koszykówka</b>:<br><br>
<div ng-show="player.typ == 'Koszykówka'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"> 
Kwarty: <input type="text" ng-model="player.sety" value="{{player.sety}}">
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Kwarta/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min" value="{{player.min}}"> 
</div>

<br><b>Tenis</b>:<br><br>
<div ng-show="player.typ == 'Tenis'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"> 
Sety: <input type="text" ng-model="player.sety" value="{{player.sety}}">
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Set/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min" value="{{player.min}}"> 
</div>

<br><b>Żużel</b>:<br><br>
<div ng-show="player.typ == 'Żużel'" ng-repeat="player in GospPlayers">
Gospodarz: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"> 
Gość: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"> 
Wynik <input type="text" style="width:50px" ng-model="player.golegosp" value="{{player.golegosp}}">:<input type="text" style="width:50px" ng-model="player.golegosc" value="{{player.golegosc}}"> Bieg/Godzina/Status: <input type="text" style="width:100px" ng-model="player.min" value="{{player.min}}"> 
</div>

<br><b>Kolarstwo</b>:<br><br>
<div ng-show="player.typ == 'Kolarstwo'" ng-repeat="player in GospPlayers">
Nazwa konkursu: <input type="text" ng-model="player.konkurs" value="{{player.konkurs}}"><br><br>
1 miejsce: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"><br><br> 
2 miejsce: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"><br><br>  
3 miejsce: <input type="text" ng-model="player.golegosp" value="{{player.golegosp}}"><br><br> 
</div>

<br><b>Skoki narciarskie</b>:<br><br>
<div ng-show="player.typ == 'Skoki narciarskie'" ng-repeat="player in GospPlayers">
Nazwa konkursu: <input type="text" ng-model="player.konkurs" value="{{player.konkurs}}"><br><br>
1 miejsce: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"><br><br> 
2 miejsce: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"><br><br>  
3 miejsce: <input type="text" ng-model="player.golegosp" value="{{player.golegosp}}"><br><br> 
</div>

<br><b>Biathlon</b>:<br><br>
<div ng-show="player.typ == 'Biathlon'" ng-repeat="player in GospPlayers">
Nazwa konkursu: <input type="text" ng-model="player.konkurs" value="{{player.konkurs}}"><br><br>
1 miejsce: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"><br><br> 
2 miejsce: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"><br><br>  
3 miejsce: <input type="text" ng-model="player.golegosp" value="{{player.golegosp}}"><br><br> 
</div>

<br><b>Łyżwiarstwo szybkie</b>:<br><br>
<div ng-show="player.typ == 'Łyżwiarstwo szybkie'" ng-repeat="player in GospPlayers">
Nazwa konkursu: <input type="text" ng-model="player.konkurs" value="{{player.konkurs}}"><br><br>
1 miejsce: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"><br><br> 
2 miejsce: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"><br><br>  
3 miejsce: <input type="text" ng-model="player.golegosp" value="{{player.golegosp}}"><br><br> 
</div>

<br><b>Biegni narciarskie</b>:<br><br>
<div ng-show="player.typ == 'Biegi narciarskie'" ng-repeat="player in GospPlayers">
Nazwa konkursu: <input type="text" ng-model="player.konkurs" value="{{player.konkurs}}"><br><br>
1 miejsce: <input type="text" ng-model="player.gosp" value="{{player.gosp}}"><br><br> 
2 miejsce: <input type="text" ng-model="player.gosc" value="{{player.gosc}}"><br><br>  
3 miejsce: <input type="text" ng-model="player.golegosp" value="{{player.golegosp}}"><br><br> 
</div>

</div>

<input name="GospSklad" id="GospSklad" value="{{ GospPlayers }}" type="hidden">
<input name="GoscSklad" id="GoscSklad" value="{{ GoscPlayers }}" type="hidden">
<input name="Judge" id="Judge" value="{{ Judge }}" type="hidden">

 