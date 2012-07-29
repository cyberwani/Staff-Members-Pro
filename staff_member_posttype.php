<?php
	
class JM_Staff_Member{
	
	public static $contact_candidates = array('address','phone','email','fax','mobile');
	
	public function __construct($post = null){
		if($post!=null)		
			$this->build_from_post($post);
	}
	
	/**
	 *  construct the staff member from post object
	 *  @param $post object
	 */
	protected function build_from_post($post){
		global $jmsmp_meta;
		
		$this->post = $post;
		$this->id = $post->id;
		$this->thumbnail = get_the_post_thumbnail($this->id/*, 'staff-member-single-thumbnail'*/);
		
		$this->meta = $jmsmp_meta;
		$this->first_name = $this->get_meta('name','jmsmp_firstname');
		
		//build contact details
		
		$this->contact_details = $this->build_contact_details();
		
	}
	
	protected function build_contact_details(){
		$_array = array();
		foreach(self::$contact_candidates as $candidate){
			$meta = $this->get_meta('contact','jmsmp_'.$candidate);	
			if($meta!=''){
				$_array[] = array('label'=>$candidate,'value'=>$meta);
			}
		}
		return $_array;
	}
	
	public function the_contact_table(){
		?>
		<table class='contact-table'>
			<?php foreach($this->contact_details as $detail):?>
				<tr>
					<td class="label"><?php echo $detail['label']; ?>:</td>
					<td class="value"><?php echo $detail['value']; ?></td>
				</tr>
			<?php endforeach;?>
		</table>
		<?php
	}
	
	
	/**
	 * @return string content for single loop
	 */
	public function get_single(){
		ob_start();?>
			<div class='staff-member single'>
				<div class='col left'>
					<div class='thumbnail'>
						thumbnail
					</div>
					<?php $this->the_contact_table(); ?>
				</div>
				<div class='col right'>
					
				</div>
			</div>		
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	/**
	 * Get the meta from wp_alchemy
	 * @param $parent string id of metaspec
	 * @param $name string id of field
	 * @return string 
	 */
	protected function get_meta($parent,$name){
		if(isset($this->meta[$parent])){
			return $this->meta[$parent]->get_the_value($name);
		}
		else {
			return '';
		}
	}
}
