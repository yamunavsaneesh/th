<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Edit User</h3>
    </div>
    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
          </span> </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>User Details <small></small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a> </li>
                <li><a href="#">Settings 2</a> </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content"> <?php echo form_open_multipart('admin/admins/edit/'.$user->id.'/'.$return,array('class'=>'form-horizontal','id'=>'obj-form')); ?>
	<input id="id" name="id" type="hidden" value="<?php echo $user->id; ?>" />	
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Full Name <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12has-feedback">
              <input type="text" id="first-name" name="name" value="<?php echo $user->name; ?>" required="required" class="form-control has-feedback-left" placeholder="Full Name">
              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
          </div><div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12has-feedback"> 
              <input type="text" id="username" name="username" value="<?php echo $user->username; ?>" class="form-control has-feedback-left required" placeholder="Username">
              <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('gender') ? 'red' : '' ?>">Gender <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="gender" class="btn-group" data-toggle="buttons">
                <label class="btn btn-default <?php echo $user->gender == 'male' ?'active':'' ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" class="required" name="gender" value="male" <?php echo $user->gender == 'male' ?'checked="checked"':'' ?>>
                  &nbsp; Male &nbsp; </label>
                <label class="btn btn-default <?php echo $user->gender == 'female' ?'active':'' ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" class="required" name="gender" value="female" <?php echo $user->gender == 'female' ?'checked="checked"':'' ?>>
                  Female </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('address') ? 'red' : '' ?>" for="last-name">Address </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="address" name="address" class="form-control col-md-7 col-xs-12"><?php echo $user->address; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('location') ? 'red' : '' ?>" for="last-name">Location </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="location" name="location" class="form-control col-md-7 col-xs-12" value="<?php echo $user->location ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('phone') ? 'red' : '' ?>" for="last-name">Phone </label>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              <input type="text" id="phone" name="phone" class="form-control has-feedback-left" value="<?php echo $user->phone ?>"  placeholder="e.g. 971 123 45678">
              <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('email') ? 'red' : '' ?>" for="last-name">Email <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              <input type="text" id="email" name="email" class="form-control has-feedback-left email" placeholder="Email" value="<?php echo $user->email ?>">
              <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span> </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12 <?php echo form_error('role') ? 'red' : '' ?>" for="role">Role <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="roles_id" id="roles_id" class="form-control required">
                <option value="">----------Select-----------</option>
                <?php foreach($roles as $role): ?>
                <option value="<?php echo $role['roles_id']; ?>" <?php if($user->roles_id==$role['roles_id']){ echo 'selected="selected"'; }?>><?php echo $role['role']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div id="status" class="btn-group" data-toggle="buttons">
                <label class="btn <?php echo ($user->status == 'Y')? 'btn-primary active' :'btn-default' ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="status" value="Y" <?php echo set_radio('status', 'Y',($user->status == 'Y')?true:false); ?> />
                  &nbsp;Enabled &nbsp; </label>
                <label class="btn  <?php echo ($user->status == 'N')? 'btn-primary active' :'btn-default' ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="status" value="N" <?php echo set_radio('status', 'N',($user->status == 'N')?true:false); ?> />
                  &nbsp; Disabled &nbsp; </label>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group  pull-right"> <a href="<?php echo site_url('admin/admins'); ?>" class="btn btn-primary">Cancel</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {	
	$('#obj-form').validate();	
});
</script>