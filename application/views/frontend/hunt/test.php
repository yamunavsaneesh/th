

<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery-3.1.1.min.js');?>"></script> 
<script type="text/javascript" src="<?php echo base_url('public/assets/js/jquery.runner-min.js');?>"></script> 
<script> 
$('#runner').runner({
    countdown: true,
    startAt: 30000,
    stopAt: 0
}).on('runnerFinish', function(eventObject, info) {
    alert('Finished!');
});
</script><div id="runner"></div>
<?php
// Upon starting the section
//session_start();
$time = strtotime("10:09") + 3600;
//echo '>>>>>>>>>>'.date('H:i', $time);
//$_SESSION['TIMER'] = time() + 2*3600+50*60; // Give the user Ten minutes
$str_time = "2:50";
sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
 // $_SESSION['TIMER'] = $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
//exit;
?> 
  <?php /*?><div id="timer"></div>
<div id ="stop_timer" onclick="clearInterval(timerVar)">Stop time</div><?php */?>
 <div id="showtimer"></div>
<label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
    <script type="text/javascript"> 
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var hoursLabel = document.getElementById("hours");
        var totalSeconds = 0;
        setInterval(setTime, 1000);
        function setTime()
        {
            ++totalSeconds;
            secondsLabel.innerHTML =seconds= pad(totalSeconds%60);
            minutesLabel.innerHTML =minute= pad(parseInt(totalSeconds/60));
  			hoursLabel.innerHTML = hour = pad(Math.floor(totalSeconds /3600));
			document.getElementById("showtimer").innerHTML= hour + ":" + minute + ":" + seconds;
        }
        function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }
		
		
		
/*var timerVar = setInterval(countTimer, 1000);
var totalSeconds = 0;
function countTimer() {
   ++totalSeconds;
   var hour = Math.floor(totalSeconds /3600);
   var minute = Math.floor((totalSeconds - hour*3600)/60);
   var seconds = totalSeconds - (hour*3600 + minute*60);
   document.getElementById("timer").innerHTML = hour + ":" + minute + ":" + seconds;
}*/
    </script>
    <?php /*?>
<script type="text/javascript">
var TimeLimit = new Date('<?php echo date('r', $_SESSION['TIMER']) ?>');
</script>
<script type="text/javascript">
function countdownto() {
  var date = Math.round((TimeLimit-new Date())/1000);
  var hours = Math.floor(date/3600);
  date = date - (hours*3600);
  var mins = Math.floor(date/60);
  date = date - (mins*60);
  var secs = date;
  if (hours<10) hours = '0'+hours;
  if (mins<10) mins = '0'+mins;
  if (secs<10) secs = '0'+secs;
  document.body.innerHTML = hours+':'+mins+':'+secs;
  setTimeout("countdownto()",1000);
  }
countdownto();
</script><?php */?>
</html>
