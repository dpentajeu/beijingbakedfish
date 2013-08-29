<?php
$status_code = array('Pending', 'Confirmed', 'Cancelled');
$baseUrl = Yii::app()->request->baseUrl;
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
	<div class="h_title"><?php echo Yii::t('memberpanel', 'PurchaseCredit'); ?></div>
		<div class="form">
			<div class="n_warning"><p><?php echo Yii::t('memberpanel', 'PurchaseCredit1'); ?></p></div>
			<?php if(!empty($CMessage)) { ?>
				<div class="n_error"><p><?php echo $CMessage; ?></p></div>
			<?php } ?>
			<?php if(!empty($notice)) { ?>
				<div class="n_ok"><p><?php echo $notice; ?></p></div>
			<?php } ?>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'edit-form',
				'action'=>$this->createUrl('member/purchase'),
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
					),
				'htmlOptions'=>array('enctype'=>'multipart/form-data'),
				)); ?>
				<div class="element">
					<label for="Purchase_amount"><?php echo Yii::t('memberpanel', 'CashPoint'); ?>:</label>
					<?php echo $form->textfield($model, 'amount', array('style'=>'width:450px;')); ?><br/><br/>
					<label for="Purchase_remark"><?php echo Yii::t('memberpanel', 'Remark'); ?>:</label>
					<?php echo $form->textfield($model, 'remark', array('style'=>'width:450px;')); ?><br/><br/>
					<label for="statement"><?php echo Yii::t('memberpanel', 'Upload'); ?>:</label>
					<?php echo CHtml::fileField('statement'); ?>
				</div><br/>
				<button type="submit"><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
			<?php $this->endWidget(); ?>
		</div>
		<div class="entry">
			<div class="sep"></div>
		</div>
	<table id="table">
		<thead>
			<tr>
				<th scope="col" style="width: 70px;"><?php echo Yii::t('memberpanel', 'Date'); ?></th>
				<th scope="col" style="width: 150px;"><?php echo Yii::t('memberpanel', 'Amount'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Remark'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'Status'); ?></th>
				<th scope="col"><?php echo Yii::t('memberpanel', 'View'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $item) {
				$filename = "purchase_credit_" . md5($item->id) . ".jpg";
				$folder = Yii::getPathOfAlias('application') . "/../assets/uploads/"; ?>
				<tr>
					<td><?php echo $item->tranDate; ?></td>
					<td><?php echo number_format($item->amount, 2);?></td>
					<td><?php echo $item->remark; ?></td>
					<td><?php echo $status_code[$item->status]; ?></td>
					<td align="center"><?php echo file_exists($folder . $filename) ? CHtml::link("view", "{$baseUrl}/assets/uploads/{$filename}", array('target'=>'_blank')) : "" ; ?></td>
				</tr>
			<?php  }?>
		</tbody>
	</table>
	<div id='pagination'></div>
</div>