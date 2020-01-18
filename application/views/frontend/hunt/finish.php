<?php /*?><meta http-equiv="refresh" content="1;url=<?php echo site_url('hunt/success') ?>" /><?php */?>
<div class="timing">
  <div class="row">
    <div class="col-xs-5">
      <p>Stage <span class="num"><?php echo $total ?></span> of <span class="num"><?php echo $total ?></span></p>
    </div>
    <div class="col-xs-7">       
    </div>
  </div>
</div>
<p class="text-center start-txt">Congratulations....<br />
You have completed the Hunt.<br />
<span class="red">Please wait for the results...</span></p>
<script type="application/javascript">document.location.href = '<?php echo site_url('hunt/success') ?>';</script>