<div class="full_w">
        <div class="h_title"><?php echo Yii::t('memberpanel', 'TransferPoint'); ?></div>
        <div class="form">
            <div class="n_warning"><p><?php echo Yii::t('memberpanel', 'TransferPoint1'); ?></p></div>
            <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
            <?php if(!empty($notice)) { ?>
		<div class="n_ok"><p><?= $notice; ?></p></div>
            <?php } ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'transaction-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        ),
                )); ?>
                <div class="element">
                        <label for="userDropDownList"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'UserContact'); ?>:</label>
                        <?php echo Chtml::textField('ph',''); ?>
                        <br/><br/>
                        <label for="amount"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'CashPoint'); ?>:</label>
                        <?php echo Chtml::textField('amount',''); ?>
                        <br/><br/>
                        <label for="ping"><span style="color: red;">*</span>PIN:</label>
                        <?php echo Chtml::passwordField('pin',''); ?>
                </div><br/>
                <button type="submit" name="setpin"><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
            <?php $this->endWidget(); ?>
        </div>
</div>