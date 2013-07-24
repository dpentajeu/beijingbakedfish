<div class="full_w">
        <div class="h_title">Change Password</div>
        <div class="form">
            <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
            <?php if(!empty($notice)) { ?>
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
                        <label for="oldPassword"><span style="color: red;">*</span>Old password:</label>
                        <?php echo $form->passwordField($model, 'oldPassword'); ?>
                        <br/><br/>
                        <label for="newPassword"><span style="color: red;">*</span>New password:</label>
                        <?php echo $form->passwordField($model, 'newPassword'); ?>
                        <br/><br/>
                        <label for="newPassword"><span style="color: red;">*</span>Confirm new password:</label>
                        <?php echo $form->passwordField($model, 'newPassword2'); ?>
                </div><br/>
                <button type="submit">Change</button>
            <?php $this->endWidget(); ?>
        </div>
</div>