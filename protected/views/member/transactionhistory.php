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
$cs->registerScript('datepicker', "
	$('.datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1900:+0'
	})
	");
?>

<div class="full_w">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>$this->createUrl('member/transactionhistory'),
		)); ?>
		<div class="h_title" style="margin: 0 0 1em 0;"><?php echo Yii::t('memberpanel', 'TransactionHistory'); ?></div>
		<div style="padding: 0 0 0 .2em;">
			<div style="margin: 0 0 1em 0;">
				<?php echo CHtml::radioButtonList('filter', $filter['filter'],
					array(
						'Deduct'=>Yii::t('memberpanel', 'bill'),
						'Sponsor bonus'=>Yii::t('memberpanel', 'SponsorBonus'),
						'Autoplacement'=>Yii::t('memberpanel', 'AutoplacementBonus'),
						'Transfer'=>Yii::t('memberpanel', 'Transfer'),
						'Purchase'=>Yii::t('memberpanel', 'PurchaseCredit'),
						'Withdraw'=>Yii::t('memberpanel', 'Withdrawal'),
						'Bill'=>Yii::t('memberpanel', 'Utilities')
						),
					array(
						'separator'=>'',
						'template'=>'<div style="display: inline-block;">{input} {label}</div>',
						'labelOptions'=>array('style'=>'display: inline-block; margin: 0 1em 0 0;'),
						)
					); ?>
			</div>
			<?php if(Yii::app()->user->id == 1): ?>
				<div style="margin: 0 0 1em 0;">
					<label for="id">User</label>
					<?php echo Chtml::dropDownList('id',$filter['id'], $userDropDownList, array('prompt'=>'Select a customer')); ?>
				</div>
			<?php endif; ?>
			<div style="margin: 0 0 1em 0;">
				<div style="display: inline-block; width: 300px;">
					<label for="DateFilter_from"><?php echo Yii::t('memberpanel', 'from'); ?></label>
					<?php echo CHtml::textField('DateFilter[from]', $filter['from'], array('class'=>'datepicker')); ?>
				</div>
				<div style="display: inline-block; width: 300px;">
					<label for="DateFilter_to"><?php echo Yii::t('memberpanel', 'to'); ?></label>
					<?php echo CHtml::textField('DateFilter[to]', $filter['to'], array('class'=>'datepicker')); ?>
				</div>
			</div>
			<button type="submit" name="btnFilter"><?php echo Yii::t('memberpanel', 'find'); ?></button>
		</div>
	<?php $this->endWidget(); ?>
	<div class="entry">
		<div class="sep"></div>
	</div>
	<h3><?php echo $title; ?></h3>
	<p>* <?php echo Yii::t('memberpanel', 'TransactionHistory1'); ?></p>
	<div style="padding: 0 15px;">Total amount: <?php echo number_format($total_amount, 2); ?></div>
	<?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?php echo $CMessage; ?></p></div>
	<?php } ?>

	<table id="table">
		<thead>
			<tr>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Date'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Name'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Type'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Amount'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Balance'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Description'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($model as $key=>$item) { ?>
				<tr>
					<td><?php echo $item['tranDate'] ?></td>
					<td><?php echo $item->wallet->user['name']; ?></td>
					<td><?php echo $item['tranType'] ?></td>
					<td style="text-align: right;"><?php echo number_format($item['amount'], 2);?></td>
					<td style="text-align: right;"><?php echo number_format($item['balance'], 2);?></td>
					<td><?php echo $item['description'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<div id='pagination'></div>
</div>
