<?php
$cs = Yii::app()->getClientScript();
$cs->registerPackage('pagination');
$cs->registerPackage('jui');
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
	<div class="h_title"><?php echo Yii::t('memberpanel', 'ROI Report'); ?></div>
	<table id="table">
		<thead>
			<tr>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Name'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Package'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Total ROI'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($list as $key=>$item) { ?>
				<tr>
					<td><?php echo $item['name'] ?></td>
					<td><?php echo $item['package']; ?></td>
					<td><?php echo number_format($item['amount'],2) ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<div id='pagination'></div>
</div>
