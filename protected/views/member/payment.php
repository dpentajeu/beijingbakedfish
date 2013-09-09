<?php
$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->request->baseUrl;
$cs->registerPackage('pagination');
$cs->registerScript('pagination',"
	$(document).ready(function(){
            $('#pagination').smartpaginator({ 
                totalrecords: $total,
                recordsperpage: 5, 
                datacontainer: 'table', 
                dataelement: 'tr',
                theme: 'black' 
            });
	});
	");
?>
<div class="full_w">
        <div class="h_title"><?php echo Yii::t('memberpanel', 'Payment'); ?></div>
            <div class="form">
                <div class="n_warning">
                    <p><?php echo Yii::t('memberpanel', 'Payment1'); ?></p>
                </div>
                <?php if(!empty($CMessage)) { ?>
                    <div class="n_error"><p><?= $CMessage; ?></p></div>
                <?php } ?>
                <?php if(!empty($notice)) { ?>
                    <div class="n_ok"><p><?= $notice; ?></p></div>
                <?php } ?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'edit-form',
                    'action'=>Yii::app()->request->baseUrl.'/member/payment',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            ),
                    )); ?>
                    <div class="element">
                        <label for="title"><?php echo Yii::t('memberpanel', 'Provider'); ?>:</label>
                        <?php echo $form->dropDownList($model,'provider', $providerDropDownList, array('prompt'=>'Select a service provider')); ?>
                        <br/><br/>
                        <label for="title"><?php echo Yii::t('memberpanel', 'Amount'); ?>:</label>
                        <?php echo $form->textfield($model, 'amount',array('style'=>'width:450px;')); ?><br/><br/>
                        <label for="title"><?php echo Yii::t('memberpanel', 'Billremark'); ?>:</label>
                        <?php echo $form->textfield($model, 'remark',array('style'=>'width:450px;')); ?>
                    </div><br/>
                    <button type="submit"><?php echo Yii::t('memberpanel', 'Submit'); ?></button>
                <?php $this->endWidget(); ?>
            </div>
            <div class="entry">
                <div class="sep"></div>
            </div>
        <table id="table">
                <thead>
                        <tr>
                            <th scope="col" style="width: 70px;"><?php echo Yii::t('memberpanel', 'Date'); ?></th>    
                            <th><?php echo Yii::t('memberpanel', 'Provider'); ?></th>
                            <th scope="col" style="width: 150px;"><?php echo Yii::t('memberpanel', 'Amount'); ?></th>
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Billremark'); ?></th> 
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Status'); ?></th> 
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($list as $item) { ?>
                                <tr>
                                        <td><?= $item->tranDate; ?></td>
                                        <td><?= Bill::getProvider($item->provider); ?></td>
                                        <td><?= number_format($item->amount, 2);?></td>
                                        <td><?= $item->remark; ?></td>
                                        <td><?php if($item->status == 0) echo 'Pending';
                                        if($item->status == 1) echo 'Confirmed';
                                        if($item->status == 2) echo 'Cancelled'; ?></td>
                                </tr>
                    <?php  }?>
                </tbody>
        </table>
        <div id='pagination'></div>
</div>