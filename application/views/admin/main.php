<!DOCTYPE html>
<html>
<head>
<title><?php echo $page_title  ? $page_title : $this->config->item('admin_title'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/css/vendor.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/css/bootstrap-datetimepicker.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/admin/css/flat-admin.css');?>">
<script type="text/javascript" src="<?php echo base_url('public/admin/js/jquery-3.1.1.min.js');?>"></script> 
</head>
<body>
<div class="app app-default">
<?php echo $left ?>
<div class="app-container"> <?php echo $header ?> <?php echo $content ?> <?php echo $footer ?> </div>
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/bootstrap.min.js');?>"></script> 
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/moment.js');?>"></script> 
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript" src="<?php  echo base_url('public/admin/js/select2.full.min.js');?>"></script>  
<script type="text/javascript">
$(document).ready(function() { 
	$('.timepicker').datetimepicker({
		format: 'HH:mm:ss',showClear:true,showClose:true,inline:false
	});
	$(".alert").show().delay(2000).fadeOut('slow'); 
	$('.chkall').click(function () {
	$(this).closest('form').find(':checkbox').prop('checked', this.checked);
	});
	$(".datepicker").datetimepicker({format: 'DD/MM/YYYY hh:mm:ss',showClear:true,showClose:true});
	$("select").select2();
	$('*[data-users]').hover(function() {
		var e=$(this);
		e.off('hover');
		$.get(e.data('users'),function(output) {
			e.popover({content:output,html:true, trigger:'hover', container: 'body'}).popover('show');
		});
	});
});
function confirmBox()
{
 var where_to= confirm("Are you sure to delete this record?");
 if (where_to== true)
     return true;
 else{
     return false;
 }
}
function confirmDelete()
{
	if($('.chkbx').is(':checked') == true)
	{
		if(confirm("Are you sure?")== true)
		return true;
		else
		return false;
	}
	if($('.chkbx').is(':checked') == false)
	{
		alert('Choose a record to delete');
		return false;
	}
}
</script>
</body>
</html>
