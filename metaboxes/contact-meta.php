<div class="jmsmp_metabox">
	<p>
		All fields are optional
	</p>
	<p>
		<?php $mb->the_field('jmsmp_phone'); ?>
		<label for="<?php $mb->the_name(); ?>">Phone:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_mobile'); ?>
		<label for="<?php $mb->the_name(); ?>">Mobile:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_fax'); ?>
		<label for="<?php $mb->the_name(); ?>">Fax:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_email'); ?>
		<label for="<?php $mb->the_name(); ?>">Email:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_website'); ?>
		<label for="<?php $mb->the_name(); ?>">Website:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>


	<input type="submit" class="button-primary" name="save" value="Save">

</div>