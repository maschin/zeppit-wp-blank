<?php

    //Add theme options
    require_once('theme-options.php');

    // Add RSS links to <head> section
    automatic_feed_links();
		
    // Clean up the <head>
    function removeHeadLinks()
    {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
    }
      
    add_action('init', 'removeHeadLinks');
   
    //Disable messages for admin login
    add_filter('login_errors',create_function('$a', "return null;"));
   
    // Load JS & CSS
    if (!is_admin())
    {
        //JS
	    wp_deregister_script('modernizr');
	    wp_register_script('modernizr', get_bloginfo('template_directory') . "/js/libs/modernizr-2.6.2.min.js");
	    wp_enqueue_script('modernizr');
		
	    wp_deregister_script('jquery');
	    wp_register_script('jquery', get_bloginfo('template_directory') . "/js/libs/jquery-1.8.0.min.js");
	    wp_enqueue_script('jquery');
	       
	    wp_deregister_script('jquery-easing');
	    wp_register_script('jquery-easing', get_bloginfo('template_directory') . "/js/libs/jquery.easing.1.3.js", array('jquery'));
	    wp_enqueue_script('jquery-easing');
	       
	    wp_deregister_script('common');
	    wp_register_script('common', get_bloginfo('template_directory') . "/js/common.js", array('jquery', 'jquery-easing'));
	    wp_enqueue_script('common');
	       
	    //CSS
        wp_deregister_style('bootstrap');
        wp_register_style('bootstrap', get_bloginfo('template_directory') . '/css/bootstrap/css/bootstrap-responsive.css', false);
        wp_enqueue_style('bootstrap');
	       
    }
   
    //Add menu & thumbnails support
    if (function_exists('add_theme_support'))
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
    }
   
    //Declare menu zone
    if(function_exists('register_nav_menus'))
    {
        register_nav_menus(
	        array(
	            'main-menu' 		=> 'Main Menu'
	        )
        );
    }

    //Register sidebars
    if(function_exists('register_sidebar') )
    {
        register_sidebar(array(
            'name' => 'Footer Sidebar',
            'id' => 'footer-sidebar',
            'description' => 'Content placed in footer',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));
    }

    //Trim the excerpt
    function trim_excerpt($text)
    {
        return rtrim($text,'[...]');
    }
    add_filter('get_the_excerpt', 'trim_excerpt');
   
    //DUMP function
    function Mdebug($var, $param = 0)
    {
	    echo '<pre>';
	    var_dump($var);
	    echo '</pre>';
	
	    if($param) die();
    }
?>