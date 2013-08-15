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
$cs->registerCss('label',"
	#main form label{
		display: inline-block !important;
	}
	");
?>

<div class="full_w">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>$this->createUrl('member/transactionhistory'),
		)); ?>
		<div class="h_title">Transaction History</div>
		<h2>Transaction history table</h2>
		<p>Show all the transaction history.</p>
		<p>
			<?php echo CHtml::radioButtonList('filter', $filter['filter'], array('Deduct Food Point'=>'Bill', 'Sponsor bonus'=>'Sponsor bonus', 'Autoplacement bonus'=>'Autoplacement bonus', 'Transfer'=>'Transfer', 'Purchase'=>'Purchase credit', 'Withdraw'=>'Withdrawal'), array('separator'=>'&nbsp;&nbsp;')); ?>
			<?php if(Yii::app()->user->id ==1) echo '<br/><br/>'.Chtml::dropDownList('id',$filter['id'], $userDropDownList, array('prompt'=>'Select a customer')); ?>
			<div style="margin: 1em 0 1.5em;">
				<label style="margin: 0 .5em 0;">From</label><?php echo CHtml::textField('DateFilter[from]', $filter['from'], array('class'=>'datepicker')); ?>
				<label style="margin: 0 .5em 0;">To</label><?php echo CHtml::textField('DateFilter[to]', $filter['to'], array('class'=>'datepicker')); ?>
			</div>
			<button type="submit" name="btnFilter">Find</button>
		</p>
	<?php $this->endWidget(); ?>
	<div class="entry">
		<div class="sep"></div>
	</div>
	<p>* Balance is referred as your total amount of food point / cash point.</p>
	<?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?php echo $CMessage; ?></p></div>
	<?php } ?>

	<table id="table">
		<thead>
			<tr>
				<th scope="col">Date</th>
				<?php if (Yii::app()->user->roles == 'admin') echo "<th scope='col'>Name</th>"; ?>
				<th scope="col">Type</th>
				<th scope="col">Amount</th>
				<th scope="col">Balance</th>
				<th scope="col">Description</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($model as $key=>$item) { ?>
				<tr>
					<td><?php echo $item['tranDate'] ?></td>
					<?php if (Yii::app()->user->roles == 'admin') echo "<td>".$item['name']."</td>"; ?>
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
