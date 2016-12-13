<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    */
/*
Plugin Name: BS3 panel shortcode
Plugin URI:
Description: A plugin to add Bootstrap 3 panel shortcode as a part to the GWP tutorial
Version: 1.0
Author: Ohad Raz
Author URI: http://generatewp.com
*/
class GWP_bs3_panel_shortcode{
	/**
	 * $shortcode_tag 
	 * holds the name of the shortcode tag
	 * @var string
	 */
	public $shortcode_tag = 'bs3_panel';

	/**
	 * __construct 
	 * class constructor will set the needed filter and action hooks
	 * 
	 * @param array $args 
	 */
	function __construct($args = array()){
		//add shortcode
		add_shortcode( $this->shortcode_tag, array( $this, 'shortcode_handler' ) );
		
		if ( is_admin() ){
			add_action('admin_head', array( $this, 'admin_head') );
			add_action( 'admin_enqueue_scripts', array($this , 'admin_enqueue_scripts' ) );
		}
	}

	/**
	 * shortcode_handler
	 * @param  array  $atts shortcode attributes
	 * @param  string $content shortcode content
	 * @return string
	 */
	function shortcode_handler($atts , $content = null){
		// Attributes
		extract( shortcode_atts(
			array(
				'header' => 'no',
				'footer' => 'no',
				'type' => 'default',
			), $atts )
		);
		
		//make sure the panel type is a valid styled type if not revert to default
		$panel_types = array('primary','success','info','warning','danger','default');
		$type = in_array($type, $panel_types)? $type: 'default';

		//start panel markup
		$output = '<div class="panel panel-'.$type.'">';

		//check if panel has a header
		if ('no' != $header)
			$output .= '<div class="panel-heading">'.$header.'</div>';

		//add panel body content and allow shortcode in it
		$output .= '<div class="panel-body">'.trim(do_shortcode( $content )).'</div>';

		//check if panel has a footer
		if ('no' != $footer)
			$output .= '<div class="panel-footer">'.$footer.'</div>';

		//add closing div tag
		$output .= '</div>';

		//return shortcode output
		return $output;
	}

	/**
	 * admin_head
	 * calls your functions into the correct filters
	 * @return void
	 */
	function admin_head() {
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}
		
		// check if WYSIWYG is enabled
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
			add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
		}
	}

	/**
	 * mce_external_plugins 
	 * Adds our tinymce plugin
	 * @param  array $plugin_array 
	 * @return array
	 */
	function mce_external_plugins( $plugin_array ) {

		$plugin_array[$this->shortcode_tag] = plugins_url( 'js/mce-button.php' , __FILE__ );
		return $plugin_array;
	}

	/**
	 * mce_buttons 
	 * Adds our tinymce button
	 * @param  array $buttons 
	 * @return array
	 */
	function mce_buttons( $buttons ) {
		array_push( $buttons, $this->shortcode_tag );
		return $buttons;
	}

	/**
	 * admin_enqueue_scripts 
	 * Used to enqueue custom styles
	 * @return void
	 */
	function admin_enqueue_scripts(){
		 wp_enqueue_style('bs3_panel_shortcode', plugins_url( 'css/mce-button.css' , __FILE__ ) );
	}
}//end class

new GWP_bs3_panel_shortcode();

//Add shortcode      

function DSQ($array)  {
foreach($array as $el) {
if($el->nota == 'DSQ' or $el->nota == "") { $el->poz = '5000'; $rest[] = $el; }
else $gora[] = $el;
}
$newArray = array();
if($gora) { foreach($gora as $el) $newArray[] = $el;  }
if($rest) { foreach($rest as $el) $newArray[] = $el; }
return $newArray;
}
function compareItPoz($a, $b)
{
    if ($a->poz == $b->poz) {
        return 0;
    }
    return ($a->poz > $b->poz) ? 1 : -1;
}




