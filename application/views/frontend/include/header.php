<header>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-6">
        <div class="logo"><img src="<?php echo base_url('public/assets/images/logo.png');?>" alt="" class="img-responsive"></div>
      </div>
      <div class="col-xs-6">
        <div class="time-left-wrap pull-right">
          <?php if($this->router->fetch_class().'|'.$this->router->fetch_method() == 'start|index'){?>
          <p class="text-right all-time"><strong>Overall Time</strong> <br>
            <span class="alltime">
            <input value="<?php echo isset($this->taskrecover['hunttimer'])? $this->taskrecover['hunttimer']:'00:00:00' ?>" readonly="readonly" name="time_left" class="timeleftbox oatleft" id="hunt-time-left">
            <small></small></span> </p>
          <?php } else if($this->router->fetch_class().'|'.$this->router->fetch_method() == 'fishish|index'){?>
          <p class="text-right all-time"><strong>Total Time Taken</strong> <br>
            <span class="alltime">
            <input value="<?php echo isset($timetaken) ? $timetaken:'' ?>" readonly="readonly" name="time_left" class="timeleftbox oatleft" id="hunt-time-taken">
            <small></small></span> </p>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</header>
