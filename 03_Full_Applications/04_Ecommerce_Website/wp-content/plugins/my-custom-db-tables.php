<?php
/*
Plugin Name: My Custom DB Tables
Description: A plugin for registering new table
Author: Tassos Antoniou
*/

function create_the_custom_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
	
    $table_name = $wpdb->prefix . 'user_information';

    $sql = "CREATE TABLE " . $table_name . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	user_id int(20) NOT NULL,
	phone int(20) NULL,
    first_name varchar(100) NOT NULL,
    last_name varchar(100) NOT NULL,
	age int(2) NULL,
    country varchar(100) NOT NULL,
    gender varchar(100) NOT NULL,
	PRIMARY KEY  (id),
	KEY user_id (user_id)
    ) $charset_collate;";
 
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'create_the_custom_table');