<div class="full_w">
        <div class="h_title"><?php echo Yii::t('memberpanel', 'Network'); ?></div>
        <h2><?php echo Yii::t('memberpanel', 'SponsorNetwork'); ?></h2>
        <p><?php echo Yii::t('memberpanel', 'SponsorNetwork1'); ?></p>
        <div class="n_warning"><p><?php echo Yii::t('memberpanel', 'SponsorNetwork2'); ?></p></div>
        <div>
                <div class="h_title" style="text-align: center;"><?php echo Yii::t('memberpanel', 'SponsorGuideline'); ?></div>
                <div class="stats">
                        <div class="today" style="text-align: left; border-right: none;">
                            <p>1. Alpha package <?php echo Yii::t('memberpanel', 'entitles'); ?> 2 <?php echo Yii::t('memberpanel', 'levels'); ?></p>
                            <p>2. Beta package <?php echo Yii::t('memberpanel', 'entitles'); ?> 5 <?php echo Yii::t('memberpanel', 'levels'); ?></p>
                            <p>3. Gamma package <?php echo Yii::t('memberpanel', 'entitles'); ?> 10 <?php echo Yii::t('memberpanel', 'levels'); ?></p>
                        </div>
                        <div class="week" style="border-left: 1px dashed #c0c0c0;">
                            <p>1st <?php echo Yii::t('memberpanel', 'Level'); ?> = 7.5%</p>
                            <p>2nd <?php echo Yii::t('memberpanel', 'Level'); ?> = 5%</p>
                            <p>3rd <?php echo Yii::t('memberpanel', 'Level'); ?> = 4%</p>
                            <p>4th <?php echo Yii::t('memberpanel', 'Level'); ?> = 3.5%</p>
                            <p>5th <?php echo Yii::t('memberpanel', 'Level'); ?> = 3%</p>
                            <p>6th <?php echo Yii::t('memberpanel', 'Level'); ?> = 2.5%</p>
                            <p>7th <?php echo Yii::t('memberpanel', 'Level'); ?> = 1.5%</p>
                            <p>8th <?php echo Yii::t('memberpanel', 'Level'); ?> = 1%</p>
                            <p>9th <?php echo Yii::t('memberpanel', 'Level'); ?> = 1%</p>
                            <p>10th <?php echo Yii::t('memberpanel', 'Level'); ?> = 1%</p>
                        </div>
                </div>
        </div>
        
        <div class="clear"></div>
        <div class="entry">
            <div class="sep"></div>
        </div>
        
        <h2><?php echo Yii::t('memberpanel', 'Level1'); ?>0<?php echo Yii::t('memberpanel', 'Level2'); ?></h2>
        <h3><?php echo $user->name.' ('.$user->packageName.')'; ?></h3>
        <?php  $count = 0;
               foreach($model as $item){
                   if($count != $item['level']) {
                   $count += 1;
                   echo '<br/><div class="sep"></div><h2>'.Yii::t('memberpanel', 'Level1').($count).Yii::t('memberpanel', 'Level2').'</h2>';
                   }?>
                   <h3><?php echo $item['referral'].' -> '.$item['name'].' ('.$item['package'].') <i>'.Date('Y-m-d',strtotime($item['date'])).'</i>'; ?></h3>
        <?php  } ?>        
</div>
