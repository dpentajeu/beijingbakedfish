<?php
$cs = Yii::app()->getClientScript();
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
        <div class="h_title"><?php echo Yii::t('memberpanel', 'Announcement'); ?></div>
        <?php if (Yii::app()->user->id==1){ ?>
            <div class="form">
                <?php if(!empty($CMessage)) { ?>
                    <div class="n_error"><p><?= $CMessage; ?></p></div>
                <?php } ?>
                <?php if(!empty($notice)) { ?>
                    <div class="n_ok"><p><?= $notice; ?></p></div>
                <?php } ?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'edit-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            ),
                    )); ?>
                    <div class="element">
                        <label for="title"><?php echo Yii::t('memberpanel', 'title'); ?>:</label>
                        <?php echo Chtml::textfield('title','',array('style'=>'width:450px;')); ?><br/><br/>
                        <label for="message"><?php echo Yii::t('memberpanel', 'message'); ?>:</label>
                        <?php echo Chtml::textarea('message','',array('style'=>'resize: none;width:450px;height:250px;')); ?>
                    </div><br/>
                    <button type="submit"><?php echo Yii::t('memberpanel', 'post'); ?></button>
                <?php $this->endWidget(); ?>
            </div>
            <div class="entry">
                <div class="sep"></div>
            </div>
        <?php } ?>
        <table id="table">
                <thead>
                        <tr>
                            <th scope="col" style="width: 70px;"><?php echo Yii::t('memberpanel', 'date'); ?></th>    
                            <th scope="col" style="width: 150px;"><?php echo Yii::t('memberpanel', 'title'); ?></th>
                            <th scope="col"><?php echo Yii::t('memberpanel', 'message'); ?></th> 
                            <?php if (Yii::app()->user->id==1){ echo '<th scope="col" style="width: 35px;">'.Yii::t('memberpanel', 'Action').'</th>'; } ?>
                        </tr>
                </thead>

                <tbody>
                    
                    <?php foreach ($model as $key=>$item) { ?>
                                <tr>
                                        <td><?= $item['dateCreated'] ?></td>
                                        <td><?= $item['title'] ?></td>
                                        <td><?= $item['message'] ?></td>
                                        <?php if (Yii::app()->user->id==1){ ?>
                                            <td class="align-center">
                                                <a href="<?php echo Yii::app()->request->baseUrl.'/member/editannouncement?id='.$item['id'] ?>" class="table-icon edit" title="Edit"></a>
                                            </td>
                                        <?php } ?>
                                </tr>
                    <?php  }?>
                </tbody>
        </table>
        <div id='pagination'></div>
</div>