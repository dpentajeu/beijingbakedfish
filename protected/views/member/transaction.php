<div class="full_w">
        <div class="h_title">Transaction</div>
        <div class="form">
            <div class="n_warning"><p>Note: Bill amount refers to total bill and system will deduct 50% of food point as refer to the total bill amount.</p></div>
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
                        <label for="amound"><span style="color: red;">*</span>Total Bill Amount::</label>
                        <?php echo Chtml::textField('amount',''); ?>
                        <br/><br/>
                        <label for="pin"><span style="color: red;">*</span>Customer PIN:</label>
                        <?php echo $form->passwordField($model, 'pin'); ?>
                </div><br/>
                <button type="submit" name="setpin">Submit</button>
            <?php $this->endWidget(); ?>
        </div>
</div>