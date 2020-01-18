<?php 
$statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">Question Details</span></div>
        </div>
      </div>
      <div class="card-body">
        <div class="section">
          <div class="section-title">Question:
            <div class="section-body __indent"><?php echo $hunt->question ?></div>
          </div>
          <div class="section-title">Location:
            <div class="section-body __indent"><?php echo $hunt->location ?></div>
          </div>
          <div class="section-title">Answer:
            <div class="section-body __indent"><?php echo $hunt->answer ?></div>
          </div> 
          <div class="section-title">Status:
            <div class="section-body __indent"><?php echo $statusarray[$hunt->status] ?></div>
          </div>
          <div class="section-title">
            <div class="form-group"> <a href="<?php echo site_url('admin/qas'); ?>" class="btn btn-success">Back</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
