<section>
  <div class="container-fluid">
    <div id="question-wrap"></div>
  </div>
</section>
<script type="application/javascript">
$(function() { 
	startquestion();
	$("#question-wrap").on('click','#btntask',function(){ 
		if($('#taskform').valid()){submitanswer();}		  
  	});  
});
function startquestion()
{
	var dataString = new Object(); 
	$.ajax({
		type: "get", 
		url: "<?php echo site_url('start/question');?>", 	 	
		data: dataString, 
		success: function(msg) {
			$('#question-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
}
function submitanswer()
{
	var dataString = new Object(); 	 	 
	dataString = $('#taskform').serialize();	 	 
	$.ajax({
		type: "post", 
		url: "<?php echo site_url('start/answer');?>", 	 	
		data: $('#taskform').serialize(), 
		success: function(msg) {
			$('#question-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
	 
}
function gopenalty()
{
	var dataString = new Object(); 
	dataString = $('#taskform').serialize();	
	$.ajax({
		type: "post", 
		url: "<?php echo site_url('start/penalty');?>", 	 	
		data: dataString, 
		success: function(msg) {
			$('#question-wrap').html(msg);
		}, 
		error: function(){ console.log('error'); }
	});
} 
</script>