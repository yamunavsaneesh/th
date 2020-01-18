<?php echo form_open_multipart('hunt/submit',array('class'=>'form taskform','id'=>'taskform')); ?>
<div class="task-wrap">
  <div class="timing">
    <div class="row">
      <div class="col-xs-5">
        <p>Stage <span class="num"><?php echo $tasks[$questions[0]['id']]  ?></span> of <span class="num" id="total"><?php echo $total ?></span></p>
      </div>
      <div class="col-xs-7">
        <p class="pen-wait text-right" style="display:none">Please wait.. will move next Question once penalty time is over</p>
        <div class="timeleft-wrap">
          <h3>Time left for this Task</h3>
          <div class="task-time-left">
            <input type="hidden" name="hunt_left" class="timeleftbox oatleft" id="hunttimer">
            <?php if($questions) foreach($questions as $key => $question): ?>
            <input value="" readonly="readonly" name="time_left" id="task-time-left">
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="qst-tab">
    <ul>
      <?php $vari=3+$segment; for($i=$segment+1;$i<=$vari;$i++): if($i <= $total){ ?>
      <li <?php echo ($segment+1 ==$i) ? 'class="active"':'' ?>><?php echo $i; ?></li>
      <?php } endfor;   ?>
    </ul>
  </div>
  <div class="clearfix"></div>
  <div class="qst-wrap" id="qawrap">
    <input type="hidden" name="start_time" id="start_time" value="<?php echo $start_time ?>"/>
    <input type="hidden" name="ispenality" id="ispenality" value="N"/>
    <?php if($questions) foreach($questions as $key => $question):  
		  $dur = explode(':',(/*isset($this->taskrecover['tasktimer'])? $this->taskrecover['tasktimer']:*/ $question['duration'])); 
		  $pen = explode(':',(/*isset($this->taskrecover['penalty'])? $this->taskrecover['penalty']:*/ $question['penalty'])); ?>
    <input type="hidden" name="question" id="question" value="<?php echo $question['id']; ?>"/>
    <input type="hidden" name="task" id="task" value="<?php echo $tasks[$question['id']]  ?>"/><?php /*?>
    <input type="hidden" name="hint" id="hint" value="<?php echo md5($answerpair[$question['id']]) ?>>"/><?php */?>
    <input type="hidden" name="duration" id="duration" value="<?php echo $dur[0]*3600+$dur[1]*60+$dur[2]?>" />
    <input type="hidden" name="penalty" id="penalty" value="<?php echo $pen[0]*3600+$pen[1]*60+$pen[2]?>" />
    <input type="hidden" name="penatly_time" id="penatly_time" value="<?php //echo $question['penalty'] ?>"/>
    <p><?php echo $question['question']; ?></p>
    <div class="input-group <?php echo form_error('answer') ? 'has-error' :''; ?>">
      <input type="text" name="answer" id="answer" placeholder="Enter your answer here" class="form-control required">
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-success btn-submit" id="btntask" value="Submit">
    </div>
    <?php endforeach;?>
  </div>
  <div class="penality-timer penality-timer col-md-12 text-center" id="penality-timer" style="display:none">
    <input value="" readonly="readonly" name="penality-timer" id="hunt-penality-timer">
  </div>
</div>
<?php echo form_close(); ?> 
<script type="application/javascript">
$(function() { 
  $("#taskform").validate({ 
  	errorPlacement: function(error, element) {}  
  });
  $("#taskform").submit(function(e){ 
    e.preventDefault();	
  });
});  
</script> 
<script type="application/javascript">
var tasktimeleft = $('#duration').val();
var penaltytimeleft= $('#penalty').val();  
var elapsedTime = 0; var elapsedPenTime = 0;
$(function() {
	taskTimer();
});
function taskTimer() { 
  var timeLeft = tasktimeleft - elapsedTime;  
  elapsedTime += 1; 
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) { 
	if($.trim($('#answer').val()) == ''){ 	
	 	if($('#task').val() < $.trim($('#total').text())){	
			showpenalty();
		}else{		
			$('#ispenality').val('Y');	 	
			$('#penatly_time').val('<?php echo $question['penalty'] ?>'); 
			submittask();				
		}
	 }else { 
		submittask();
	} 
  } else {	 
  //	tasklog();
    $('#task-time-left').val(hours + ':' + minutes + ':' + seconds);
    setTimeout('taskTimer()', 1000);
  }
}
function showpenalty()
{	
	$('#ispenality').val('Y');	 	
	$('#penatly_time').val('<?php echo $question['penalty'] ?>');		
	$('#qawrap').hide();
	$('#penality-timer').show();	 
    $('.timeleft-wrap').hide(); 
    $('.pen-wait').show();
 	penaltyTimer();
}
function penaltyTimer() {
  var timeLeft = penaltytimeleft- elapsedPenTime;  
  elapsedPenTime += 1;
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) { 
		$('#qawrap').show(); $('#penality-timer').hide();$('.timeleft-wrap').show();		
        $('.pen-wait').hide();
		submittask();
  } else {	
  //	tasklog();
    $('#hunt-penality-timer').val(/*hours + ':' + */minutes + ':' + seconds);
    setTimeout('penaltyTimer()', 1000);
  }
}
</script>