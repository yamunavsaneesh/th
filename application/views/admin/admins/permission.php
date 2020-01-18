<div class="full_w"> <?php echo form_open_multipart('admin/admins/permission'); ?>
  <div class="h_title">Manage Permisson - Access</div>
  <?php echo $this->session->flashdata('message'); ?>
  <table>
    <thead>
      <tr>
        <th scope="col" style="width: 20px;">ID</th>
        <th scope="col">Page</th>
        <th scope="col">Permission</th>
        <?php foreach($roles as $role): ?>
        <th scope="col"><?php echo $role['role']; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php  $i=0;foreach($permissions as $key => $permission): ?>
      <tr>
        <td class="align-center"><?php echo ++$i; ?></td>
        <td><?php echo $permission['page']; ?></td>
        <td><?php echo $permission['url']; ?></td>
        <?php 
		foreach($roles as  $role): 
			if(in_array($permission['permissions_id'],array_map('current',$access[$role['roles_id']])))
			$checked = 'checked';
			else
			$checked = '';
		?>
        <td align="center"><input type="checkbox" class="accessbox" name="roleid<?php echo $role['roles_id']; ?>[]" <?php echo $checked?> value="<?php echo $permission['permissions_id']; ?>" /></td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div align="right"><?php /*if(form_error('roleid[]')){ $err=' err'; echo form_error('roleid[]'); } else { $err=''; ?><span> (required)</span><?php } */?></div>
  <div class="entry">
    <button type="submit" class="add">Save Permission</button>
  </div>
  <?php echo form_close(); ?> 
</div>