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
        <div class="h_title">Purchase Credit History</div>        
        <table id="table">
                <thead>
                        <tr>
                            <th scope="col">Date</th>    
                            <th scope="col">Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Remark</th> 
                            <th scope="col">Action</th>
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