<div class="full_w">
        <div class="h_title">Transaction</div>
        <div class="form">
            <div class="n_warning"><p>Note: Please select the user to transfer and enter cash point.</p></div>
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
                        <label for="userDropDownList"><span style="color: red;">*</span>User contact number:</label>
                        <?php echo Chtml::textField('ph',''); ?>
                        <br/><br/>
                        <label for="amount"><span style="color: red;">*</span>Cash Point:</label>
                        <?php echo Chtml::textField('amount',''); ?>
                        <br/><br/>
                        <label for="ping"><span style="color: red;">*</span>Pin:</label>
                        <?php echo Chtml::passwordField('pin',''); ?>
                </div><br/>
                <button type="submit" name="setpin">Submit</button>
            <?php $this->endWidget(); ?>
        </div>
</div>