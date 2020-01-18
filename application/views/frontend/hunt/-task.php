<?php 
$tasks = array();
if($qas) foreach($qas as $key => $qus):
$tasks[$qus['id']] = $key+1; 
//echo '<br />'.($key+1).'-'.$qus['question'];
endforeach; 
?>
<div class="timing">
  <div class="row">
    <div class="col-xs-5">
      <p>Stage <span class="num"><?php echo $segment>0?$segment+1:1  ?></span> of <span class="num"><?php echo $total ?></span></p>
    </div>
    <div class="col-xs-7">
      <div class="timeleft-wrap">
        <h3>Time left for this Task</h3>
        <div class="hunt-time-left">
          <form id="hunt-timer"> <?php if($questions) foreach($questions as $key => $question): 
		  $dur = explode(':',$question['duration']); $pen = explode(':',$question['penalty']); ?>
            <input value="" readonly="readonly" name="time_left" id="hunt-time-left">
            <input type="hidden" name="duration" id="duration" value="<?php echo $dur[0]*3600+$dur[1]*60+$dur[2]?>" />
            <input type="hidden" name="penalty" id="penalty" value="<?php echo $pen[0]*3600+$pen[1]*60+$pen[2]?>" />
             <?php endforeach;?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="qst-tab">
  <ul>
    <?php /*?><?php echo $segment>1 ? '<li>'.($segment-1).'</li>':''; ?> 
	<?php  echo $this->pagination->create_links(); ?>
    <?php if ($segment<2) { ?>
   <li>2</li>
   <li>3</li>
    <?php }  else if($segment < $total) {   ?>
    <li><?php echo ++$segment ; ?></li>
    <?php }?>
      <?php echo ($segment>1) ? '<li>'.($segment-1).'</li>':''; ?><?php */?>
    <?php /*?> <?php if($questions) foreach($questions as $key => $question):?>
      <li class="active"><?php echo $current = $tasks[$question['id']];  ?></li>
      <?php endforeach;?>  
    <li><?php echo $current+1 ?></li>
    <?php echo ($segment<1 && $segment <= $total) ? '<li>'.($current+2).'</li>':''; ?><?php */?>
    <?php   $vari=3+$segment; for($i=$segment+1;$i<=$vari;$i++): if($i <= $total){ ?>
	<li <?php echo ($segment+1 ==$i) ? 'class="active"':'' ?>><?php echo $i; ?></li>
	<?php } endfor;   ?>
  </ul>
</div>
<div class="clearfix"></div>
<div class="qst-wrap" id="qawrap"> 
  <?php echo form_open_multipart('hunt/submit',array('class'=>'form taskform','id'=>'taskform')); ?>
  <input type="hidden" name="penality" id="penality" value="N"/>
  <input type="hidden" name="taken_time" id="taken_time" value=""/>
  <input type="hidden" name="penatly_time" id="penatly_time" value=""/>
  <?php if($questions) foreach($questions as $key => $question):?>
  <input type="hidden" name="question" value="<?php echo $question['id']; ?>"/>
  <input type="hidden" name="task" id="task" value="<?php echo $tasks[$question['id']]  ?>"/>
  <p><?php echo $question['question']; ?></p>
  <div class="input-group <?php echo form_error('answer') ? 'has-error' :''; ?>">
    <input type="text" name="answer" id="answer" placeholder="Enter your answer here" class="form-control required">
  </div>
  <div class="text-center">
    <input type="submit" class="btn btn-success btn-submit" id="btntask" value="Submit">
  </div>
  <?php endforeach;?>
  <?php echo form_close(); ?> </div>
  <div class="penality-timer penality-timer col-md-12 text-center" id="penality-timer" style="display:none"><input value="" readonly="readonly" name="penality-timer" id="hunt-penality-timer"></div>
<script type="application/javascript">
$(function() { 
$("#taskform").validate({ errorPlacement: function(error, element) {} });
  $("#taskform").submit(function(e){	  
    e.preventDefault();
  });
}); 
</script>
<script type="application/javascript">
var HUNT_TIME_LEFT = $('#duration').val();
var tasktime = $('#penalty').val(); // '<?php //echo  2*3600+50*60;//2700 ?>'; 
var elapsedTime = 0; var elapsedPenTime = 0;
$(function() {   
	huntTimer();
	//if (!$('#hunt-time-left').length   && HUNT_TIME_LEFT) {  huntTimer(); } 
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
	if($.trim($('#answer').val()) == ''){ 
		showpenalty();
	}else { 
		submittask();
	}
  // alert('Your exam has timed out. You will now be redirected to the exam submission screen.');
	
    // If we're in ajax mode, submit via ajax - otherwise, redirect to the completion page
   /* if (jQuery('#exam-ui').length) {
      finishExam(false);
    } else {
      document.location.href = 'complete?id=' + EXAM_REQUEST_ID;
    }*/
  } else {	 
    $('#hunt-time-left').val(hours + ':' + minutes + ':' + seconds);
    setTimeout('huntTimer()', 1000);
  }
}
function showpenalty()
{	
	$('#qawrap').hide();$('#penality-timer').show();	
    $('.timeleft-wrap').hide();
 	penaltyTimer();
}
function penaltyTimer() {
  var timeLeft = tasktime - elapsedPenTime;  
  elapsedPenTime += 1;
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var hours = Math.floor(minutes / 60);
  var minutes = minutes % 60;
  if (hours < 10) { hours = '0' + hours; }
  if (minutes < 10) { minutes = '0' + minutes; }
  if (seconds < 10) { seconds = '0' + seconds; }  
  if (timeLeft <= 0) { 
		$('#qawrap').show(); $('#penality-timer').hide();$('.timeleft-wrap').show();submittask();
  } else {	 
    $('#hunt-penality-timer').val(/*hours + ':' + */minutes + ':' + seconds);
    setTimeout('penaltyTimer()', 1000);
  }
}
</script>