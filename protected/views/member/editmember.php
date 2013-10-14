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
	<div class="h_title"><?php echo Yii::t('memberpanel', 'EditMember'); ?></div>
	<div class="form">
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
				<label for="email"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Email'); ?></label>
				<?php echo $form->textField($model, 'email'); ?>
				<br/><br/>
				<label for="name"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Name'); ?>:</label>
				<?php echo $form->textField($model, 'name'); ?>
				<br/><br/>
				<label for="contact"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Phone'); ?>:</label>
				<?php if(Yii::app()->user->getState('roles')=='admin') 
						echo $form->textField($model, 'contact', array('placeholder'=>'Example: 0121235678'));
					else
						echo $form->textField($model, 'contact', array('placeholder'=>'Example: 0121235678','disabled'=>'disabled'));
						?>
				<br/><br/>
				<label for="dateOfBirth"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'DOB'); ?></label>
				<?php echo $form->textField($model, 'dateOfBirth', array('id'=>'datepicker')); ?>
				<br/><br/>
				<label for="dateOfBirth"><?php echo Yii::t('memberpanel', 'BankAcc'); ?>:</label>
				<?php echo $form->textField($model, 'bankAcc', array('id'=>'datepicker')); ?>
				<br/><br/>
				<label for="dateOfBirth"><?php echo Yii::t('memberpanel', 'NameBank'); ?>:</label>
				<?php echo $form->textField($model, 'bankName', array('id'=>'datepicker')); ?>
				<br/><br/>
				<label for="referral"><?php echo Yii::t('memberpanel', 'Referral'); ?>:</label>
				<?php echo CHtml::textField('User[referralName]', $model->sponsor->name, array('disabled'=>'disabled')); ?>
				<br/><br/>
				<label for="packageId"><?php echo Yii::t('memberpanel', 'Package'); ?>:</label>
				<?php echo $form->dropDownList($model, 'packageId', $packages, array('prompt'=>'Select a package','disabled'=>'disabled')); ?>
			</div>
			<div class="sep"></div>
			<button type="submit"><?php echo Yii::t('memberpanel', 'Edit'); ?></button>
		<?php $this->endWidget(); ?>
	</div>
</div>