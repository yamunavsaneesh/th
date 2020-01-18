<?php echo form_open('admin/signin',array('class'=>"form-login")); ?> 
<div class="input-group <?php echo form_error('huntkey') ? 'has-error' :''; ?>"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-tag" aria-hidden="true"></i></span>
  <input type="text" class="form-control" placeholder="Hunt ID" aria-describedby="basic-addon1" name="huntkey">
</div>
<div class="input-group <?php echo form_error('login') ? 'has-error' :''; ?>"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i></span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="login">
</div>
<div class="input-group <?php echo form_error('pass') ? 'has-error' :'';; ?>"> <span class="input-group-addon" id="basic-addon2"> <i class="fa fa-key" aria-hidden="true"></i></span>
  <input type="password" name="pass" class="form-control" placeholder="Password" aria-describedby="basic-addon2" >
</div>
<div class="text-center">
  <input type="submit" name="submit" class="btn btn-success btn-submit" value="Login">
  <a class="reset_pass" href="<?php echo site_url('admin/login/forgot');?>">Lost your password?</a>
  <input id="language" name="language" type="hidden" class="text" value="<?php echo $langs[0]['code']; ?>" />
</div> 
<?php echo form_close(); ?>