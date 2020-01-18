<?php 
$statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">Group Details</span></div>
        </div>
      </div>
      <div class="card-body">
        <div class="section"> 
            <div class="section-title">Name:
              <div class="section-body __indent"><?php echo $hunt->name ?></div>
            </div>
            <div class="section-title">Details:
              <div class="section-body __indent"><?php echo $hunt->short_desc ?></div>
            </div>
            <div class="section-title">No. of Users:
              <div class="section-body __indent"><?php if ($users>0) {?><a href="#" title="Users" data-users="<?php echo site_url('admin/groups/users/'.$hunt->id) ?>"><?php echo $users;?></a><?php } else {?>0<?php }?></div>
            </div>
            <div class="section-title">Status:
              <div class="section-body __indent"><?php echo $statusarray[$hunt->status] ?></div>
            </div>
            <div class="section-title">
              <div class="form-group"> <a href="<?php echo site_url('admin/groups'); ?>" class="btn btn-success">Back</a> </div>
            </div> 
        </div>
      </div>
    </div>
  </div>
</div>
