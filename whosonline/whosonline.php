<?php
/**
 * Plugin Name:       Who's online
 * Description:       Show users online in site.
 * Version:           1.0
 * Author:            Camilo Villavicencio
 */

function create_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'whosonline';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        user mediumint(9) NOT NULL,
		time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'create_table' );


function drop_table(){
	global $wpdb;
    $table_name = $wpdb->prefix . 'whosonline';
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    
}
register_deactivation_hook( __FILE__, 'drop_table' );


function user_logged() {
	$user = wp_get_current_user();
	return $user->exists();
    echo '<script>alert("aaaadsd")</script>';
}


function save_action(){
    if (user_logged()){
        global $wpdb;
        $table_name = $wpdb->prefix . 'whosonline';
        $user_id=get_current_user_id();
        $wpdb->query("INSERT INTO $table_name ( user ) VALUES ( '$user_id' );");
    } 
    
}
add_action( 'init', 'save_action' );


function whosonline(){

    $result='<div><b>Logged users with activity in last 5 minutes</b><br>';
    if (user_logged()){
        global $wpdb;
        $table_name = $wpdb->prefix . 'whosonline';
        $table_users = $wpdb->prefix . 'users';
        $user_id=get_current_user_id();
        $myrows = $wpdb->get_results( "SELECT DISTINCT $table_name.user, $table_name.time, $table_users.user_login AS 'user_login' FROM $table_name INNER JOIN $table_users ON $table_name.user = $table_users.id WHERE $table_name.time > (CURRENT_TIMESTAMP-300) GROUP BY $table_name.user ORDER BY time ASC;" );

        $result.='<ul style="list-style-type: none;">';

        foreach ( $myrows as $row ) {
            $result .= '<li>🟢 '.$row->user_login .'</li>';
        }

        $result.='</ul>';
    } else {
        $result.='You must be logged in to view this list.';    
    }

    $result.='</div>';
    return $result;

}
add_shortcode('whosonline', 'whosonline');

function whosonline_info(){
    echo whosonline();
}

function whosonline_page() {
    add_options_page( 'Who\'s online', 'Who\'s online', 'manage_options', 'whosonline_info', 'whosonline_info' );
}
add_action( 'admin_menu', 'whosonline_page' );




?>
