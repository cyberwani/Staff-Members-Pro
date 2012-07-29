<?php
/* 
Plugin Name: Staff Members Pro
Plugin URI: http://www.jackmahoney.co.nz/ 
Description: Plugin for displaying and managing staff members as a custom post type 
Author: Jack Mahoney 
Version: 2.0 
Author URI: http://www.jackmahoney.co.nz/
*/

define('JMSMP_URL', plugins_url('Staff-Members-Pro'));
define('JMSMP_DIR', WP_PLUGIN_DIR . '/Staff-Members-Pro');

//include metaboxes

if (!class_exists( 'WPAlchemy_MetaBox' ) ) {
	include('/wpalchemy/MetaBox.php');
	include('/wpalchemy/MediaAccess.php');
}
include('/metaboxes/setup.php');
include('staff_member_posttype.php');
include('staff_member_archive.php');

//add image sizes
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'staff-member-single-thumbnail', 160, 236, true ); //300 pixels wide (and unlimited height)
}

class Staff_Members_Pro{
		
		
	public function __construct(){
		$this->add_action('init','register_posttype');
		$this->add_action('init','enqueue_styles');
		$this->add_filter( 'the_content', 'filter_content' ) ;
		add_shortcode( 'staff-member-directory', array($this,'directory_shortcode'));
	}

	protected function add_action($action, $callback){
		add_action($action, array($this,$callback));
	}
	
	protected function add_filter($filter, $callback){
		add_filter($filter, array($this, $callback));
	}
	
	public function enqueue_styles(){
	    if ( is_admin() ) 
	    { 
	        wp_enqueue_style( 'jmsmp_admin_styles', JMSMP_URL.'/css/admin.css' );
	    }
		else{
	        wp_enqueue_style( 'jmsmp_admin_styles', JMSMP_URL.'/css/main.css' );
	    }
	}

	public function directory_shortcode($atts){
		$archive = new JM_Staff_Member_Archive();
		return $archive->return_directory();
	}
	
	
	public function filter_content($content){
	     global $post;
		 global $staff_member;
	     if ($post->post_type == 'staff-member') {
	     	
	         $staff_member = new JM_Staff_Member($post);
			 if(is_single())
				$content = $staff_member->get_single();
			 else if(is_category())
			 	$content = $staff_member->get_category();
			 else if(is_archive())
			 	$content = $staff_member->get_category();
	     }
	     return $content;
	}
	
	public function register_posttype(){
 
		$labels = array(
			'name' => _x('Staff Members', 'post type general name'),
			'singular_name' => _x('Staff Member', 'post type singular name'),
			'add_new' => _x('Add New', 'Staff Member'),
			'add_new_item' => __('Add New Staff Member'),
			'edit_item' => __('Edit Staff Member'),
			'new_item' => __('New Staff Member'),
			'view_item' => __('View Staff Member'),
			'search_items' => __('Search Staff'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
	 
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'query_var' => true, 
			'menu_icon' => JMSMP_URL.'/res/staff.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,  
			'supports' => array('title','thumbnail','editor')
		  ); 
	 
		register_post_type( 'staff-member' , $args );
		
		remove_post_type_support( 'staff-member', 'comments'); 
		remove_post_type_support( 'staff-member', 'author'); 
		
		register_taxonomy("staff-department", array( 'staff-member' ), 
							array("hierarchical" => true, 
							"label" => "Departments", 
							"singular_label" => "Department")
						 );
		register_taxonomy("staff-role", array( 'staff-member' ), 
							array("hierarchical" => true, 
							"label" => "Roles", 
							"singular_label" => "Role")
						 );
						 
	}
	
}
$staff_members_pro = new Staff_Members_Pro();
