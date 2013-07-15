<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
                        <label for="name"><span style="color: red;">*</span>Name:</label>
                        <?php echo $form->textField($model, 'name'); ?>
                </div>
                <div class="element">
                        <label for="contact"><span style="color: red;">*</span>Phone:</label>
                        <?php echo $form->textField($model, 'contact', array('placeholder'=>'Example: 0121235678')); ?>
                </div>
                <div class="element">
                        <label for="dateOfBirth"><span style="color: red;">*</span>Date of Birth:</label>
                        <?php echo $form->textField($model, 'dateOfBirth', array('class'=>'date date-end required')); ?>
                </div>
                <div class="element">
                        <label for="referral">Referral:</label>
                        <?php echo $form->textField($model, 'referralName', array('disabled'=>'disabled')); ?>
                </div>
                <div class="element">
                        <label for="packageId">Package:</label>
                        <?php echo $form->dropDownList($model, 'packageId', $packages, array('prompt'=>'Select a package','disabled'=>'disabled')); ?>
                </div>
                <div class="element">
                        <label for="email"><span style="color: red;">*</span>Email:</label>
                        <?php echo $form->textField($model, 'email'); ?>
                </div>
                <div class="sep"></div>
                <button type="submit">Update</button>
            <?php $this->endWidget(); ?>
        </div>
</div>