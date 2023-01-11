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

        if(get_option('topbar_field')){ // if text field is used
            return get_option('topbar_field');
        } else {
            return 'Welcome to ' . get_bloginfo('name'); // returns the blog name    
        }
        
    }
    else 
    {
        $current_user = wp_get_current_user();
        return 'Welcome back ' . $current_user -> user_login; // returns username
    }
}

// calls the function to determine if user is logged or not

 function tb_head()
 {
    echo '<h3 class="tb">' . get_user_or_websitename() . '</h3>'; 

 }

 // add CSS to the top bar
add_action('wp_print_styles', 'tb_css');

function tb_css()
{
    echo '
        <style>
        h3.tb {color: #fff; margin: 0px; padding: 30px; text-align:center; background:#333; filter:opacity(80%);}
        </style>
    ';
}

// Top Bar backend page

function topbar_backend_page() {
    $page_title = 'Top Bar Options';
    $menu_title = 'Top Bar';
    $capability = 'manage_options'; // controlling access to the page
    $slug = 'topbar-plugin'; // something unique
    $callback = 'topbar_page_html'; // the function that renders the page
    $icon = 'dashicons-schedule';
    $position = 60; // position on dashboard

    add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
}

// hook to call function

add_action('admin_menu', 'topbar_backend_page'); 

// function for adding a field 

function topbar_register_settings() {
    register_setting('topbar_option_group', 'topbar_field'); // first parameter is the group
}

add_action('admin_init', 'topbar_register_settings' ); // hook the function

// rendering the html page topbar_page_html

function topbar_page_html() { ?> 
<!-- Class of wrap comes with WordPress -->

<div class="wrap top-bar-wrapper">
    <form method="post" action="options.php">
        <?php settings_errors();  // adds an error if there is an issue ?> 
        <?php settings_fields('topbar_option_group'); // adding the group option ?>
        <label for="topbar_field_id">Top Bar Text <br> <hr></label>
        <input name="topbar_field" id="topbar_field_id" type="text" value=" 
        <?php echo get_option('topbar_field'); // gets the input text from the field ?> 
        ">
        <div style="width:50%; margin:auto;"><?php submit_button(); ?></div>
    </form>

</div>


<?php }

// add css to style the form 

add_action('admin_head', 'topbarstyle');

function topbarstyle() {
    echo '<style>
    .top-bar-wrapper {
        display: flex; 
        margin-top:35px;
       
    
       
    }
    .top-bar-wrapper form { 
        
        width: 100%; 
        max-width: 500px; 
        border-box-shadow: #effcfc;
        background-color:#224e57;
        padding: 30px;
        border-radius: 20px;
    }
    .top-bar-wrapper label { 
        font-size:3em; 
        display: block; 
        line-height:normal; 
        margin-bottom:30px;
        color: white;
    }
    .top-bar-wrapper input {
        color: #666;
        width: 100%;
        padding: 5px;
        font-size: 1.5em;
    }

    .top-bar-wrapper input:active {
        border:  1px solid #7ee0e2;
    }


    .top-bar-wrapper .button {

    padding: 5px;
    margin: auto;
    background-color: #26acb4; 
    color: white;
    border-radius: 20px;
    font-weight: bold;
    transform-text: uppercase;
    border: 0px solid;
    
    }

    .top-bar-wrapper .button:hover {
        
        padding: 5px;
        margin: auto;
        background-color: #7ee0e2;
        color: #224e57;
        border-radius: 20px;
        font-weight: bold;
        transform-text: uppercase;
        border: 0px solid;
        }
        
        .top-bar-wrapper .button:active {
            background-color: #7ee0e2;
            color: #224e57;
            border: 0px solid;
        
        } 

        .top-bar-wrapper .button:visited {
            background-color: #26acb4; 
            color: white;
            border: 0px solid;
        } 
        
    
    
    
    </style>';


}