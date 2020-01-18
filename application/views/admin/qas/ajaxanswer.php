<table class="table card-table">
  <thead>
    <tr class="headings">
      <th width="1%">#</th>
      <th width="25%">User</th>
      <th width="25%">Question</th>
      <th>Answer</th>
      <th>Submission Time</th>
      <th>Taken Time</th>
      <th width="15%">Penalty</th>
    </tr>
  </thead>
  <tbody>
    <?php if($hunts) foreach($hunts as $key => $hunt):?>
    <tr class="even pointer">
      <td col="row" align="center"><?php echo ++$key;?></td>
      <td col="row" align="left"><?php echo $hunt['firstname'].' '.$hunt['lastname'];?></td>
      <td col="row" align="left"><?php echo $hunt['question'];?></td>
      <td col="row" align="left"><?php echo $hunt['answer'];?></td>
      <td col="row" align="left"><?php echo $hunt['submision_time'];?></td>
      <td col="row" align="left"><?php echo $hunt['taken_time'];?></td>
      <td col="row" align="left"><?php echo $hunt['penatly_time'];?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="col-md-12">
  <div class="text-center"><?php echo $this->jquery_pagination->create_links(); ?></div>
</div>
