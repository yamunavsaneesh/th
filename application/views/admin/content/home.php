 <div class="row">
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Status</div>
        <ul class="card-action">
         <li> <a href="javascript:void(0)" id="refresh"> <i class="fa fa-refresh"></i> </a> </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive" id="report"> </div> 
    </div>
  </div>
  <?php /*?><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Group 2</div>
        <ul class="card-action">
            <li> <a href="<?php echo site_url('admin/groups') ?>" title="view more"> <i class="fa fa-chevron-circle-right"></i> </a> </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Question</th> 
              <th>Group</th> 
            </tr>
          </thead>
          <tbody>
             <?php if($users) foreach($users as $key => $user):?>
            <tr>
              <td><?php echo $user['firstname'].' '.$user['lastname'] ?></td>
              <td class="left"><?php echo $user['mobile'] ?></td>
              <td class="left"><?php echo $grouppairs[$user['group_id']] ?></td> 
            </tr> 
           <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div><?php */?>  
  
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Groups</div>
        <?php $activearr=array('Y'=>'Active','N'=>'Inactive');?>  <ul class="card-action">
          <li> <a href="<?php echo site_url('admin/groups') ?>" title="view more"> <i class="fa fa-chevron-circle-right"></i> </a> </li>
        </ul> 
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th>Group</th>
              <th >Users</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if($groups) foreach($groups as $key => $group):?>
            <tr>
              <td><?php echo $group['name'] ?></td>
              <td><?php echo $group['users'] ?></td>
              <td><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span><?php echo $activearr[$group['status']] ?></span></span></td>
            </tr> 
           <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Users</div>
        <ul class="card-action">
          <li> <a href="<?php echo site_url('admin/users'); ?>"> <i class="fa fa-chevron-circle-right"></i> </a> </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th>User</th>
              <th class="left">Mobile</th>
              <th>Group</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
             <?php if($users) foreach($users as $key => $user):?>
            <tr>
              <td><?php echo $user['firstname'].' '.$user['lastname'] ?></td>
              <td class="left"><?php echo $user['mobile'] ?></td>
              <td class="left"><?php echo $grouppairs[$user['group_id']] ?></td>
              <td><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span><?php echo $activearr[$user['status']] ?></span></span></td>
            </tr> 
           <?php endforeach;?>
           </tbody>
        </table>
      </div>
    </div>
  </div> 
</div>

<script>
$(function() {
	getstatus();	 		
	$("#refresh").click(function() {
		getstatus();
	});
});
function getstatus(){	
	$.ajax({ 
		url: '<?php echo site_url('admin/status/reportstatus');?>', success: function(html) {
			$("#report").empty().append(html);
		}
	});
}
</script> 