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
          <div class="title"><span class="highlight">All Questions</span></div>
        </div>
      </div>
      <div class="card-body no-padding"><?php echo form_open('admin/qas/actions'); ?>
        <div class="content">
          <div class="card-header card-title action-wrap">
            <?php if($this->session->userdata('admin_role')!='1'){  ?>
            <a href="<?php echo site_url('admin/qas/add/'); ?>" class="btn btn-info btn-sm" title="Add New"><i class="fa fa-plus"></i></a>
            <?php } ?>
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
                  <th width="1%">#</th>
                  <th  width="3%"><div class="checkbox checkbox-inline">
                      <input type="checkbox" id="check-all" class="flat chkall">
                      <label for="check-all"> </label>
                    </div>
                  </th>
                  <th width="25%">Question</th>
                  <th>Location</th><?php /*?>
                  <th>Duration</th><?php */?>
                  <th width="15%">Answer</th>
                  <th width="5%">Status </th>
                  <th width="5%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($hunts) foreach($hunts as $key => $hunt):?>
                <tr class="even pointer">
                  <td col="row" align="center"><?php echo ++$key;?></td>
                  <td class="a-center"><div class="checkbox checkbox-inline">
                      <input type="checkbox" id="chk<?php echo $key ?>" class="flat table_records chkbx" name="id[]" value="<?php echo $hunt['id'] ?>" >
                      <label for="chk<?php echo $key ?>"></label>
                    </div></td>
                  <td col="row" align="left"><?php echo $hunt['question'];?></td>
                  <td col="row" align="left"><?php echo $hunt['location'];?></td><?php /*?>
                  <td col="row" align="left"><?php echo $hunt['duration'];?></td><?php */?>
                  <td col="row" align="left"><?php echo $hunt['answer'];?></td>
                  <td class="a-right a-right"><span class="btn btn-<?php echo $statusarray['class'.$hunt['status']];  ?> btn-xs"><i class="fa <?php echo $statusarray['fa-'.$hunt['status']]; ?>"></i></span></td>
                  <td class="last" nowrap="nowrap"><a class="btn btn-default btn-xs" href="<?php echo site_url('admin/qas/view/'.$hunt['id'].'/'.$return) ?>" title="View"><i class="fa fa-file-o"></i> </a>
                    <?php if($this->session->userdata('admin_role')!='1'){  ?>
                    <a class="btn btn-info btn-xs" href="<?php echo site_url('admin/qas/edit/'.$hunt['id'].'/'.$return) ?>"><i class="fa fa-pencil"></i></a>
                    <?php } ?>
                    <a class="btn btn-danger btn-xs" href="<?php echo site_url('admin/qas/delete/'.$hunt['id'].'/'.$return) ?>" onclick="return confirmBox();"><i class="fa fa-trash-o"></i></a></td>
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
