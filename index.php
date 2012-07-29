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

class Staff_Members_Pro{
		
		
	public function __construct(){
		$this->add_action('init','register_posttype');
		$this->add_action('init','enqueue_styles');
		$this->add_filter( 'the_content', 'filter_single' ) ;
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
	        wp_enqueue_style( 'jmsmp_admin_styles', JMSMP_URL.'/css/main.css' );
	    }
	}
	
	public function filter_single($content){
	     global $post;
	     if ($post->post_type == 'staff-member') {
	     	
	         $sm = new JM_Staff_Member($post);
			 $content = $sm->get_single();
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
			'supports' => array('thumbnail')
		  ); 
	 
		register_post_type( 'staff-member' , $args );
		
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
