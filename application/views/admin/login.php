<!DOCTYPE html>
<html>
<head>
<title><?php echo $this->config->item('admin_title'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/css/vendor.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/css/flat-admin.css');?>"> 
</head>
<body>
<div class="app app-default">
  <div class="app-container app-login">
    <div class="flex-center">
      <div class="app-header"></div>
      <div class="app-body">
        <div class="loader-container text-center">
          <div class="icon">
            <div class="sk-folding-cube">
              <div class="sk-cube1 sk-cube"></div>
              <div class="sk-cube2 sk-cube"></div>
              <div class="sk-cube4 sk-cube"></div>
              <div class="sk-cube3 sk-cube"></div>
            </div>
          </div>
          <div class="title">Logging in...</div>
        </div>
        <div class="app-block">
          <div class="app-form">
            <div class="form-header">
              <div class="app-brand"><span class="highlight">Web</span> Admin</div>
            </div>
            <div id="login"><?php echo $content; ?></div>
            <div id="register" class="hide"> <?php echo form_open('admin/login/forgot'); ?> <?php echo form_error('login'); ?>
              <h1>Reset Password</h1>
              <div class="input-group"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i></span>
                <input class="form-control" placeholder="Password" required  name="login" id="username" type="text"/>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-success btn-submit">Submit</button>
              </div>
              <div class="clearfix"></div>
              <div class="_separator">
                <p class="change_link">Already a member ? <a href="#tologin" class="to_register"> Log in </a> </p>
                <div class="clearfix"></div>
                <br />
                <div>
                  <p>&copy;<?php echo date('Y');?> All Rights Reserved. <?php echo $this->config->item('site_name'); ?> </p>
                </div>
              </div>
              <?php echo form_close(); ?> 
              <!-- form --> 
            </div>
          </div>
        </div>
      </div>
      <div class="app-footer"> </div>
    </div>
  </div>
</div> 
<?php /*?><script type="text/javascript" src="<?php echo base_url('public/admin/js/jquery-3.1.1.min.js');?>"></script> 
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/bootstrap.min.js');?>"></script> 
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/select2.full.min.js');?>"></script>  
<script type="text/javascript">$(document).ready(function() {  $("select").select2();});</script><?php */?>
</body>
</html>
