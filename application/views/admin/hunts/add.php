<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Manage Hunts</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/hunts/'.(isset($hunt) ? 'edit/'.$hunt->id : 'add'),array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <input id="id" name="id" type="hidden" value="<?php echo isset($hunt) ? set_value("id", $hunt->id) : set_value("id");  ?>" />
        <div class="section">
          <div class="section-body">
            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Title</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" id="name" name="name" value="<?php echo isset($hunt) ? set_value("name", $hunt->name) : set_value("name"); ?>" placeholder="Title" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Login Key</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" id="huntkey" name="huntkey" value="<?php echo isset($hunt) ? set_value("huntkey", $hunt->huntkey) : $huntkey; ?>" readonly class="form-control required">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3">
                <label class="control-label">Logo</label>
              </div>
              <div class="col-md-3 pull-right"><?php if(isset($hunt) ){  echo ($hunt->logo !='') ? '<img src="'.base_url('public/uploads/logos/'.$hunt->logo).'" height="50"  width="50" class="img-circle">':'<div class="icon"></div>';} ?>
              </div>
              <div class="col-md-3">
                <input id="logo" class="form-control" type="file" placeholder="Logo" name="logo">
              </div>
            </div>
            <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Email</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" name="email" value="<?php echo isset($hunt) ? set_value("email", $hunt->email) : set_value("email"); ?>" placeholder="Email" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Username</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" name="username" value="<?php echo isset($hunt) ? set_value("username", $hunt->email) : set_value('username'); ?>" placeholder="Username" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Password</label>
              <div class="col-md-6 col-sm-9">
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" autocomplete="off" placeholder="Password" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('passwordconf') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Confirm Password</label>
              <div class="col-md-6 col-sm-9">
                <input type="password" name="passwordconf" value="<?php echo set_value('passwordconf'); ?>" autocomplete="off" placeholder="Confirm Password" class="form-control required">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-6 col-sm-9">
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio10" value="Y" <?php echo isset($hunt) ? ($hunt->status == 'Y' ? 'checked': '') : (set_radio('status', 'Y',true)); ?>>
                  <label for="radio10"> Active </label>
                </div>
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio11" value="N" <?php echo isset($hunt) ? ($hunt->status == 'N' ? 'checked': '') : (set_radio('status', 'N',false)); ?>>
                  <label for="radio11"> Deactive </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-footer">
          <div class="form-group">
            <div class="col-md-6 col-sm-9 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="<?php echo site_url('admin/hunts'); ?>" class="btn btn-primary">Cancel</a> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div> 