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
        <div class="h_title"><?php echo Yii::t('memberpanel', 'TopupHistory'); ?></div>   
        <?php if(!empty($CMessage)) { ?>
            <div class="n_error"><p><?= $CMessage; ?></p></div>
        <?php } ?>
        <?php if(!empty($notice)) { ?>
            <div class="n_ok"><p><?= $notice; ?></p></div>
        <?php } ?>
        <table id="table">
                <thead>
                        <tr>  
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Name'); ?></th>
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Contact'); ?></th>
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Package'); ?></th>
                            <th scope="col"><?php echo Yii::t('memberpanel', 'Remark'); ?></th>
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($list as $item) { ?>
                                <tr>
                                        <td><?= $item->name; ?></td>
                                        <td><?= $item->contact; ?></td>
                                        <td><?= Package::getPackageName($item->packageId); ?></td>
                                        <td><?= $item->remark; ?></td>
                                </tr>
                    <?php  }?>
                </tbody>
        </table>
        <div id='pagination'></div>
</div>