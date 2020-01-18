<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Manage Admins</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/admins/'.(isset($hunt) ? 'edit/'.$hunt->id : 'add'),array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <input id="id" name="id" type="hidden" value="<?php echo isset($hunt) ? set_value("id", $hunt->id) : set_value("id");  ?>" />
        <div class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Full Name</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="name" value="<?php echo isset($hunt) ? set_value("name", $hunt->name) : set_value("name"); ?>" placeholder="Full Name" class="form-control required">
                  </div>
                </div> 
                <div class="form-group <?php echo form_error('hunt_id') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Hunt</label>
                  <div class="col-md-7 col-sm-8">
                    <div class="input-group <?php echo form_error('hunt_id') ? 'has-error' : '' ?>">
                      <select class="select2" name="hunt_id">
                        <option value="">Select</option>
                        <?php if($hunts) foreach($hunts as $hnt):?>
                        <option value="<?php echo $hnt['id'] ?>" <?php echo set_select('hunt_id',$hnt['id'],isset($hunt)?($hunt->hunt_id==$hnt['id']?true:false):false); ?>><?php echo $hnt['name']; ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group <?php echo form_error('roles_id') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Role</label>
                  <div class="col-md-7 col-sm-8">
                    <div class="input-group <?php echo form_error('roles_id') ? 'has-error' : '' ?>">
                      <select class="select2" name="roles_id">
                        <option value="">Select</option>
                        <?php if($roles) foreach($roles as $role):?>
                        <option value="<?php echo $role['roles_id'] ?>" <?php echo set_select('roles_id',$role['roles_id'],isset($hunt)?($hunt->roles_id==$role['roles_id']?true:false):false); ?>><?php echo $role['role']; ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Email</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="email" value="<?php echo isset($hunt) ? set_value("email", $hunt->email) : set_value("email"); ?>" placeholder="Email" class="form-control required">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Username</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="username" value="<?php echo isset($hunt) ? set_value("username", $hunt->username) : set_value('username'); ?>" placeholder="Username" class="form-control required">
                  </div>
                </div>
                <div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Password</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="password" name="password" value="<?php echo set_value('password'); ?>" autocomplete="off" placeholder="Password" class="form-control required">
                  </div>
                </div>
                <div class="form-group <?php echo form_error('passwordconf') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Confirm Password</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="password" name="passwordconf" value="<?php echo set_value('passwordconf'); ?>" autocomplete="off" placeholder="Confirm Password" class="form-control required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Status</label>
                  <div class="col-md-7 col-sm-8">
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
          </div>
        </div>
        <div class="form-footer">
          <div class="form-group">
            <div class="col-md-7 col-sm-8 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="<?php echo site_url('admin/admins'); ?>" class="btn btn-primary">Cancel</a> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
