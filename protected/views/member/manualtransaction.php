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
        <div class="h_title">Manual Transaction</div>
        <div class="form">
            <div class="n_warning"><p>Note: Amount refers to total food point which will be deducted.</p></div>
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
                        <label for="userDropDownList"><span style="color: red;">*</span>Customer:</label>
                        <?php echo $form->dropDownList($model, 'id', $userDropDownList, array('prompt'=>'Select a customer')); ?>
                        <br/><br/>
                        <label for="amound"><span style="color: red;">*</span>Total Food Point:</label>
                        <?php echo Chtml::textField('amount',''); ?>
                        <br/><br/>
                        <label for="amound"><span style="color: red;">*</span>Date:</label>
                        <?php echo Chtml::textField('date', '', array('id'=>'datepicker')); ?>
                </div><br/>
                <button type="submit" name="setpin">Submit</button>
            <?php $this->endWidget(); ?>
        </div>
</div>