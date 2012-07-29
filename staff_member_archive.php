<?php
/**
 * called from shortcode [staff-member-directory]
 */
class JM_Staff_Member_Archive{
	
	public function __construct(){
		$this->posts = get_posts(array(
		'numberposts'=>-1,
		'post_type' => 'staff-member'
		));
		$this->staff = array();
		foreach($this->posts as $post){
			$this->staff[] = new JM_Staff_Member($post, array('condensed'=>true));
		}
	}
	
	public function get_a_z(){
		usort($this->staff, array($this, 'sort_alphabetical'));
		$current_letter = '';
		$a_z = array();
		foreach($this->staff as $sm){
			if($sm->first_char!==$current_letter)
			{
				$current_letter = $sm->first_char;
			}
			$a_z[$current_letter][] = $sm;
		}
		return $a_z;
	}
	
	public function sort_alphabetical($a, $b){
	    if ($a->first_char == $b->first_char) {
	        return 0;
	    }
	    return ($a->first_char < $b->first_char) ? -1 : 1;
	}
	
	public function return_directory(){
		ob_start();
		?>
			<?php 
			//build a-z
			$a_z = $this->get_a_z();
			$letters = array_keys($a_z);
			foreach($letters as $letter):
				echo "<h1>$letter</h1>
						<ul class='staff-member-az'>";
				foreach($a_z[$letter] as $staff):
					echo "<li><a href='{$staff->permalink}'>{$staff->name}</a></li>";
				endforeach;
				echo "  </ul>";
			endforeach;
			?>
		<?
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
}
