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
        <div class="h_title">Withdraw Credit</div>
            <div class="form">
                <div class="n_warning">
                    <p>Note: Please submit your cash point withdrawal request with a minimum amount of RM100 and the service charge for withdrawal is RM5.</p>
                    <p>Please update your bank account profile before submit a withdrawal request. Click <a href="<?= $baseUrl ?>/member/editmember">here</a> to update.</p>
                </div>
                <?php if(!empty($CMessage)) { ?>
                    <div class="n_error"><p><?= $CMessage; ?></p></div>
                <?php } ?>
                <?php if(!empty($notice)) { ?>
                    <div class="n_ok"><p><?= $notice; ?></p></div>
                <?php } ?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'edit-form',
                    'action'=>Yii::app()->request->baseUrl.'/member/withdraw',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            ),
                    )); ?>
                    <div class="element">
                        <label for="title">CP amount:</label>
                        <?php echo $form->textfield($model, 'amount',array('style'=>'width:450px;')); ?><br/><br/>
                        <label for="title">Remarks:</label>
                        <?php echo $form->textfield($model, 'remark',array('style'=>'width:450px;')); ?>
                    </div><br/>
                    <button type="submit">Submit</button>
                <?php $this->endWidget(); ?>
            </div>
            <div class="entry">
                <div class="sep"></div>
            </div>
        <table id="table">
                <thead>
                        <tr>
                            <th scope="col" style="width: 70px;">Date</th>    
                            <th scope="col" style="width: 150px;">Amount</th>
                            <th scope="col">Remark</th> 
                            <th scope="col">Status</th> 
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($list as $item) { ?>
                                <tr>
                                        <td><?= $item->tranDate; ?></td>
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