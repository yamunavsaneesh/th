<!DOCTYPE html>
<html>
<head>
<?php echo $meta ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/vendor.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/assets/css/main.css');?>">
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery-3.1.1.min.js');?>"></script>
<script language="javascript"> window.onbeforeunload = function () {
   // return "Do you really want to close?";   
};</script>
</head>
<body> <input type="text" readonly="readonly" name="time_left" class="timeleftbox oatleft" id="timer">
<div class="app app-default">
  <div class="app-container"> <?php echo $header ?> <?php echo $content ?>
    <?php //echo $footer?>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/assets/js/bootstrap.min.js');?>"></script> 
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery.validate.min.js');?>"></script> 
<script type="application/javascript">
$(function() {    huntTimer();
	<?php if($this->router->fetch_class().'|'.$this->router->fetch_method() == 'hunt|start'){?> <?php } 
	elseif($this->router->fetch_class().'|'.$this->router->fetch_method() == 'hunt|success'){ ?> 
	$('#hunt-time-left').val('<?php echo $this->alphasettings['HUNT_TIME'] ?>');<?php } 
	else{?> $('#hunt-time-taken').val('<?php echo $this->alphasettings['HUNT_TIME'] ?>');<?php } ?>
});
var totalSeconds = 0;
function huntTimer() { 
	 	//++secvar seconds = pad(sec%60); 	var minutes = pad(parseInt(sec/60));  	var hours   = pad(Math.floor(sec/3600)); $('#hunt-time-left').val(hours + ':' + minutes + ':' + seconds);
   ++totalSeconds;
   var hours = Math.floor(totalSeconds /3600);
   var minutes = Math.floor((totalSeconds - hours*3600)/60);
   var seconds = totalSeconds - (hours*3600 + minutes*60);
 //  $('#hunt-time-left-').val(pad(hours) + ':' + pad(minutes) + ':' + pad(seconds));
}
setInterval(huntTimer(),1000);
function pad(val) {
    return val > 9 ? val : "0" + val;
	/* var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
	*/
}
var timerVar = setInterval(countTimer, 1000);
var totalSeconds = 0;
function countTimer() {
   ++totalSeconds;
   var hour = pad(Math.floor(totalSeconds /3600));
   var minute = pad(Math.floor((totalSeconds - hour*3600)/60));
   var seconds = pad(totalSeconds%60);// pad(totalSeconds - (hour*3600 + minute*60));
  $("#timer").val(hour + ":" + minute + ":" + seconds);
}
<?php /*?>var HUNT_TIME_LEFT = $('#duration').val();
var hunttime = '<?php echo  $hunttime ?>'; 
var elapsedHTime = 0;  
function huntTimer() { 
 // autosave();
  var timeLeft = hunttime - elapsedHTime;  
  elapsedHTime += 1; 
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) { 
		location.href='<?php echo site_url('hunt/finish'); ?>'//finishtask(); 	 
  } else {	 
    $('#hunt-time-left').val(hours + ':' + minutes + ':' + seconds);
    setTimeout('huntTimer()', 1000);
  }
}
 <?php */?>
</script>
</body>
</html>