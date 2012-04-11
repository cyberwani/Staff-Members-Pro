<?php  
/* 
Plugin Name: Staff Members Plus
Plugin URI: http://www.jackmahoney.co.nz/ 
Description: Plugin for displaying and managing staff members as a custom post type 
Author: Jack Mahoney 
Version: 1.0 
Author URI: http://www.jackmahoney.co.nz/
*/

/**------------------------------------
 *     Load scripts and styles
 -------------------------------------*/

    add_action( 'wp_enqueue_scripts', 'jm_staff_add_stylesheet' );
	function jm_staff_add_stylesheet() {
        wp_register_style( 'jm-staff-style', plugins_url('style.css', __FILE__) );
        wp_enqueue_style( 'jm-staff-style' );
    }
/**------------------------------------
 *     Declare relevant variables
 -------------------------------------*/
define( 'JM_STAFF_FILE_PATH', dirname( __FILE__ ) );
include_once($JM_STAFF_FILE_PATH."staff-member.class.php");
/**
 * add thumbnail sizes
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'jm-staff-thumbnail', 220, 180, true ); //(cropped)
}
/**------------------------------------
 *     Register the post type
 -------------------------------------*/
add_action('init', 'jm_staff_register');

function jm_staff_register() {
 
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
		'menu_icon' => $JM_STAFF_FILE_PATH.'/res/staff.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'staff-member' , $args );
}
/**------------------------------------
 *     Register taxonomies for staff
 -------------------------------------*/ 
register_taxonomy("staff_type", array( 'post', 'staff-member' ), 
					array("hierarchical" => true, "label" => "Staff Categories", 
					"singular_label" => "Staff Category", "rewrite" => true));
register_taxonomy("staff_department", array( 'post', 'staff-member' ), 
					array("hierarchical" => true, "label" => "Staff Departments", 
					"singular_label" => "Staff Department", "rewrite" => true));
					  
/**------------------------------------
 *     Add meta boxes for staff
 -------------------------------------*/ 
 
add_action("admin_init", "jm_staff_meta_boxs");     
  
function jm_staff_meta_boxs(){
	//add contact details
    add_meta_box("jm-staff-contact", "Contact Details", "jm_staff_meta_contact", "staff-member", "side", "high");  
}
/**
 * build a row based on label and name
 */
function jm_staff_create_row($label, $name){
	global $post; 
	$custom = get_post_custom($post->ID);
	$value = $custom["$name"][0];	
	echo "
	<tr>
    	<td>
    		<label>$label</label>
    	</td>
    	<td>
    		<input name='$name' value='$value'/>
    	</td>
    </tr>
    ";
}    
/**------------------------------------
 *  Display the dom for contact details
 -------------------------------------*/ 
function jm_staff_meta_contact(){  
        global $post;  
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;  
        	
//blurb
echo "<p>Add contact details for the given staff member.</p>";		 
//table of inputs
echo "<table>"; 
	jm_staff_create_row('Email','jm-staff-contact-email');
	jm_staff_create_row('Home Phone','jm-staff-contact-home');
	jm_staff_create_row('Work Phone','jm-staff-contact-work');
	jm_staff_create_row('Mobile Phone','jm-staff-contact-mobile');
echo "</table>";
   
}
/**------------------------------------
 *      Save the information from 
 *            meta boxes
 -------------------------------------*/ 
						
add_action('save_post', 'jm_staff_save_meta');   

function jm_staff_save_meta(){  
    //array of meta names  
  	$jm_staff_meta_values = array("jm-staff-contact-email",
						"jm-staff-contact-home",
						"jm-staff-contact-work",
						"jm-staff-contact-mobile",
						"jm-staff-contact-fax",
						"jm-staff-contact-address"); 
    global $post; 
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){  
        return $post_id;  
    }else{
    	foreach($jm_staff_meta_values as $value):
    		update_post_meta($post->ID, "$value", $_POST["$value"]);
		endforeach;    
    }  
}      
/**------------------------------------
 *     Define the template files
 -------------------------------------*/  
function jm_staff_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'staff-member') {
          $single_template = dirname( __FILE__ ) . '/single-staff-member.php';
     }
     return $single_template;
}

add_filter( "single_template", "jm_staff_post_type_template" ) ;
?>