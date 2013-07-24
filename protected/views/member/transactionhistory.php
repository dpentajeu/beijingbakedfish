<div class="full_w">
        <div class="h_title">Transaction History</div>
        <h2>Transaction history table</h2>
        <p>Show all the transaction</p>
        <div class="entry">
            <div class="sep"></div>
        </div>
            
        <?php if(!empty($CMessage)) { ?>
		<div class="n_error"><p><?= $CMessage; ?></p></div>
            <?php } ?>
        
        <table>
                <thead>
                        <tr>
                                <th scope="col">Date</th>
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
                                <td><?= $item['tranType'] ?></td>
                                <td><?= $item['amount'] ?></td>
                                <td><?= $item['balance'] ?></td>
                                <td><?= $item['description'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
</div>
