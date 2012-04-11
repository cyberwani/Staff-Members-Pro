<?php
/**--------------------------------
 *     DBHelper class for post
 *            queries
 --------------------------------*/
class jm_staff_db{
	/**
	 * query db and return all staff
	 * @return array of jm_staff_member objects
	 */
	public static function getAllStaff(){
		$args = array(
		'numberposts'     => -1,
		'post_type'       => 'staff-member');
		$the_posts = get_posts($args);
		$staff = array();
		foreach($the_posts as $the_post)
		{
			$staff [] = new jm_staff_member($the_post);
		}	
		return $staff;
	}
}
?>