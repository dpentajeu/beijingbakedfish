<?php
$cs = Yii::app()->getClientScript();
$cs->registerPackage('pagination');
$cs->registerScript('pagination',"
	$('#pagination').smartpaginator({
		totalrecords: $total,
		recordsperpage: 10, 
		datacontainer: 'table', 
		dataelement: 'tr',
		theme: 'black' 
	});
	");
?>

<div class="full_w">
<?php if (Yii::app()->user->roles == 'admin') { ?>
	<div class="h_title">Member</div>
	<h2>Member table</h2>
	<p>Add and edit member table</p>
	<p>Total members: <?php echo $total; ?></p>
	<div class="entry">
		<div class="sep"></div>
	</div>
<?php } else { ?>
	<div class="h_title">My Account</div>
<?php } ?>

<?php if(!empty($CMessage)) { ?>
	<div class="n_error"><p><?php echo $CMessage; ?></p></div>
<?php } ?>
	<div>
		<table id="table">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Contact</th>
					<th scope="col">Referral</th>
					<th scope="col">Package</th>
					<th scope="col">Redemption Point</th>
					<th scope="col">Cash Point</th>
					<th scope="col" style="width: 35px;">Action</th>
					<?php if (Yii::app()->user->roles == 'admin') echo CHtml::tag('th', array('scope' => 'col'), 'Status'); ?>
				</tr>
			</thead>

			<tbody>
				<?php
				if (Yii::app()->user->roles == 'admin' || Yii::app()->user->roles == 'staff') {
					foreach ($model as $key=>$item) {
				?>
					<tr>
						<td><?php echo $item['name'] ?></td>
						<td><?php echo $item['contact'] ?></td>
						<td><?php echo $item['referralName'] ?></td>
						<td><?php echo $item['packageName'] ?></td>
						<td class="align-center"><?= number_format($item['foodPoint'], 2);?></td>
						<td class="align-center"><?= number_format($item['cashPoint'], 2);?></td>
						<td class="align-center">
							<a href="<?php echo $this->createUrl('member/editmember', array('id'=>$item['id'])); ?>" class="table-icon edit" title="Edit"></a>
						</td>
						<?php if (Yii::app()->user->roles == 'admin') { ?>
						<td class="align-center">
							<?php if($item['isApproved']==true){?>
								<a href="<?php echo $this->createUrl('member/disapprove', array('id'=>$item['id'])); ?>">Block</a>
							<?php } else { ?>
								<a href="<?php echo $this->createUrl('member/approve', array('id'=>$item['id'])); ?>">Approve</a>
							 <?php }?>
						</td>
						<?php } ?>
					</tr>
				<?php
					}
				} else {
				?>
					<tr>
						<td><?php echo $model['name'] ?></td>
						<td><?php echo $model['contact'] ?></td>
						<td><?php echo $model['referralName'] ?></td>
						<td><?php echo $model['packageName'] ?></td>
						<td class="align-center"><?= number_format($model['foodPoint'], 2);?></td>
						<td class="align-center"><?= number_format($model['cashPoint'], 2);?></td>
						<td class="align-center">
							<a href="<?php echo $this->createUrl('member/editmember'); ?>" class="table-icon edit" title="Edit"></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div id='pagination'></div>
	</div>
</div>
