<div class="full_w">
        <div class="h_title">Set PIN</div>
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
                        <label for="password"><span style="color: red;">*</span>Password:</label>
                        <?php echo $form->passwordField($model, 'password'); ?>
                        <br/><br/>
                        <label for="newPin"><span style="color: red;">*</span>New PIN:</label>
                        <?php echo $form->textField($model, 'newPin'); ?>
                        <br/><br/>
                        <label for="newPin2"><span style="color: red;">*</span>Confirm new PIN:</label>
                        <?php echo $form->textField($model, 'newPin2'); ?>
                </div>
                <div class="sep"></div>
                <button type="submit">Submit</button>
            <?php $this->endWidget(); ?>
        </div>
</div>