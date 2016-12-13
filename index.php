<?php
/*
Plugin Name: Relacje Live
Description: Plugin pozwalający na zarządzanie relacjami, terminarzem spotkań.
Version: 1.0
Author: Paweł Zagrobelny
License: Indvidual, all rights reserved by the author
*/

class LiveApp {
   function __construct() {
     include_once dirname( __FILE__ ) . '/admin/install.php';
	   include_once dirname( __FILE__ ) . '/admin/functions.php';
	   include_once dirname( __FILE__ ) . '/admin/admin.php';
     include_once dirname( __FILE__ ) . '/admin/relacje-page.php';
}
   
   function register() {
	   register_activation_hook(__FILE__ ,'LiveApp_install');
	   register_uninstall_hook(__FILE__, 'LiveApp_uninstall');
   }

   function hooks() {
   add_action( 'admin_menu', 'LIVEAPP_menu' );
   wp_register_style( 'myCss', plugins_url('admin/default.css', __FILE__) );
   wp_enqueue_style( 'myCss' );
   add_action('admin_enqueue_scripts', 'load_JS');
   add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');
	   /*HOOKS*/
		//add_action('init','metaads');
	
	
		//add_shortcode('metaads', 'metaads');
		//add_action('admin_head', 'Adsbutton');
	   }  
}

$METAAPP = new LiveApp();
$METAAPP->register();
$METAAPP->hooks();

//extra buttons 

require_once 'extra.php';

