<? 

$CON .= "<img src='".$T->GospImg."'>";

function compareRowsPoz($a, $b)
{
    if ($a->poz == $b->poz) {
        return 0;
    }
    return ($a->poz > $b->poz) ? 1 : -1;
}

$CON .= '<h2 class="widget-title">Tabela</h2><div class="rezerwowi"><section id="sl2">
<table style="width:740px;padding:0px;"><tr>';      


$SkladGosp = json_decode(stripslashes_deep($T->SkladGosp)); 
usort($SkladGosp,"compareRowsPoz");  $i=0;

foreach($SkladGosp as $P) { $i++;


$CON .= '<tr class="player rez">'; 
$CON .= '<td style="width:20px;">'.$P->poz.'</td><td style="width:20px;"><img class="flaga" src="'.plugins_url('../img/Flags/'.$P->kraj.'.png', __FILE__ ).'" alt=""></td><td style="width:400px;padding-right:2px;">'.$P->name.'</td><td style="text-align:right;opacity:0.7;padding-right:10px;">'.$P->nota.'</td></tr>';
 

} 

$CON .= '</table></section></div>';

?>