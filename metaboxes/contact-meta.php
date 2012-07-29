<div class="my_meta_control">
	<p>
		<?php $mb->the_field('jmsmp_phone'); ?>
		<label for="<?php $mb->the_name(); ?>">Phone:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_fax'); ?>
		<label for="<?php $mb->the_name(); ?>">Fax:</label>
		<input class='big' type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
	<p>
		<?php $mb->the_field('jmsmp_email'); ?>
		<label for="<?php $mb->the_name(); ?>">Email:</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>


	<input type="submit" class="button-primary" name="save" value="Save">

</div>