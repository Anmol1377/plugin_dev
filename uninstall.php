<?php

/**
 *
 * @link       https://test.com
 * @since      1.0.0
 *
 * @package    Test_plugin
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


// function plugin_uninstall{

// }
// register_uninstall_hook( __FILE__, plugin_uninstall );


global $wpdb, $table_prefix;
$wp_mytable = $table_prefix . 'mytable';
	$q = "DROP TABLE  `$wp_mytable`";
	$wpdb->query($q);

?>