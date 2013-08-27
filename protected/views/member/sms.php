<?php
$cs = Yii::app()->getClientScript();
$cs->registerCss('label',"
        #main form label{
            display: inline-block !important;
        }
    ");
$cs->registerScript('',"
	$(document).ready(function(){
                $('input#member_0').attr('checked', true);

		$('input#member_0').click(function(){
                        $('#id').attr('disabled', false);
                });

                $('input#member_1').click(function(){
                        $('#id').attr('disabled', true);
                });
            });
        ");
?>

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
                * Warning: Messages are subjected to the SMS quota available. Credit remaining : <?php curl_exec($credit); ?><br/><br/>
                <p><?php echo CHtml::radioButtonList('member', null, array(1=>'To particular member', 2=>'To all members'), array('separator'=>'&nbsp;&nbsp;')); ?></p>
                <?php echo Chtml::dropDownList('id','', $userDropDownList, array('prompt'=>'Select a customer')); ?>
                <div class="element">
                        <label for="message">Message:</label><br/>
                        <?php echo Chtml::textarea('message','',array('style'=>'resize: none;width:450px;height:250px;')); ?>
                </div><br/>
                <button type="submit">Send</button>
            <?php $this->endWidget(); ?>
        </div>
</div>