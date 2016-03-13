<?php

/*
 * Template Name: Migrate
 */

get_header();

global $currentuser;
get_currentuserinfo();

if (!current_user_can('administrator') && !is_admin()) {
    echo 'please, login as admin';
} else {
    
    require_once '/migrate/index.php';
    
}



get_footer();
