<!DOCTYPE html>
<html>
<head>
<?php echo $meta ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/vendor.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/main.css');?>">
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery-3.1.1.min.js');?>"></script> 
</head>
<body>
<div class="app app-default">
  <div class="app-container"> <?php echo $header ?> <?php echo $content ?> <?php //echo '<pre>'; print_r($this->taskrecover);?>
    <?php //echo $footer?>
  </div>
</div>  
<script type="text/javascript" src="<?php echo base_url('public/assets/js/bootstrap.min.js');?>"></script> 
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery.validate.min.js');?>"></script> 
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery.runner-min.js');?>"></script> 
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery.countdown.min.js');?>"></script> 
 <script>
$('#hunt-time-left').runner({
    countdown: false,
	autostart: true,
    startAt:0,//2(min) * 60(sec) * 1000(ms)
	milliseconds: false,
	format:'',
}).on('runnerFinish', function(eventObject, info) {
   // alert('The eggs are now hard-boiled!');
});
</script> 
<script type="application/javascript">
$(function() {     
	<?php if($this->router->fetch_class().'|'.$this->router->fetch_method() == 'hunt|start'){?> setInterval(huntTimer, 1000); <?php } 
	elseif($this->router->fetch_class().'|'.$this->router->fetch_method() == 'hunt|success'){ ?> 
	$('#hunt-time-left').val('<?php echo $this->alphasettings['HUNT_TIME'] ?>');<?php } 
	else{?> $('#hunt-time-taken').val('<?php echo $this->alphasettings['HUNT_TIME'] ?>');<?php } ?>
}); 
function pad(val) {
    return val > 9 ? val : "0" + val; 
}
//var timerVar = setInterval(huntTimer, 1000);var totalSeconds = 0;
function huntTimer() {
    var time_shown =  $("#hunt-time-left").val(); //'<?php // echo isset($this->taskrecover['hunttimer'])? $this->taskrecover['hunttimer']:'00:00:00' ?>';
    var time_chunks = time_shown.split(":");
    var hour, mins, secs;
	hour=Number(time_chunks[0]);
	mins=Number(time_chunks[1]);
	secs=Number(time_chunks[2]);
	secs++;
	if (secs==60){
	secs = 0;
	mins=mins + 1;
	} 
	if (mins==60){
	mins=0;
	hour=hour + 1;
	}
	if (hour==13){
	hour=1;
	}
	$("#hunt-time-left").val(pad(hour) +":" + pad(mins) + ":" + pad(secs));
	$("#hunttimer").val(pad(hour) +":" + pad(mins) + ":" + pad(secs));
  /* ++totalSeconds;
   var hour = pad(Math.floor(totalSeconds /3600));
   var minute = pad(Math.floor((totalSeconds - hour*3600)/60));
   var seconds = pad(totalSeconds - (hour*3600 + minute*60));// pad(totalSeconds%60);
  $("#hunt-time-left").val(hour + ":" + minute + ":" + seconds);
  $("#hunttimer").val(hour + ":" + minute + ":" + seconds);*/
}
</script>
</body>
</html>