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
            <?php echo CHtml::radioButtonList('filter', null, array('Deduct Food Point'=>'Bill', 'Sponsor bonus'=>'Sponsor bonus', 'Autoplacement bonus'=>'Autoplacement bonus', 'Transfer'=>'Transfer', 'Purchase'=>'Purchase credit', 'Withdraw'=>'Withdrawal'), array('separator'=>'&nbsp;&nbsp;')); ?>
            <?php if(Yii::app()->user->id ==1) echo '<br/><br/>'.Chtml::dropDownList('id','', $userDropDownList, array('prompt'=>'Select a customer')); ?>
            <br/><br/>
            <button type="submit" name="btnFilter">Find</button>
        </p>            
        <div class="entry">
            <div class="sep"></div>
        </div>
        * Balance is referred as your total amount of food point / cash point.
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
                                <td><?= number_format($item['amount'], 2);?></td>
                                <td><?= number_format($item['balance'], 2);?></td>
                                <td><?= $item['description'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
        <?php $this->endWidget(); ?>
        <div id='pagination'></div>        
</div>
