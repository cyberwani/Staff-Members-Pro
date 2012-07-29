<?php
	
class JM_Staff_Member{
	
	public static $contact_candidates = array('address','phone','mobile','fax','email','website');
	
	public function __construct($post = null, $options = null){
		if($post!=null){
			if(isset($options['condensed']))
				$this->build_condensed($post);
			else			
				$this->build_from_post($post);
		}		
	}
	
	protected function build_condensed($post){
		$this->id = $post->id;
		$this->name = $post->post_title;
		if(sizeof($this->name)>0)
			$this->first_char = substr($this->name,0,1);
		$this->permalink = $post->guid;
	}
	
	/**
	 *  construct the staff member from post object
	 *  @param $post object
	 */
	protected function build_from_post($post){
		global $jmsmp_meta;
		
		//do essentials
		$this->build_condensed($post);
		
		$this->thumbnail = get_the_post_thumbnail($this->id, 'staff-member-single-thumbnail');
		
		$this->meta = $jmsmp_meta;
		$this->content = get_the_content($this->id);
				
		//build contact details
		$this->contact_details = $this->build_contact_details();
		
		//build departments and roles
		$this->departments = get_the_terms($this->id, 'staff-department');
		$this->roles = get_the_terms($this->id, 'staff-role');
		
	}
	
	public function get_terms($term_name, $taxonomy){
		$str = '';	
		$i = 0;
		if($term_name!=null)
		foreach($term_name as $term){
			if($i>0)
				$str.=', ';
			$str.='<a href="'.get_term_link($term->slug, $taxonomy).'">'.$term->name.'</a>';
			$i++;
		}
		return $str;
		
	}
	
	protected function build_contact_details(){
		$_array = array();
		foreach(self::$contact_candidates as $candidate){
			$meta = $this->get_meta('contact','jmsmp_'.$candidate);	
			if($meta!=''){
				$value = $meta;
				//check for phone numbers
				if(in_array($candidate, array('phone','fax','mobile')))
					$value = '<a href="tel:'.$meta.'">'.$meta.'</a>';
				else if($candidate == 'email'){
					$value = '<a href="mailto:'.$meta.'">'.$meta.'</a>';
				}
				else if($candidate == 'website'){
					$value = '<a targer="_blank" href="'.$meta.'">'.$meta.'</a>';
				}
				$_array[] = array('label'=>$candidate,'value'=>$value);
			}
		}
		return $_array;
	}
	
	public function the_taxonomy_table(){
		?>
		<table class='contact-table'>
				<tr>
					<td class="label">Department<?php if(sizeof($this->departments>1)) echo 's';?>:</td>
					<td class="value"><?php echo $this->get_terms($this->departments, 'staff-department');?></td>
				</tr>
				<tr>
					<td class="label">Role<?php if(sizeof($this->roles>1)) echo 's';?>:</td>
					<td class="value"><?php echo $this->get_terms($this->roles, 'staff-role');?></td>
				</tr>
		</table>
		<?php
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
	
	public function get_name(){
		return $this->first_name.' '.$this->last_name;
	}
	
	public function get_category(){
		return "herro!";
	}
	
	/**
	 * @return string content for single loop
	 */
	public function get_single(){
		ob_start();?>
			<div class='staff-member single'>
				<div class='col left'>
					<div class='thumbnail'>
						<?php echo $this->thumbnail; ?>
					</div>
					<?php $this->the_taxonomy_table(); ?>
					<?php $this->the_contact_table(); ?>
				</div>
				<div class='col right'>
					<div class='inner'>
						<?php echo $this->content;?>
					</div>
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
