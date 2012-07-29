<div class="jmsmp_metabox">
	
	<p>
		<?php $mb->the_field('jmsmp_title'); ?>
		<label for="<?php $mb->the_name(); ?>">Title:</label>
		<select name="<?php $mb->the_name(); ?>">
			<option>Optional</option>
			<option value="Dr"<?php $mb->the_select_state('Dr'); ?>>Dr</option>
		</select>
	</p>

</div>