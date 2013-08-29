<?php
$cs = Yii::app()->getClientScript();
$cs->registerPackage('jui');
$cs->registerScript('datepicker',"
	$('#datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '1900:+0'
	});
	");
?>
<div class="full_w">
	<div class="h_title"><?php echo Yii::t('memberpanel', 'ReferMember'); ?></div>
	<div class="form">
		<div class="n_warning"><p><?php echo Yii::t('memberpanel', 'ReferMember1'); ?></p></div>
		<?php if (!empty($CMessage)) { ?>
			<div class="n_error"><p><?= $CMessage; ?></p></div>
		<?php } ?>
                <?php if (!empty($notice)) { ?>
			<div class="n_ok"><p><?= $notice; ?></p></div>
		<?php } ?>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'edit-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				),
			)); ?>
			<div class="element">				
				<label for="name"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Name'); ?>:</label>
				<?php echo $form->textField($model, 'name'); ?>
				<br/><br/>
				<label for="contact"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Phone'); ?>:</label>
				<?php echo $form->textField($model, 'contact', array('placeholder'=>'Example: 0121235678')); ?>
				<br/><br/>
				<label for="contact"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'ReferralPhone'); ?>:</label>
				<?php echo $form->textField($model, 'referral', array('placeholder'=>'Example: 0121235678')); ?>
				<br/><br/>
				<label for="dateOfBirth"><?php echo Yii::t('memberpanel', 'DOB'); ?></label>
				<?php echo $form->textField($model, 'dateOfBirth', array('id'=>'datepicker')); ?>
				<br/><br/>
				<label for="packageId"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Package'); ?>:</label>
				<?php echo $form->dropDownList($model, 'packageId', $packages, array('prompt'=>'Select a package')); ?>
                                <br/><br/>
                                <label for="email"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Email'); ?></label>
				<?php echo $form->textField($model, 'email'); ?>
			</div>
			<div class="sep"></div>
			<button type="submit"><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
		<?php $this->endWidget(); ?>
	</div>
</div>