<div class="full_w">
	<div class="h_title">Add New Localization</div>	
	<?php echo form_open_multipart('admin/home/addlocalization'); ?>
		<div class="element">
			<label for="lang_key">Key <?php if(form_error('lang_key')){ $err=' err'; echo form_error('lang_key'); } else { $err=''; ?><span> (required)</span><?php } ?></label>
			<input id="lang_key" name="lang_key" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('lang_key'); ?>" />
		</div>
		<div class="element">
			<label for="lang_value">Value <?php if(form_error('lang_value')){ $err=' err'; echo form_error('lang_value'); } else { $err=''; ?><span> (required)</span><?php } ?></label>
			<input id="lang_value" name="lang_value" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('lang_value'); ?>" />
		</div>        
		<div class="entry">
			<button type="submit" class="add">Save</button><a class="button cancel" href="<?php echo site_url('admin/home/addlocalization'); ?>">Cancel</a>
		</div>
	<?php echo form_close(); ?>
</div>