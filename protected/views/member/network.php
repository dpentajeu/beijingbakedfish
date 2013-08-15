<div class="full_w">
        <div class="h_title">Sponsor Network</div>
        <h2>Sponsor Network Hierarchy</h2>
        <p>Show the sponsor network level.</p>
        <div class="n_warning"><p>Red color indicated member is not activate.</p></div>
        <div>
                <div class="h_title" style="text-align: center;">Sponsor Bonus Guidelines</div>
                <div class="stats">
                        <div class="today" style="text-align: left; border-right: none;">
                            <p>1. Alpha package entitles 2 levels</p>
                            <p>2. Beta package entitles 5 levels</p>
                            <p>3. Gamma package entitles 10 levels</p>
                        </div>
                        <div class="week" style="border-left: 1px dashed #c0c0c0;">
                            <p>1st level = 7.5%</p>
                            <p>2nd level = 5%</p>
                            <p>3rd level = 4%</p>
                            <p>4th level = 3.5%</p>
                            <p>5th level = 3%</p>
                            <p>6th level = 2.5%</p>
                            <p>7th level = 1.5%</p>
                            <p>8th level = 1%</p>
                            <p>9th level = 1%</p>
                            <p>10th level = 1%</p>
                        </div>
                </div>
        </div>
        
        <div class="clear"></div>
        <div class="entry">
            <div class="sep"></div>
        </div>
        
        <h2>Level 0</h2>
        <h3><?php echo $user->name.' ('.$user->packageName.')'; ?></h3>
        <?php  $count = 0;
               foreach($model as $item){
                   if($count != $item['level']) {
                   $count += 1;
                   echo '<br/><div class="sep"></div><h2>Level '.($count).'</h2>';
                   }?>
                   <h3><?php echo $item['referral'].' -> '.$item['name'].' ('.$item['package'].') <i>'.Date('Y-m-d',strtotime($item['date'])).'</i>'; ?></h3>
        <?php  } ?>        
</div>
