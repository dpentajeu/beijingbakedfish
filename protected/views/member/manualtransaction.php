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
        <div class="h_title"><?php echo Yii::t('memberpanel', 'ManualTransaction'); ?></div>
        <div class="form">
            <div class="n_warning"><p><?php echo Yii::t('memberpanel', 'Transaction1'); ?></p></div>
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
                        <label for="userDropDownList"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Customer'); ?>:</label>
                        <?php echo $form->dropDownList($model, 'id', $userDropDownList, array('prompt'=>'Select a customer')); ?>
                        <br/><br/>
                        <label for="amount"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'CashPoint'); ?>:</label>
                        <?php echo Chtml::textField('amountCP',''); ?>
                        <br/><br/>
                        <label for="amount"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'RedemptionPoint'); ?>:</label>
                        <?php echo Chtml::textField('amountRP',''); ?>
                        <br/><br/>
                        <label for="date"><span style="color: red;">*</span><?php echo Yii::t('memberpanel', 'Date'); ?>:</label>
                        <?php echo Chtml::textField('date', '', array('id'=>'datepicker')); ?>
                </div><br/>
                <button type="submit" name="setpin"><?php echo Yii::t('memberpanel', 'Submit'); ?>:</button>
            <?php $this->endWidget(); ?>
        </div>
</div>