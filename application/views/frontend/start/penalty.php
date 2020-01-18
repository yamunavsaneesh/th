<div class="huntwrap">
  <div class="timing">
    <div class="row">
      <div class="col-xs-5">
        <p>Stage <span class="num"><?php echo $tasks[$question->id] ; ?></span> of <span class="num"><?php echo $total ?></span></p>
      </div>
      <div class="col-xs-7">
        <p class="pen-wait text-right">Please wait.. will move next Question once penalty time is over</p>
      </div>
    </div>
  </div>
   <div class="penality-timer penality-timer col-md-12 text-center" id="penalty-time-left"><?php /*?>
    <input value="" readonly="readonly" name="penality-timer" id="hunt-penality-timer"><?php */?>
    <input type="hidden" name="task" id="task" value="<?php echo $tasks[$question->id]  ?>"/>
  </div>
</div>
<div class="penality-timer penality-timer col-md-12 text-center" id="penality-timer"><input value="" readonly="readonly" name="penality-timer" id="hunt-penality-timer"></div>
<script type="application/javascript">
$('div#penalty-time-left').countdown('<?php echo strtotime($tasklog->end_time); ?>')
   // .on('update.countdown', callback)
  //  .on('finish.countdown', startquestion);
</script>