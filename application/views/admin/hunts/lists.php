<?php
$statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
$activearr=array('Y'=>'Active','N'=>'Inactive');
if($this->uri->segment(3)==""){
	$i=0;
	$return='';
}else{
	$i=$this->uri->segment(4); 
	$return=$this->uri->segment(4); 
}
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">All Hunts</span></div>
        </div>
      </div>
      <div class="card-body no-padding"><?php echo form_open('admin/hunts/actions'); ?>
        <div class="content">
          <div class="card-header card-title action-wrap"><a href="<?php echo site_url('admin/hunts/add/'); ?>" class="btn btn-info btn-sm" title="Add New"><i class="fa fa-plus"></i></a>
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
                    </div>
                  </th>
                  <th width="15%">Logo</th>
                  <th>Title</th>
                  <th>Email</th>
                  <th width="5%">Status </th>
                  <th width="5%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($hunts) foreach($hunts as $key => $hunts):?>
                <tr class="even pointer">
                  <td class="a-center"><div class="checkbox checkbox-inline">
                      <input type="checkbox" id="chk<?php echo $key ?>" class="flat table_records chkbx" name="id[]" value="<?php echo $hunts['id'] ?>" >
                      <label for="chk<?php echo $key ?>"></label>
                    </div></td>
                  <td class="row"><?php echo ($hunts['logo'] !='') ? '<img src="'.base_url('public/uploads/logos/'.$hunts['logo']).'" height="50"  width="50" class="img-circle">':'<div class="icon">LOGO</div>'; ?></td>
                  <td col="row" align="left"><?php echo $hunts['name'];?></td>
                  <td col="row" align="left"><?php echo $hunts['email'];?></td>
                  <td class="a-right a-right"><span class="btn btn-<?php echo $statusarray['class'.$hunts['status']];  ?> btn-xs"><i class="fa <?php echo $statusarray['fa-'.$hunts['status']]; ?>"></i></span></td>
                  <td class="last" nowrap="nowrap"><?php /*?><a class="btn btn-primary btn-xs" href="#"><i class="fa fa-folder"></i> View </a><?php */?>
                    <a class="btn btn-info btn-xs" href="<?php echo site_url('admin/hunts/edit/'.$hunts['id'].'/'.$return) ?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-xs" href="<?php echo site_url('admin/hunts/delete/'.$hunts['id'].'/'.$return) ?>" onclick="return confirmBox();"><i class="fa fa-trash-o"></i></a></td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            <div class="col-md-12">
              <div class="text-center"><?php echo $this->pagination->create_links(); ?></div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
