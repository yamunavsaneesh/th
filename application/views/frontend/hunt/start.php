<section>
  <div class="container-fluid">
    <div id="task-wrap"></div>
  </div>
</section>
<script type="application/javascript">
$(function() { 
	var nxttask =0;// '<?php //echo isset($this->taskrecover['sort_order'])  ? $this->taskrecover['sort_order']-1 :'' ?>';
	<?php  if(!$this->session->userdata('sesshuntover')) {?>gettask(nxttask);<?php }?>
	$("#task-wrap").on('click','#btntask',function(){ 
		if($('#taskform').valid()){submittask();}		  
  	});  
});
function gopenalty()
{
	var dataString = new Object(); 
	dataString = $('#taskform').serialize();	
	$.ajax({
		type: "post", 
		url: "<?php echo site_url('hunt/penalty/');?>", 	 	
		data: dataString, 
		success: function(msg) {
			$('#task-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
}
function gettask(task)
{
	var dataString = new Object(); 
	$.ajax({
		type: "get", 
		url: "<?php echo site_url('hunt/task/');?>",//+task, 	 	
		data: dataString, 
		success: function(msg) {
			$('#task-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
}
function submittask()
{
	var dataString = new Object(); 	 	 
	dataString = $('#taskform').serialize();	 	 
	$.ajax({
		type: "post", 
		url: "<?php echo site_url('hunt/task/');?>", 	 	
		data: dataString, 
		success: function(msg) {
			$('#task-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
	 
}
function tasklog()
{
	var dataString = new Object(); 	 	 
	dataString = $('#taskform').serialize();	 	 
	$.ajax({
		type: "post", 
		url: "<?php echo site_url('hunt/tasklog/');?>", 	 	
		data: dataString, 
		success: function(msg) { }, 
		error: function(){ console.log('error'); }
	});
}
</script>
