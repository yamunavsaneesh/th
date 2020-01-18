<section>
  <div class="container-fluid">
    <h2 class="text-center main-title">Welcome to <?php echo $hunt->name ? $hunt->name : 'TREASURE HUNT '.date('Y')?></h2>
    <br>
    <br>
    <p class="text-center start-txt" data-text="Please wait...">Please wait...<br>
      <span>TREASURE HUNT</span> will start soon</p>
      <p class="text-center"><a class="btn btn-success" href="<?php echo site_url('hunt/start') ?>">Start Hunt</a></p>
  </div>
</section>
