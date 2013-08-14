<?php
$cs = Yii::app()->getClientScript();
$cs->registerPackage('pagination');
$cs->registerScript('pagination',"
	$(document).ready(function(){
            $('#pagination').smartpaginator({ 
                totalrecords: $total,
                recordsperpage: 10, 
                datacontainer: 'table', 
                dataelement: 'tr',
                theme: 'black' 
            });
	});
	");
?>
<div class="full_w">
        <div class="h_title">Purchase Credit</div>
        <?php if (Yii::app()->user->id != 1){ ?>
            <div class="form">
                <div class="n_warning"><p>Note: Please submit your cash point purchase request using the form below.</p></div>
                <?php if(!empty($CMessage)) { ?>
                    <div class="n_error"><p><?= $CMessage; ?></p></div>
                <?php } ?>
                <?php if(!empty($notice)) { ?>
                    <div class="n_ok"><p><?= $notice; ?></p></div>
                <?php } ?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'edit-form',
                    'action'=>Yii::app()->request->baseUrl.'/member/purchase',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            ),
                    )); ?>
                    <div class="element">
                        <label for="title">CP amount:</label>
                        <?php echo $form->textfield($model, 'amount', array('style'=>'width:450px;')); ?><br/><br/>
                        <label for="title">Remarks:</label>
                        <?php echo $form->textfield($model, 'remark', array('style'=>'width:450px;')); ?>
                    </div><br/>
                    <button type="submit">Submit</button>
                <?php $this->endWidget(); ?>
            </div>
            <div class="entry">
                <div class="sep"></div>
            </div>
        <?php } ?>
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
                                        <td><?= $item->amount; ?></td>
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