add_shortcode( 'showLive', 'bnr_live' );
function bnr_live( $atts ) {
include 'admin/lang.php';
    ob_start();

    extract( shortcode_atts( array (
        'id' => '1',
        'typ' => 'start',
    ), $atts ) );

global $wpdb;
$RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
$KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 


$res = $wpdb->get_results("SELECT * FROM $RELACJE WHERE `ID` = '".intval($id)."' LIMIT 1");
foreach ($res as $S) 
{

if($typ == "koniec") {
$S->Min = "Koniec";
}
if($typ == "start") {
$S->PodGol = "";
$S->Min = substr($S->Data,5,2).'.'.substr($S->Data,8,2).' '.substr($S->Data,11,2).':'.substr($S->Data,14,2);
$S->PktGosp = 0;
$S->PktGosc = 0;
$S->SkladGosp = NULL;
}

$St = json_decode(stripslashes_deep($S->Stadion));

if(empty($LANG[$S->Kategoria])) { $LA = (object) $LANG['default']; $LSTYL = "default"; } else { $LA = (object) $LANG[$S->Kategoria];  }


if(in_array($S->Kategoria,array('Piłka nożna','Piłka ręczna','Koszykówka','Siatkówka','Tenis','Żużel'))) {

$HEAD = '<a href="/relacje-live/?MeczId='.$S->ID.'"><header>
<div class="herb">'.((!file_exists('../wp-content/plugins/LiveApp/admin/img/Flags/'.$S->Gosp.'.png') ==  1 ) ? '<img alt="'.$S->Gosp.'" src="'.plugins_url( 'admin/img/Flags/'.$S->Gosp.'.png', __FILE__ ).'">' : '').'</div>
<div class="team gosp">'.$S->Gosp.'</div>
<div class="goal"><span>'.$S->Min.'</span>
<div class="wyn"> '.$S->PktGosp.' : '.$S->PktGosc.'</div>
';

if(!in_array($S->Kategoria,array('Koszykówka','Siatkówka','Tenis'))) {

$HEAD .= '<div class="podGol">'.$S->Kategoria.'</div>';

} else {

$pieces = explode(',',$S->PodGol);  $i=0;
foreach($pieces as $SET) { $i++;
$P = explode(':',$SET);  
if($S->typ == "Tenis") $PodGol .= '<span class="'.(($i == 1) ? 'actualSet ' : '').'set"><i>'.$i.' '.$LA->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>'; else $PodGol .= '<span class="set"><i>'.$i.' '.$LA->SetLabel.'</i>'.$P[0].':'.$P[1].'</span>';
}
$HEAD.= '<div class="podGol sety"><div class="sets">'.$PodGol.'</div></div>';

}

$HEAD .= '
</div>
<div class="team">'.$S->Gosc.'</div>
<div class="herb">'.((!file_exists('../wp-content/plugins/LiveApp/admin/img/Flags/'.$S->Gosc.'.png') == 1) ? '<img alt="'.$S->Gosc.'" src="'.plugins_url( 'admin/img/Flags/'.$S->Gosc.'.png', __FILE__ ).'">' : '').'</div>
</header></a>';

} else if($S->Kategoria == "Multirelacja" or $S->Kategoria == "Losowanie") {

} else {

$Sklad = json_decode(stripslashes_deep($S->SkladGosp));
$Sklad = DSQ($Sklad);
usort($Sklad, "compareItPoz");
$Sklad = array_slice($Sklad,0,3);


$HEAD = '<a href="/relacje-live/?MeczId='.$S->ID.'"><header>
<div style="width:100%;text-align:left;display:block" class="team gosp">'.$S->Rozgrywki.'</div>';
$i = 0;
foreach($Sklad as $P) { $i++;
$HEAD .= '<div class="miejsce">'.$i.'. '.$P->name.'</div>';
}
$HEAD .= '</header></a> <br><br>';


}

echo $HEAD.$WPIS;

}
     $myvariable = ob_get_clean();
    return  $myvariable;
}

