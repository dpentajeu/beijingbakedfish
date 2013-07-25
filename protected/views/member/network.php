<div class="full_w">
        <div class="h_title">Network</div>
        <h2>Network Hierarchy</h2>
        <p>Show the sponsor network level</p>
        <div class="entry">
            <div class="sep"></div>
        </div>
        <h2>Level 1</h2>
        <h3><?php echo $user->name.' ('.$user->packageName.')'; ?></h3>
        <?php  $count = 0;
               foreach($model as $item){
                   if($count != $item['level']) {
                   $count += 1;
                   echo '<br/><div class="sep"></div><h2>Level '.($count+1).'</h2>';
                   }?>
                   <h3><?php echo $item['referral'].' -> '.$item['name'].' ('.$item['package'].') <i>'.Date('Y-m-d',strtotime($item['date'])).'</i>'; ?></h3>
        <?php  } ?>        
</div>
