<?php 
$statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">User Details</span></div>
        </div>
      </div>
      <div class="card-body">
        <div class="section">
          <div class="section-title">Name:
            <div class="section-body __indent"><?php echo $hunt->firstname.' '.$hunt->lastname ?></div>
          </div>
          <div class="section-title">Group:
            <div class="section-body __indent"><?php echo $groups[$hunt->group_id] ?></div>
          </div>
          <div class="section-title">Mobile:
            <div class="section-body __indent"><?php echo $hunt->mobile ?></div>
          </div>
          <div class="section-title">Email:
            <div class="section-body __indent"><?php echo $hunt->email ?></div>
          </div>
          <div class="section-title">Gender:
            <div class="section-body __indent"><?php echo $hunt->gender ?></div>
          </div>
          <div class="section-title">T-Shirt Size:
            <div class="section-body __indent"><?php echo $hunt->shirtsize ?></div>
          </div>
          <div class="section-title">Username:
            <div class="section-body __indent"><?php echo $hunt->username ?></div>
          </div>
          <div class="section-title">Status:
            <div class="section-body __indent"><?php echo $statusarray[$hunt->status] ?></div>
          </div>
          <div class="section-title">
            <div class="form-group"> <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-success">Back</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
