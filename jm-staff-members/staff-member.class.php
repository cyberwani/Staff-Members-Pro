<?php
/**----------------------------
 *      Wrapper class for
 *      staff-member posts
 -----------------------------*/
class jm_staff_member{
	
	//define fields
	public $post;
	public $ID;
	public $content; 
	public $thumbnail;
	
	public $home;
	public $work;
	public $mobile;
	public $email;
	//constructor		
	public function __construct($the_post){
		$this->post = $the_post;
		$this->ID = $this->post->ID;
		$this->content = $this->post->post_content;
		$this->thumbnail = get_the_post_thumbnail($this->ID, 'jm-staff-thumbnail');
		//get meta
		$custom = get_post_custom($this->ID); 
		$this->home = $custom["jm-staff-contact-home"][0];
		$this->work = $custom["jm-staff-contact-work"][0];
		$this->mobile = $custom["jm-staff-contact-mobile"][0];
		$this->email = $custom["jm-staff-contact-email"][0];
							  
	}
	 
	//create sidebar with thumbnail and meta	
	public function getSidebar(){
		echo $this->thumbnail;
		echo "<table class='staff-member-contact'>";
			$this->makeRow("Work",$this->work);
			$this->makeRow("Home",$this->home);
			$this->makeRow("Mobile",$this->mobile);
			$this->makeRow("Email",$this->email); 
		echo "</table>";
	}
	//make a row if meta not empty
	private function makeRow($label, $custom){
		if($custom != '' or $custom != null)
		echo "
			<tr>
			 <td class='label'>$label</td>
			 <td class='meta'>$custom</td>
			</tr>
		";
	}
	//get content 
	public function getContent(){
		echo $this->content;
	}
	
	
}
?>