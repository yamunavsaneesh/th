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
          <div class="title"><span class="highlight">Sort Questions</span></div>
        </div>
      </div>
      <div class="card-body no-padding"><?php echo form_open('admin/qas/sortaction'); ?>
        <div class="content">
          <div class="card-header card-title action-wrap"> 
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo $this->session->flashdata('message'); ?> </div>
          <div class="clearfix"></div>
          <div class="table-responsive">
            <table class="table card-table">
              <thead>
                <tr class="headings">
                  <th colspan="2">&nbsp;</th>
                  <?php if($groups) foreach($groups as $group):?> 
                  <th colspan="4" class="text-center"><strong><?php echo $group['name'] ?></strong></th>
                  <?php endforeach;?>
                </tr>
                <tr class="headings bg-success">
                  <th width="1%">ID</th>
                  <th width="10%">Question</th>
                  <?php if($groups) foreach($groups as $group):?> 
                  <th>Order</th>
                  <th>Duration</th>
                  <th>Penalty</th>
                  <?php endforeach;?>
                </tr>
              </thead>
              <tbody>
                <?php if($hunts) foreach($hunts as $key => $hunt):?>
                <tr class="even pointer">
                  <td col="row" align="center"><?php echo ++$key;?></td>
                  <td col="row" align="left"><?php echo $hunt['question'];?></td>
                  <?php if($groups) foreach($groups as $key => $group):?>
                  <td class="<?php echo $key%2==1 ? 'bg-default':'bg-info'?>"><div class="form-group">
                      <input type="text" name="sortorder[<?php echo $group['id'] ?>][<?php echo $hunt['id'] ?>]" value="<?php echo isset($sortorders['orders'][$group['id']][$hunt['id']])?$sortorders['orders'][$group['id']][$hunt['id']]:''?>" class="form-control input-xs">
                    </div></td>
                  <td class="<?php echo $key%2==1 ? 'bg-default':'bg-info'?>"><div class="form-group">
                      <input type="text" name="duration[<?php echo $group['id'] ?>][<?php echo $hunt['id'] ?>]" value="<?php echo isset($sortorders['durations'][$group['id']][$hunt['id']])?$sortorders['durations'][$group['id']][$hunt['id']]:''?>" class="form-control timepicker">
                    </div></td>
                   <td class="<?php echo $key%2==1 ? 'bg-default':'bg-info'?>"><div class="form-group">
                      <input type="text" name="penalty[<?php echo $group['id'] ?>][<?php echo $hunt['id'] ?>]" value="<?php echo isset($sortorders['penalties'][$group['id']][$hunt['id']])?$sortorders['penalties'][$group['id']][$hunt['id']]:''?>" class="form-control timepicker">
                    </div></td>
                  <?php endforeach;?>
                </tr>
                <?php endforeach;?>
              </tbody>
              <tfoot>
              <td></td>
                <td colspan="<?php echo 3*count($groups)+1;?>"><div class="form-group">
                    <button type="submit" name="sortsave" value="Save" class="btn btn-success">Save Sort Order</button>
                    <a href="<?php echo site_url('admin/qas'); ?>" class="btn btn-primary">Cancel</a> </div>
                  </tfoot>
            </table>
            <?php echo $this->pagination->create_links(); ?> </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
