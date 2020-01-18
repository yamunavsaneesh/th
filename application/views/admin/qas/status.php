<table class="table card-table">
  <thead>
    <tr class="headings">
      <th width="1%">#</th>
      <th>User</th>
      <th>Start Time</th>
      <th>Answer</th>
      <th>Currently On</th>
      <th>Finish Time</th>
    </tr>
  </thead>
  <tbody>
    <?php  if($hunts) foreach($hunts as $key => $hunt):?>
    <tr class="even pointer">
      <td col="row" align="center"><?php echo ++$key;?></td>
      <td col="row" align="left"><?php echo $hunt['firstname'].' '.$hunt['lastname'];?></td>
      <td col="row" align="left"><?php echo $hunt['start_time'];?></td>
      <td col="row" align="left"><?php echo $hunt['answer'];?></td>
      <td col="row" align="left"><?php echo $hunt['question'];?></td>
      <td col="row" align="left"><?php echo $hunt['submision_time'];?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="col-md-12">
  <div class="text-center"><?php echo $this->jquery_pagination->create_links(); ?></div>
</div>
<div class="clear">&nbsp;</div>
