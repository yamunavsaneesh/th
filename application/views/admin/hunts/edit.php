<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Hunts</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/hunts/add',array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <div class="section">
          <div class="section-body">
            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Title</label>
              <div class="col-md-9">
                <input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Title" class="form-control required">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3">
                <label class="control-label">Logo</label>
              </div>
              <div class="col-md-9">
                <input id="logo" class="form-control" type="file" placeholder="Logo" name="logo">
              </div>
            </div>
            <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Email</label>
              <div class="col-md-9">
                <input type="text" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Username</label>
              <div class="col-md-9">
                <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Password</label>
              <div class="col-md-9">
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('passwordconf') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Confirm Password</label>
              <div class="col-md-9">
                <input type="password" name="passwordconf" value="<?php echo set_value('passwordconf'); ?>" placeholder="Confirm Password" class="form-control required">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-9">
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio10" value="Y" checked>
                  <label for="radio10"> Active </label>
                </div>
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio11" value="N" >
                  <label for="radio11"> Deactive </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-footer">
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button> <a href="<?php echo site_url('admin/business/branches'); ?>" class="btn btn-primary">Cancel</a>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
	$('#pass-form').validate(); 
});
</script>