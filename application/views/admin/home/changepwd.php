<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="card">
    <div class="app-heading">
      <div class="app-title">
        <p class="mt30">&nbsp;</p>
        <div class="title"><span class="highlight">Change Password</span></div>
      </div>
    </div>
    <div class="card-body"> <?php echo form_open('admin/home/changepwd/',array('class' => 'form-settings')); ?>
      <div class="section">
          <div class="section-body">
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <label  class="control-label" for="passold">Old Password <?php echo  form_error('passold'); ?>
                <?php if(form_error('passold')){ $err=' has-error';  } else { $err=''; ?> 
                <?php } ?>
              </label>
              <div class="input-group">
                <input id="passold" name="passold" type="password" class="form-control <?php echo $err; ?>" value="" />
              </div>
            </div>
            <div class="form-group">
              <label  class="control-label" for="pass">Password <?php echo  form_error('pass'); ?>
                <?php if(form_error('pass')){ $err=' has-error';  } else { $err=''; ?> 
                <?php } ?>
              </label>
              <div class="input-group">
                <input id="pass" name="pass" type="password" class="form-control <?php echo $err; ?>" value="" />
              </div>
            </div>
            <div class="form-group">
              <label  class="control-label" for="passconf">Confirm Password <?php echo  form_error('passconf');  ?>
                <?php if(form_error('passconf')){ $err=' has-error'; } else { $err=''; ?> 
                <?php } ?>
              </label>
              <div class="input-group">
                <input id="passconf" name="passconf" type="password" class="form-control <?php echo $err; ?>" value="" />
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group  pull-right">
                <button type="submit" class="btn btn-success">Save</button>
                <a class="btn btn-primary" href="<?php echo site_url('admin/home/'); ?>">Cancel</a> </div>
            </div>
          </div>
        </div>
      </div>
          </div>
        </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>
