<?php

/**
 * Plugin Name:       Welcome Top Bar
 * Plugin URI:        https://benbagleydesign.com
 * Description:       Displays a welcome bar at the top of your page. 
 * Version:           1.0.0
 * Author:            Benjamin Bagley
 * Author URI:        https://benbagleydesign.com
 **/

 //Add bar after the opening body tag

 add_action('wp_body_open', 'tb_head');

 //If a user is logged in, it returns their name intstead of 'Welcome'

function get_user_or_websitename()
{
    if( !is_user_logged_in()  ) // if user is not logged in
    {
        return 'to ' . get_bloginfo('name'); // returns the blog name
    }
    else 
    {
        $current_user = wp_get_current_user();
        return $current_user -> user_login; // returns username
    }
}

// calls the function to determine if user is logged or not

 function tb_head()
 {
    echo '<h3 class="tb">Welcome ' . get_user_or_websitename() . '</h3>'; 

 }

 // add CSS to the top bar
add_action('wp_print_styles', 'tb_css');

function tb_css()
{
    echo '
        <style>
        h3.tb {color: #fff; margin: 0px; padding: 30px; text-align:center; background:#FCC263;}
        </style>
    ';
}