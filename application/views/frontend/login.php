<!DOCTYPE html>
<html>
<head> 
<?php echo $meta ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/vendor.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/main.css');?>">
</head>
<body class="body-bg">
<div class="app app-default">
  <div class="app-container app-login">
    <div class="flex-center">
      <div class="app-header"><img src="<?php echo base_url('public/assets/images/logo.png');?>" alt=""></div>
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
              <div class="app-brand"><span class="highlight">Login</span></div>
            </div>
            <?php echo $content?> </div>
        </div>
      </div>
      <?php echo $footer?> 
    </div>
  </div>
</div>
</body>
</html>