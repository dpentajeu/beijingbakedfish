
<div class="full_w">
        <div class="h_title">Report</div>
        <h2>Member table</h2>
        <p>Add and edit member table</p>

        <div class="entry">
                <div class="sep"></div>
        </div>
        <table>
                <thead>
                        <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Referral</th>
                                <th scope="col">Package</th>
                                <th scope="col" style="width: 65px;">Action</th>
                        </tr>
                </thead>

                <tbody>
                    
                    <?php if (Yii::app()->user->id==1){
                                foreach ($model as $key=>$item) { ?>
                                <tr>
                                        <td class="align-center"><?= $item['id'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['email'] ?></td>
                                        <td><?= $item['contact'] ?></td>
                                        <td><?= $item['referralName'] ?></td>
                                        <td><?= $item['packageName'] ?></td>
                                        <td>
                                            <a href="<?php echo Yii::app()->request->baseUrl.'/member/editmember?id='.($key+1) ?>" class="table-icon edit" title="Edit"></a>
                                        </td>
                                </tr>
                    <?php  }} else {?>                                        
                                <tr>
                                        <td class="align-center"><?= $model['id'] ?></td>
                                        <td><?= $model['name'] ?></td>
                                        <td><?= $model['email'] ?></td>
                                        <td><?= $model['contact'] ?></td>
                                        <td><?= $model['referralName'] ?></td>
                                        <td><?= $model['packageName'] ?></td>
                                        <td>
                                            <a href="<?php echo Yii::app()->request->baseUrl.'/member/editmember?id='.($model['id']) ?>" class="table-icon edit" title="Edit"></a>
                                        </td>
                                </tr>
                    <?php } ?>
                </tbody>
        </table>
</div>
