<?php
$baseUrl = Yii::app()->request->baseUrl;
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
        <div class="h_title">Purchase Credit History</div>   
        <div class="n_warning"><p>Note: Please confirm user purchase request after payment is received.</p></div>     
        <?php if(!empty($CMessage)) { ?>
            <div class="n_error"><p><?= $CMessage; ?></p></div>
        <?php } ?>
        <?php if(!empty($notice)) { ?>
            <div class="n_ok"><p><?= $notice; ?></p></div>
        <?php } ?>
        <table id="table">
                <thead>
                        <tr>
                            <th scope="col">Date</th>    
                            <th scope="col">Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Remark</th> 
                            <th scope="col">Action</th>
                            <th scope="col">View</th>
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($list as $item) {
                        $filename = "purchase_credit_" . md5($item->id) . ".jpg";
                        $folder = Yii::getPathOfAlias('application') . "/../assets/uploads/"; ?>
                                <tr>
                                        <td><?= $item->tranDate; ?></td>
                                        <td><?= $item->wallet->user->name; ?></td>
                                        <td><?= $item->wallet->user->contact; ?></td>
                                        <td><?= number_format($item->amount, 2);?></td>
                                        <td><?= $item->remark; ?></td>
                                        <td align="center"><?php if($item->status == 0) 
                                            echo "<a href='{$baseUrl}/member/purchasehistory?id={$item->id}&action=true'>Confirm</a>&nbsp&nbsp<a href='{$baseUrl}/member/purchasehistory?id={$item->id}&action=false'>Cancel</a>";
                                        if($item->status == 1) echo 'Confirmed';
                                        if($item->status == 2) echo 'Cancelled'; ?></td>
                                        <td align="center"><?php echo file_exists($folder . $filename) ? CHtml::link("view", "{$baseUrl}/assets/uploads/{$filename}", array('target'=>'_blank')) : "" ; ?></td>
                                </tr>
                    <?php  }?>
                </tbody>
        </table>
        <div id='pagination'></div>
</div>