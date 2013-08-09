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
$cs->registerCss('label',"
        #main form label{
            display: inline-block !important;
        }
    ");
?>

<div class="full_w">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->request->baseUrl.'/member/transactionhistory',
        )); ?>
        <div class="h_title">Transaction History</div>
        <h2>Transaction history table</h2>
        <p>Show all the transaction history.</p>
        <p>            
            <?php echo CHtml::radioButtonList('filter', null, array('Deduct Food Point'=>'Bill', 'Sponsor Bonus'=>'Sponsor bonus', 'Autoplacement Bonus'=>'Autoplacement bonus', 'Transfer'=>'Transfer'), array('separator'=>'&nbsp;&nbsp;')); ?>
            
            <?php echo CHtml::submitButton('Find', array('name'=>'btnFilter')); ?>            
        </p>            
        <div class="entry">
            <div class="sep"></div>
        </div>
            
        <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
        
        <table id="table">
                <thead>
                        <tr>
                                <th scope="col">Date</th>                                
                                <?php if(Yii::app()->user->id ==1 ) {echo "<th scope='col'>Name</th>"; } ?>
                                <th scope="col">Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Description</th>                                
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($model as $key=>$item) { ?>
                        <tr>
                                <td><?= $item['tranDate'] ?></td>
                                <?php if(Yii::app()->user->id ==1 ) {echo "<td>".$item['name']."</td>"; } ?>
                                <td><?= $item['tranType'] ?></td>
                                <td><?= $item['amount'] ?></td>
                                <td><?= $item['balance'] ?></td>
                                <td><?= $item['description'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <div id='pagination'></div>
        <?php $this->endWidget(); ?>
</div>
