<div class="full_w">
	<div class="h_title">Edit User - Change Password</div>	
	<?php echo form_open('admin/admins/changepwd/'.$id.'/'.$return); ?>
	<input id="id" name="id" type="hidden" value="<?php echo $id; ?>" />		
		<div class="element">
			<label for="pass">Password <?php if(form_error('pass')){ $err=' err'; echo form_error('pass'); } else { $err=''; ?><span> (required)</span><?php } ?></label>
			<input id="pass" name="pass" type="password" class="text<?php echo $err; ?>" value="" />
		</div>
		<div class="element">
			<label for="passconf">Confirm Password <?php if(form_error('passconf')){ $err=' err'; echo form_error('passconf'); } else { $err=''; ?><span> (required)</span><?php } ?></label>
			<input id="passconf" name="passconf" type="password" class="text<?php echo $err; ?>" value="" />
		</div>
		<div class="entry">
			<button type="submit" class="add">Save</button><a class="button cancel" href="<?php echo site_url('admin/admins/lists/'.$return); ?>">Cancel</a>
		</div>
	<?php echo form_close(); ?>
</div>