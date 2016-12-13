<?php


function LiveApp_installDB() {
   global $wpdb;

   $RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
   $KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 
   $TURNIEJE = $wpdb->prefix . "LiveApp_Turnieje"; 
   $PLAYERS = $wpdb->prefix . "LiveApp_Players"; 
   
  global $wpdb;
$sql = "CREATE TABLE $RELACJE (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Gosp` VARCHAR( 225 ) NOT NULL ,
`Gosc` VARCHAR( 225 ) NOT NULL ,
`PktGosp` INT( 11 ),
`PktGosc` INT( 11 ),
`StGosp`  TEXT ,
`StGosc` TEXT ,
`SkladGosp` TEXT ,       
`SkladGosc` TEXT ,
`RezGosp` TEXT ,
`RezGosc` TEXT ,
`Min` INT(11),
`KaryGosp` TEXT ,
`KaryGosc` TEXT ,
`Kategoria` TEXT ,
`Rozgrywki` TEXT ,
`Faza` TEXT,
`Status` BOOLEAN,
`Data` DATETIME,
`Komentator` TEXT ,
`GospImg` VARCHAR( 225 ) NOT NULL ,
`GoscImg` VARCHAR( 225 ) NOT NULL ,
`GospKolor` VARCHAR( 20 ),
`GoscKolor` VARCHAR( 20 ),
`Stadion` TEXT,
`GospTrener` VARCHAR( 225 ),
`GoscTrener` VARCHAR( 225 ),
`PodGol` TEXT,
`Judge` TEXT,
`Stat` VARCHAR(225),
`Turniej` VARCHAR(225)
UNIQUE KEY id( `ID` )      
) DEFAULT CHARSET=utf8mb4";

$sql2 = "CREATE TABLE $KWESTIE (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Min` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_polish_ci,
  `Min_display` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_polish_ci,
  `Text` TEXT CHARACTER SET utf8 COLLATE utf8_polish_ci,
  `Data` DATETIME,
  `RelID` INT(11),
  `Rodzaj` VARCHAR(225) SET utf8 COLLATE utf8_polish_ci,
   UNIQUE KEY id (`ID`)  
);";
                                                      
//Pozycja, Imię i nazwisko, kraj,  wynik pierwszej serii, wynik drugiej serii, nota
$sql3 = "CREATE TABLE $TURNIEJE (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Nazwa` VARCHAR( 225 ) NOT NULL,
`Data` DATETIME,
`Sklad` TEXT,
`Kategoria` VARCHAR(225),
`Typ` VARCHAR(225),
UNIQUE KEY id( `ID` )      
) DEFAULT CHARSET=utf8mb4";



require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
dbDelta( $sql2 );
dbDelta( $sql3 );

 $the_page_title = 'Relacje Live';
    $the_page_name = 'relacje-live';

    // the menu entry...
    delete_option("my_plugin_page_title");
    add_option("my_plugin_page_title", $the_page_title, '', 'yes');
    // the slug...
    delete_option("my_plugin_page_name");
    add_option("my_plugin_page_name", $the_page_name, '', 'yes');
    // the id...
    delete_option("my_plugin_page_id");
    add_option("my_plugin_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "Relacje live - do not edit this page";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...

        $the_page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );

    }

    delete_option( 'my_plugin_page_id' );
    add_option( 'my_plugin_page_id', $the_page_id );
}


function LiveApp_uninstallDB() {
  global $wpdb;

   $RELACJE = $wpdb->prefix . "LiveApp_Relacje"; 
   $KWESTIE = $wpdb->prefix . "LiveApp_Kwestie"; 
   
$sql = "DROP TABLE $RELACJE";
$sql2 = "DROP TABLE $KWESTIE";

print "DROP TABLE $RELACJE";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
dbDelta( $sql2 );

 $the_page_title = get_option( "my_plugin_page_title" );
    $the_page_name = get_option( "my_plugin_page_name" );

    //  the id of our page...
    $the_page_id = get_option( 'my_plugin_page_id' );
    if( $the_page_id ) {

        wp_delete_post( $the_page_id ); // this will trash, not delete

    }

    delete_option("my_plugin_page_title");
    delete_option("my_plugin_page_name");
    delete_option("my_plugin_page_id");
}


function LiveApp_install(){
    LiveApp_installDB();
}
function LiveApp_uninstall() {
    LiveApp_uninstallDB();
}
?>