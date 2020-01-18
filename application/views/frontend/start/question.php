<?php echo form_open('start/question',array('class'=>'form taskform','id'=>'taskform')); ?>
<div class="huntwrap">
  <div class="timing">
    <div class="row">
      <div class="col-xs-5">
        <p>Stage <span class="num"><?php echo $tasks[$questions[0]['id']] ;//$segment ?></span> of <span class="num"><?php echo $total ?></span></p>
      </div>
      <div class="col-xs-7">
        <div class="timeleft-wrap">
          <h3>Time left for this Task</h3>
          <div class="task-time-left" id="task-time-left">
          <?php /*?><input value="" readonly="readonly" name="time_left" id="task-time-left"><?php */?> </div>
        </div>
      </div>
    </div>
  </div>
  <div id="questionwrap">
    <div class="qst-tab">
      <ul>
        <li class="active col-sm-12"><?php echo $tasks[$questions[0]['id']] ?></li>
      </ul>
    </div>
    <div class="clearfix"></div>
    <div class="qst-wrap">
      <?php if($questions) foreach($questions as $key => $question):  ?>
      <p><?php echo $question['question'] ?></p>
      <input type="hidden" name="question" id="question" value="<?php echo $question['id']; ?>"/>
      <input type="hidden" name="start_time" value="<?php echo $now; ?>"/>
      <input type="hidden" name="task" value="<?php echo $tasks[$question['id']]  ?>"/>
      <label><?php echo form_error('answer') ?></label>
      <input type="text" placeholder="Enter your answer here" name="answer" class="form-control">
      <?php endforeach;?>
      <div class="text-center">
        <input type="submit" class="btn btn-success btn-submit" value="Submit" id="btntask">
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>
</div>
<script type="application/javascript">
$('#task-time-left').countdown('<?php echo strtotime($tasklog->end_time); ?>')
   // .on('update.countdown', callback)
   // .on('finish.countdown', gopenalty)
   ;
<?php /*?>

$('#task-time-left').runner({
    countdown: true,
	autostart: true,
    startAt: <?php echo strtotime($tasklog->start_time); ?>,//2(min) * 60(sec) * 1000(ms)
	milliseconds: false,
    stopAt: <?php echo strtotime($tasklog->end_time); ?> ,	
    interval: 1000
}).on('runnerFinish', function(eventObject, info) {
   
}); <?php */?>
$(function() { 
  $("#taskform").validate({ 
  	errorPlacement: function(error, element) {}  
  });
  $("#taskform").submit(function(e){ 
    e.preventDefault();	
  });
});  
</script> 