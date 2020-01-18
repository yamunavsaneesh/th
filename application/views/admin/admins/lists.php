<?php
$statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
$activearr=array('Y'=>'Active','N'=>'Deactive');
  
if($this->uri->segment(4)=="" || $this->uri->segment(4)==0){
	$i=0;
	$return=0;
}else{
	$i=$this->uri->segment(5); 
	$return=$this->uri->segment(5); 
}
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">Administrators</span></div>
        </div>
      </div>
      <div class="card-body no-padding"> <?php echo form_open('admin/admins/actions'); ?>
        <div class="content">
          <div class="card-header card-title action-wrap"><a href="<?php echo site_url('admin/admins/add/'); ?>" class="btn btn-info btn-sm" title="Add New"><i class="fa fa-plus"></i></a>
            <button class="btn btn-success btn-sm" type="submit" name="enable"  value="Activate" title="Activate"><i class="fa fa-check"></i></button>
            <button class="btn btn-warning btn-sm" type="submit" name="disable" value="Deactivate" title="Deactivate"><i class="fa fa-close"></i></button>
            <button class="btn btn-danger btn-sm" type="submit" name="delete" value="Delete" onclick="return confirmDelete();" title="Delete"><i class="fa fa-trash"></i></button>
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo $this->session->flashdata('message'); ?> </div>
          <div class="clearfix"></div>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                <tr class="headings">
                  <th  width="3%"><div class="checkbox checkbox-inline">
                      <input type="checkbox" id="check-all" class="flat chkall">
                      <label for="check-all"> </label>
                    </div></th>
                  <th scope="col" style="width: 20px;">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Username</th>
                  <th scope="col">Role</th>
                  <th width="5%">Status </th>
                  <th width="5%">Action </th>
                </tr>
              </thead>
              <tbody>
                <?php if($users) foreach($users as $key => $user): ?>
                <tr class="even pointer">
                  <td class="a-center"><div class="checkbox checkbox-inline">
                      <input type="checkbox" id="chk<?php echo $key ?>" class="flat table_records chkbx" name="id[]" value="<?php echo $user['id'] ?>" >
                      <label for="chk<?php echo $key ?>"></label>
                    </div></td>
                  <td class="align-center"><?php echo ++$i; ?></td>
                  <td><?php echo $user['name']; ?></td>
                  <td><?php echo $user['email']; ?></td>
                  <td><?php echo $user['username']; ?></td>
                  <td><?php echo $user['role']; ?></td>
                  <td class="a-right a-right" title="<?php echo $activearr[$user['status']] ?>"><span class="btn btn-<?php echo $statusarray['class'.$user['status']];  ?> btn-xs"><i class="fa <?php echo $statusarray['fa-'.$user['status']]; ?>"></i></span></td>
                  <td class="last" nowrap="nowrap"><?php /*?><a class="btn btn-primary btn-xs" href="#"><i class="fa fa-folder"></i> View </a><?php */?>
                    <a class="btn btn-info btn-xs" href="<?php echo site_url('admin/admins/edit/'.$user['id'].'/'.$return);?>"><i class="fa fa-pencil"></i> </a>
                    <?php if(count($users)>1){ ?>
                    <a href="<?php echo site_url('admin/admins/delete/'.$user['id'].'/'.$return); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirmBox();"><i class="fa fa-trash-o"></i> </a></a>
                    <?php } ?>
                    <?php if($user['id']!=$this->session->userdata('admin_id')){ ?>
                    <a href="<?php echo site_url('admin/admins/changepwd/'.$user['id'].'/'.$return); ?>" class="btn btn-primary btn-xs" title="Change Password"><i class="fa fa-lock"></i></a>
                    <?php } else { ?>
                    <a href="<?php echo site_url('admin/home/changepwd/'); ?>" class="btn btn-primary btn-xs" title="Change Password"><i class="fa fa-lock"></i></a>
                    <?php } ?>
                    <?php endforeach;?></td>
                </tr>
              </tbody>
            </table>
            <div class="col-md-12">
              <div class="text-center"><?php echo $this->pagination->create_links(); ?></div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>
