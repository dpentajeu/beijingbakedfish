
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
                                <th scope="col" style="width: 65px;">Modify</th>
                        </tr>
                </thead>

                <tbody>
                    <?php foreach ($model as $item) { ?>
                        <tr>
                                <td class="align-center"><?= $item['id'] ?></td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['email'] ?></td>
                                <td><?= $item['contact'] ?></td>
                                <td><?= $item['referral'] ?></td>
                                <td><?= $item['packageId'] ?></td>
                                <td>
                                        <a href="#" class="table-icon edit" title="Edit"></a>
                                        <a href="#" class="table-icon archive" title="Archive"></a>
                                        <a href="#" class="table-icon delete" title="Delete"></a>
                                </td>
                        </tr>
                    <?php } ?>                     
                </tbody>
        </table>
        <div class="entry">
                <div class="pagination">
                        <span>« First</span>
                        <span class="active">1</span>
                        <a href="">2</a>
                        <a href="">3</a>
                        <a href="">4</a>
                        <span>...</span>
                        <a href="">23</a>
                        <a href="">24</a>
                        <a href="">Last »</a>
                </div>
                <div class="sep"></div>		
                <a class="button add" href="">Add member</a> <a class="button" href="">Sort</a> 
        </div>
</div>
