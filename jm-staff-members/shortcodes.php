<?php
/**------------------------------------
 *      Shortcodes for the staff
 * 		    member plugin
 -------------------------------------*/

// [jm-staff-member-list]
function jm_staff_member_list_shortcode_function( $atts ) {
	$str = '<table>';
	$staff = jm_staff_db::getAllStaff();
	//insert rows for each staff member 
	foreach($staff as $member)
	{
		$str.= $member->makeListView();
	}	
	$str.="</table";
	return $str;
}
add_shortcode( 'jm-staff-member-list', 'jm_staff_member_list_shortcode_function' );

// [jm-staff-member-grid]
function jm_staff_member_grid_shortcode_function( $atts ) {
	echo '<div id="jm-staff-grid">';
	$staff = jm_staff_db::getAllStaff();
	//insert rows for each staff member 
	foreach($staff as $member)
	{
	    $member->makeGridView();
	}	
	echo "</div";
}
add_shortcode( 'jm-staff-member-grid', 'jm_staff_member_grid_shortcode_function' );
?>