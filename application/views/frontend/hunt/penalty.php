<div class="timing">
  <div class="row">
    <div class="col-xs-5">
      <p>Stage <span class="num">25<?php //echo $total ?></span> of <span class="num">25<?php //echo $total ?></span></p>
    </div>
    <div class="col-xs-7">
      <div class="timeleft-wrap">
        <h3>Time left for this Task</h3>
        <div class="hunt-time-left">
          <form id="hunt-timer">
            <input value="" readonly="readonly" name="time_left" id="hunt-time-left">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="penality-timer penality-timer col-md-12 text-center" id="penality-timer"><input value="" readonly="readonly" name="penality-timer" id="hunt-penality-timer"></div>
<script type="application/javascript">
var hunttime = 2700; var elapsedPenTime=0;penaltyTimer();
function penaltyTimer() {
  var timeLeft = hunttime - elapsedPenTime;  
  elapsedPenTime += 1;
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) { 
		//submittask();$('#qawrap').show(); $('#penality-timer').hide();
  } else {	 
    $('#hunt-penality-timer').val(/*hours + ':' + */minutes + ':' + seconds);
    setTimeout('penaltyTimer()', 1000);
  }
}
<?php /*?>
var HUNT_TIME_LEFT = '<?php echo $penalty ?>'; 
var elapsedTime = 0;
$(function() {   huntTimer();
	 if (!$('#hunt-time-left').length   && HUNT_TIME_LEFT) {  huntTimer(); } 
});
function huntTimer() {
  var timeLeft = HUNT_TIME_LEFT - elapsedTime;  
  elapsedTime += 1;
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) {
	submittask();
  } else {	 
    $('#penality-timer').text(hours + ':' + minutes + ':' + seconds);
    setTimeout('huntTimer()', 1000);
  }
}<?php */?>
</script>