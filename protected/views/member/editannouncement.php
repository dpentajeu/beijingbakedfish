<div class="full_w">
        <div class="h_title">Edit Announcement</div>
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
                    <label for="title">Title:</label>
                    <?php echo $form->textfield($model,'title',array('style'=>'width:450px;')); ?><br/><br/>
                    <label for="message">Content:</label>
                    <?php echo $form->textarea($model,'message',array('style'=>'resize: none;width:450px;height:250px;')); ?>
                </div><br/>
                <button type="submit">Edit</button>
            <?php $this->endWidget(); ?>
        </div>
</div>