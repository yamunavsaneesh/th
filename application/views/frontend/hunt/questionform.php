<div class="qst-tab">
  <ul>
    <li class="active col-sm-12"><?php echo $segment ?></li>
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
