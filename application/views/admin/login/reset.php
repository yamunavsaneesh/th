<?php echo form_open('admin/login/resetpwd/'.$id.'/'.$key); ?>
	<span class="validation_error"><?php echo form_error('pass'); ?></span><label for="pass">New Password:</label>
	<input id="pass" name="pass" type="password" class="text" />
	<span class="validation_error"><?php echo form_error('passconf'); ?></span><label for="passconf">Confirm Password:</label>
	<input id="passconf" name="passconf" type="password" class="text" />
	<button type="submit" class="ok">Reset</button> <a class="button" href="<?php echo site_url('admin/login'); ?>">Back to Login</a>
<?php echo form_close(); ?>
