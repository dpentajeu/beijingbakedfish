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
        <?php if (Yii::app()->user->id==1){ ?>
            <div class="h_title">Member</div>
            <h2>Member table</h2>
            <p>Add and edit member table</p>
            <p>Total members: <?= $total; ?></p>
            <div class="entry">
                <div class="sep"></div>
            </div>
        <?php  } else {?>                                        
            <div class="h_title">My Account</div>
        <?php } ?>
            
        <?php if(!empty($CMessage)) { ?>
            <div class="n_error"><p><?= $CMessage; ?></p></div>
        <?php } ?>
            <div>
                <table id="table">
                        <thead>
                                <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Referral</th>
                                        <th scope="col">Package</th>
                                        <th scope="col" style="width: 65px;">Point</th>
                                        <th scope="col" style="width: 35px;">Action</th>
                                        <?php if (Yii::app()->user->id==1){ echo '<th scope="col">Status</th>'; } ?>
                                </tr>
                        </thead>

                        <tbody>

                            <?php if (Yii::app()->user->id==1){
                                        foreach ($model as $key=>$item) { ?>
                                        <tr>
                                                <td><?= $item['name'] ?></td>
                                                <td><?= $item['email'] ?></td>
                                                <td><?= $item['contact'] ?></td>
                                                <td><?= $item['referralName'] ?></td>
                                                <td><?= $item['packageName'] ?></td>
                                                <td class="align-center"><?= $item['foodpoint'] ?></td>
                                                <td class="align-center">
                                                    <a href="<?php echo Yii::app()->request->baseUrl.'/member/editmember?id='.$item['id'] ?>" class="table-icon edit" title="Edit"></a>
                                                </td>
                                                <td class="align-center">
                                                    <?php if($item['isApproved']==true){?>
                                                        Approved
                                                    <?php } else { ?>
                                                        <a href="<?php echo Yii::app()->request->baseUrl.'/member/approve?id='.$item['id'] ?>">Approve</a>
                                                     <?php }?>
                                                </td>
                                        </tr>
                            <?php  } } else {?>                                        
                                        <tr>
                                                <td><?= $model['name'] ?></td>
                                                <td><?= $model['email'] ?></td>
                                                <td><?= $model['contact'] ?></td>
                                                <td><?= $model['referralName'] ?></td>
                                                <td><?= $model['packageName'] ?></td>
                                                <td class="align-center"><?= $model['foodpoint'] ?></td>
                                                <td class="align-center">
                                                    <a href="<?php echo Yii::app()->request->baseUrl ?>/member/editmember" class="table-icon edit" title="Edit"></a>                                        
                                                </td>
                                        </tr>
                            <?php } ?>
                        </tbody>
                </table>
                <div id='pagination'></div>
            </div>
</div>
