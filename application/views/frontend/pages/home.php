<section>
  <div class="container-fluid">
    <h2 class="text-center main-title">Welcome to <?php echo $hunt->name ? $hunt->name : 'TREASURE HUNT '.date('Y')?></h2>
    <br>
    <br>
    <div class="qst-wrap" id="qawrap"> <?php echo form_open_multipart('home',array('class'=>'form huntform','id'=>'huntform')); ?>
      <p>Enter code to begin <?php echo form_error('code')?></p> 
      <div class="input-group <?php echo form_error('code') ? 'has-error' :''; ?>">
        <input type="text" name="code" id="code" placeholder="Enter code here" value="<?php echo set_value('code') ?>" class="form-control required">
      </div>
      <div class="text-center">
        <input type="submit" class="btn btn-success btn-submit" id="btntask" value="Submit">
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</section>
<?php /*echo '<pre>'; print_r($_SESSION);
$to_time = strtotime("04:09:37");
$from_time = strtotime("04:06:37");
$time_diff = $to_time - $from_time;
//echo gmdate('H:i:s', $time_diff);*/?>