<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading col-md-12">
          <div class="app-title">
            <div class="title col-md-6"><span class="highlight">Answers</span></div>
            <ul class="card-action text-right">
              <li> <a href="javascript:void(0)" id="refresh"> <i class="fa fa-refresh"></i> </a> </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body no-padding">
        <div class="content">
          <div class="clearfix"></div>
          <div class="table-responsive" id="answer"> </div>
          <div class="clear">&nbsp;</div>
        </div>
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
		url: '<?php echo site_url('admin/status/ajaxanswer');?>', success: function(html) {
			$("#answer").empty().append(html);
		}
	});
}
function filteranswer(){
	
}
</script> 
