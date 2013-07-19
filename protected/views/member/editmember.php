<?php
$cs = Yii::app()->getClientScript();
$cs->registerPackage('jui');
$cs->registerScript('datepicker',"
	$(document).ready(function(){
            var jq = $.noConflict();
		$( '#datepicker' ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    yearRange: '1900:+0'
                  });
	});
	");
?>

<div class="full_w">
        <div class="h_title">Edit Member</div>
        <div class="form">
            <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'edit-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        ),
                )); ?>
                <div class="element">
                        <label for="email"><span style="color: red;">*</span>Email:</label>
                        <?php echo $form->textField($model, 'email'); ?>
                        <br/><br/>
                        <label for="name"><span style="color: red;">*</span>Name:</label>
                        <?php echo $form->textField($model, 'name'); ?>
                        <br/><br/>
                        <label for="contact"><span style="color: red;">*</span>Phone:</label>
                        <?php echo $form->textField($model, 'contact', array('placeholder'=>'Example: 0121235678')); ?>
                        <br/><br/>
                        <label for="dateOfBirth"><span style="color: red;">*</span>Date of Birth:</label>
                        <?php echo $form->textField($model, 'dateOfBirth', array('id'=>'datepicker')); ?>
                        <br/><br/>
                        <label for="dateOfBirth">Bank Account:</label>
                        <?php echo $form->textField($model, 'bankAcc', array('id'=>'datepicker')); ?>
                        <br/><br/>
                        <label for="dateOfBirth">Bank Name:</label>
                        <?php echo $form->textField($model, 'bankName', array('id'=>'datepicker')); ?>
                        <br/><br/>
                        <label for="referral">Referral:</label>
                        <?php echo $form->textField($model, 'referralName', array('disabled'=>'disabled')); ?>
                        <br/><br/>
                        <label for="packageId">Package:</label>
                        <?php echo $form->dropDownList($model, 'packageId', $packages, array('prompt'=>'Select a package','disabled'=>'disabled')); ?>
                </div>                
                <div class="sep"></div>
                <button type="submit">Update</button>
            <?php $this->endWidget(); ?>
        </div>
</div>