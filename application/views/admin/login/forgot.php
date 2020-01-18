<div class="wrap-login">
  <h4>Reset Password</h4>
  <?php echo form_open('admin/login/forgot'); ?>
  <div class="input-group <?php echo form_error('login') ? 'has-error' :''; ?>"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i></span>
    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="login">
  </div>
  <div class="button-login">
    <button type="submit" class="btn btn-success"><i class="icon-ok"></i>Reset</button>
    <a class="btn btn-success" href="<?php echo site_url('admin/login'); ?>"> Back to Login</a> </div>
  <?php echo form_close(); ?> </div>
