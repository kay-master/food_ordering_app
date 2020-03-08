<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Billing</h1>
    <div class="bill-container">
        <?php if (!empty($data)): ?>

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Date Ordered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $info): ?>
                        <tr>
                            <td><?=$info['id']?></td>
                            <td><?=$info['item']?></td>
                            <td>R <?=$info['price']?></td>
                            <td><?=$info['date_billed']?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php else: ?>
        <h3>You don't have any old orders</h3>
        <?php endif;?>
    </div>
</div>

<?php include 'assets/templates/base_bottom.php'?>