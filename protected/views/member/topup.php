<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('',"
	$(document).ready(function(){
        document.getElementById('submit').style.visibility='hidden';
        $( '#confirm' ).click(function() {
	        $('<br/><div>Are you sure you want to top up?</div><br/>').insertBefore('form button:last');
	        document.getElementById('submit').style.visibility='visible';
	        document.getElementById('confirm').style.visibility='hidden';  
		});        
    });
        ");
?>
<div class="full_w">
	<div class="h_title"><?php echo Yii::t('memberpanel', 'Topup'); ?></div>
	<div class="form">
		<div class="n_warning"><p><?php echo Yii::t('memberpanel', 'Topup1'); ?></p></div>
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
				<label for="contact"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Customer'); ?>:</label>
				<?php echo $form->dropDownList($model, 'id', $userDropDownList, array('prompt'=>'Select a customer')); ?>
				<br/><br/>
				<label for="packageId"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Package'); ?>:</label>
				<?php echo $form->dropDownList($model, 'packageId', $packages, array('prompt'=>'Select a package')); ?>
			</div>
			<button id="submit" type="submit" ><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
		<?php $this->endWidget(); ?>
		<button id="confirm" style='margin:15px;'>Confirm?</button>
	</div>
</div>