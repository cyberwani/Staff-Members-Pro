<div class="jmsmp_metabox">
	
	<p>
		<?php $mb->the_field('jmsmp_title'); ?>
		<label for="<?php $mb->the_name(); ?>">Title:</label>
		<select name="<?php $mb->the_name(); ?>">
			<option>Optional</option>
			<option value="Dr"<?php $mb->the_select_state('Dr'); ?>>Dr</option>
		</select>
	</p>
	<p class='titlewrap'>
		<?php $mb->the_field('jmsmp_firstname'); ?>
		<label for="<?php $mb->the_name(); ?>">First Name:</label>
		<input  class='big'  type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_lastname'); ?>
		<label for="<?php $mb->the_name(); ?>">Last Name:</label>
		<input class='big'  type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>

</div>