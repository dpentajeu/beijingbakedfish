<div class="full_w">
        <div class="h_title">SMS to all members</div>
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
                * Warning: Messages are subjected to the SMS quota available.
                <div class="element">
                        <label for="message">Message:</label>
                        <?php echo Chtml::textarea('message','',array('style'=>'resize: none;width:450px;height:250px;')); ?>
                </div><br/>
                <button type="submit">Send</button>
            <?php $this->endWidget(); ?>
        </div>
</div>