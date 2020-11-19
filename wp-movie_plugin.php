<?php
/*
Plugin Name: Movies Plugin
Description: This is a our Movie plugin,which is used by the students. 
Author: Adarsh Kumar Shah
Text Domain:movie-plugin
Version: 1.0
*/
/*
if(!defined("ABSPATH"))
    exit;
if(!defined("MY_MOVIE_PLUGIN_DIR_PATH"))
	define("MY_MOVIE_PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
if(!defined("MY_MOVIE_PLUGIN_URL"))
	define("MY_MOVIE_PLUGIN_URL",plugins_url()."/movies_plugin");
*/

define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define("PLUGIN_URL",plugins_url());
define("PLUGIN_VERSION", '1.0');




// register custom post type movie
add_action( 'init', 'create_post_movie_type' );
function create_post_movie_type() {  // books custom post type
    // set up labels
    $labels = array(
        'name' => 'Movies',
        'singular_name' => 'Movie Item',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Movie Item',
        'edit_item' => 'Edit Movie Item',
        'new_item' => 'New Movie Item',
        'all_items' => 'All Movies',
        'view_item' => 'View Movie Item',
        'search_items' => 'Search Movies',
        'not_found' =>  'No Movies Found',
        'not_found_in_trash' => 'No Movies found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Movies',
    );
    register_post_type(
        'movies',
        array(
            'labels' => $labels,
            'has_archive' => true,
            'public' => true,
            'hierarchical' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
            'taxonomies' => array( 'post_tag', 'category' ),
            'exclude_from_search' => true,
            'capability_type' => 'post',
        )
    );
}

// register  taxonomie to go with the Genre Type
add_action( 'init', 'create_taxonomies', 0 );
function create_taxonomies() {
    // Genre-type taxonomy
    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Genre' ),
        'all_items'         => __( 'All Genres' ),
        'parent_item'       => __( 'Parent Genre' ),
        'parent_item_colon' => __( 'Parent Genre:' ),
        'edit_item'         => __( 'Edit Genre' ),
        'update_item'       => __( 'Update Genre' ),
        'add_new_item'      => __( 'Add New Genre' ),
        'new_item_name'     => __( 'New Genre' ),
        'menu_name'         => __( 'Genres' ),
    );
    register_taxonomy(
        'Genre',
        'movies',
        array(
            'hierarchical' => true,
            'labels' => $labels,
            'query_var' => true,
            'rewrite' => true,
            'show_admin_column' => true
        )
    );
}
// connection to css,js folder

function custum_movie_plugin(){
	// css and js file
	wp_enqueue_style("custum_movie_plugin_style", // unique name
		PLUGIN_URL."/movies_plugin/assest/CSS/style.css", // css file path
	'', // dependency on other file
    PLUGIN_VERSION);
    wp_enqueue_style("datatable", // unique name
        PLUGIN_URL."/movies_plugin/assest/CSS/jquery.dataTables.min.css", // css file path
    '', // dependency on other file
    PLUGIN_VERSION);

     wp_enqueue_style("notifybar", // unique name
        PLUGIN_URL."/movies_plugin/assest/CSS/jquery.notifyBar.css", // css file path
    '', // dependency on other file
    PLUGIN_VERSION);

   

   
    wp_enqueue_script('jquery');
   
     
     wp_enqueue_script("jquery.validate.min.js", // unique name
        PLUGIN_URL."/movies_plugin/assest/js/jquery.validate.min.js", // css file path
    '', // dependency on other file
    PLUGIN_VERSION,
    true);

      wp_enqueue_script("jquery.dataTables.min.js", // unique name
        PLUGIN_URL."/movies_plugin/assest/js/jquery.dataTables.min.js", // css file path
    '', // dependency on other file
    PLUGIN_VERSION,
    true);

      wp_enqueue_script("jquery.notifyBar.js", // unique name
        PLUGIN_URL."/movies_plugin/assest/js/jquery.notifyBar.js", // css file path
    '', // dependency on other file
    PLUGIN_VERSION,
    true);

      wp_enqueue_script("script.js", // unique name
        PLUGIN_URL."/movies_plugin/assest/js/script.js", // css file path
    '', // dependency on other file
    PLUGIN_VERSION,
    true);
    wp_localize_script("script.js","mymovieajaxurl",admin_url("admin-ajax.php"));
}
add_action("init","custum_movie_plugin");

//plugin menu and submenu

function my_movie_plugin_menus(){
	add_menu_page("My Movie","My Movie","manage_options","movie-list","my_movie_list","dashicons-editor-video",30);
	add_submenu_page("movie-list","Movie-list","Movie-list","manage_options","movie-list","my_movie_list");
	add_submenu_page("movie-list","Add New","Add New","manage_options","add-new","my_movie_add");
 // Edit page 
	add_submenu_page("movie-list","","","manage_options","movie-edit","my_movie_edit");
}
add_action("admin_menu","my_movie_plugin_menus");

function my_movie_list(){
	include_once PLUGIN_DIR_PATH."/view/movie-list.php";
}
function my_movie_add(){
	include_once PLUGIN_DIR_PATH."/view/movie-add.php";
	insert_data();
}

function my_movie_edit(){
	include_once PLUGIN_DIR_PATH."/view/movie-edit.php";
}

function my_movie_table(){
    global $wpdb;
    return $wpdb->prefix."my_book_list"; // wp_my_book_list
}
// Database base table generation on activation of plugin

//table generater
function my_movie_list_generate_table_script(){
    global $wpdb;
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    $sql_query_to_create_table="CREATE TABLE `wp_my_movie_list` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `movie_name` varchar(255) NOT NULL,
		 `director` varchar(255) NOT NULL,
		 `category` varchar(255) NOT NULL,
		 `description` text NOT NULL,
		 `movie_image` text NOT NULL,
		 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		 PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	dbDelta($sql_query_to_create_table);
}
register_activation_hook(__FILE__,"my_movie_list_generate_table_script");

// deactivate table
function my_movie_list_drop_table(){
	global $wpdb;
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    $wpdb->query('DROP table if Exists wp_my_movie_list');

    //step-1: we get the id of the post page
    //delete the page from table

    $the_post_id=get_option("plugin_page"); // getting the id of the post name (plugin_page)
    if(!empty($the_post_id)){
    	wp_delete_post($the_post_id, true);
    }
}
register_deactivation_hook(__FILE__,"my_movie_list_drop_table");



// creating a dynamic page on activation of plugin

function create_page(){
	// creating page
	$page=array();
	$page['post_title']="Online Movie Management";
	$page['post_content']="Entertainment Platform for the All";
	$page['post_status']="publish";
	$page['page_slug']="Online Movie Management";
	$page['post_title']=" Online Movie Management";
	$page['post_type']="page";
    
	//$post_id=wp_insert_post($page); // post_id as return value

	//add_option("plugin_page",$post_id); // with the help of this post_id we can delete the plugin page on deactivation of plugin.
	wp_insert_post($page);
}
register_activation_hook(__FILE__,"create_page");
