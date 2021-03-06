<?php

// Load the theme assets.
new _Container("Assets_Service");

function geo_remove_submenu() {

	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'edit.php?post_type=page' );
	remove_menu_page( 'edit.php' );
	// remove_menu_page( 'themes.php' );
}

add_action( 'admin_menu', 'geo_remove_submenu', 999 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_action( 'wp_ajax_play_area', 'enter_play_area' );
add_action( 'wp_ajax_nopriv_play_area', 'enter_play_area' );

function enter_play_area() {

	require_once('services/game-data.php');
	$return_game_data = new Game_Data;

	echo $return_game_data->return_game_data($_POST['data']);
		
	wp_die();
}