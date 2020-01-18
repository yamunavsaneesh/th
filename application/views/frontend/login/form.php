<?php echo form_open('login',array('class'=>"formlogin")); ?>
<div class="text-center" ><?php echo form_error('login') ; ?></div>
<div class="input-group <?php echo form_error('login') ? 'has-error' :''; ?>"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i></span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="login">
</div>
<div class="input-group <?php echo form_error('pass') ? 'has-error' :'';; ?>"> <span class="input-group-addon" id="basic-addon2"> <i class="fa fa-key" aria-hidden="true"></i></span>
  <input type="password" name="pass" class="form-control" placeholder="Password" aria-describedby="basic-addon2" >
</div>
<div class="text-center">
  <input type="submit" name="submit" class="btn btn-success btn-submit" value="Login">
</div>
<?php echo form_close(); ?>