<?php
$activearr=array('Y'=>'Active','N'=>'Inactive');
if($this->uri->segment(4)==""){
	$i=0;
	$return=0;
}else{
	$i=$this->uri->segment(4); 
	$return=$this->uri->segment(4); 
}
?>
  <?php echo $this->session->flashdata('message'); ?> 
    <?php echo form_open_multipart('admin/home/localizationactions',array('class'=>'form-horizontal')); ?>
     <div class="entry">
    <div style="float:right;width:80%;">Search :
      <input style="margin-right:10px;width:50%;" type="text" name="keyword" value="<?php echo $this->session->userdata('localization_key'); ?>" />
      <input class="btn btn-small btn-primary" type="submit" name="search" value="Search" />
      <input class="btn btn-small " type="submit" name="reset" value="Reset" />
      <a href="admin/home/addlocalization" class="btn btn-small btn-primary"> Add </a> </div>
    <input class="btn btn-small btn-primary" type="submit" name="save" value="Save" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
  </div>
	<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white edit"></i><span class="break"></span>Manage Localization - List</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
  	<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
      <tr>
        <th scope="col" style="width: 20px;">ID</th>
        <th scope="col" style="width:35%;">Key</th>
        <th scope="col">Value (<?php echo $this->languagesarr[$this->session->userdata('admin_language')]?>)</th>
      </tr>
    </thead>
    <tbody>
      <?php 
		foreach($localization as $localizationitem): ?>
      <tr>
        <td class="align-center"><?php echo ++$i; ?></td>
        <td><?php echo $localizationitem['lang_key']; ?></td>
        <td><textarea style="width:98%;" name="lang_value[<?php echo $localizationitem['id']; ?>]"><?php echo $localizationitem['lang_value']; ?></textarea></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="entry">
    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="sep"></div>
    <input class="btn btn-small btn-primary" type="submit" name="save" value="Save" />
  </div>
  
</div></div></div>
<?php form_close(); ?>
