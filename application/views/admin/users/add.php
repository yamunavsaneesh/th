<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Manage Users</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/users/'.(isset($hunt) ? 'edit/'.$hunt->id : 'add'),array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <input id="id" name="id" type="hidden" value="<?php echo isset($hunt) ? set_value("id", $hunt->id) : set_value("id");  ?>" />
        <div class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group <?php echo form_error('firstname') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">First Name</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="firstname" value="<?php echo isset($hunt) ? set_value("firstname", $hunt->firstname) : set_value("firstname"); ?>" placeholder="First Name" class="form-control required">
                  </div>
                </div>
                <div class="form-group <?php echo form_error('lastname') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Last Name</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="lastname" value="<?php echo isset($hunt) ? set_value("lastname", $hunt->lastname) : set_value("lastname"); ?>" placeholder="Last Name" class="form-control required">
                  </div>
                </div>
                <div class="form-group <?php echo form_error('group_id') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Group</label>
                  <div class="col-md-7 col-sm-8">
                    <div class="input-group <?php echo form_error('group_id') ? 'has-error' : '' ?>">
                      <select class="select2" name="group_id">
                        <option value="">Select</option>
                        <?php if($groups) foreach($groups as $group):?>
                        <option value="<?php echo $group['id'] ?>" <?php echo set_select('group_id',$group['id'],isset($hunt)?($hunt->group_id==$group['id']?true:false):false); ?>><?php echo $group['name']; ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group <?php echo form_error('mobile') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Mobile</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="mobile" value="<?php echo isset($hunt) ? set_value("mobile", $hunt->mobile) : set_value("mobile"); ?>" placeholder="Mobile" class="form-control">
                  </div>
                </div>
                <div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">Email</label>
                  <div class="col-md-7 col-sm-8">
                    <input type="text" name="email" value="<?php echo isset($hunt) ? set_value("email", $hunt->email) : set_value("email"); ?>" placeholder="Email" class="form-control required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Gender</label>
                  <div class="col-md-7 col-sm-8">
                    <div class="radio radio-inline">
                      <input type="radio" name="gender" id="male" value="male" <?php echo isset($hunt) ? ($hunt->gender == 'male' ? 'checked': '') : (set_radio('gender', 'male',true)); ?>>
                      <label for="male"> Male </label>
                    </div>
                    <div class="radio radio-inline">
                      <input type="radio" name="gender" id="female" value="female" <?php echo isset($hunt) ? ($hunt->gender == 'female' ? 'checked': '') : (set_radio('gender', 'female',false)); ?>>
                      <label for="female"> Female </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <?php /*?><div class="form-group <?php echo form_error('shirtsize') ? 'has-error' : '' ?>">
                  <label class="col-md-4 control-label">T-Shirt Size</label>
                  <div class="col-md-7 col-sm-8">
                    <div class="input-group <?php echo form_error('shirtsize') ? 'has-error' : '' ?>">
                      <select class="select2" name="shirtsize">
                        <option value="">Select</option>
                        <?php $sizes = array('XXXS','XXS','XS','S','M','L','XL','XXL','XXXL'); foreach($sizes as $size):?>
                        <option value="<?php echo $size?>" <?php echo set_select('shirtsize',$size,isset($hunt)?($hunt->shirtsize==$size?true:false):false); ?>><?php echo $size; ?></option>
                        <?php endforeach;?>
                      </select>
                    </div> 
                  </div>
                </div><?php */?>
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
              <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-primary">Cancel</a> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div> 