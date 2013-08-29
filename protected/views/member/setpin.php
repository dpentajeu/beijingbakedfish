<div class="full_w">
        <div class="h_title"><?php echo Yii::t('memberpanel', 'PIN'); ?></div>
        <div class="form">
            <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
            <?php if(!empty($notice)) { ?>
		<div class="n_ok"><p><?= $notice; ?></p></div>
            <?php } ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'setpin-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        ),
                )); ?>
                <div class="element">
                        <label for="tac"><span style="color: red;">*</span>TAC:</label>
                        <?php echo $form->textField($model, 'tac'); ?>
                        <button type="submit" name="setTac"><?php echo Yii::t('memberpanel', 'RequestTAC'); ?></button>
                </div>
                * You are required to enter your pin upon bill payment for food point redemption.
                <div class="element">
                        <label for="newPin"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'NewPIN'); ?>:</label>
                        <?php echo $form->passwordField($model, 'newPin'); ?>
                        <br/><br/>
                        <label for="newPin2"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'ConfirmPIN'); ?>:</label>
                        <?php echo $form->passwordField($model, 'newPin2'); ?>
                </div><br/>
                <button type="submit" name="setpin"><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
            <?php $this->endWidget(); ?>
        </div>
</div>