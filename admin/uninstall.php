<?php 
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
global $wpdb;

   $RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
   $KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 
   
$sql = "DROP TABLE $RELACJE";
$sql2 = "DROP TABLE $KWESTIE";


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
dbDelta( $sql2 );