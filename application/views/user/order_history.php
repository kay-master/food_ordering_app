<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Previous Order</h1>
    <div class="order-container previous-orders">
        <?php if(!empty($data)):?>
        <?php foreach($data as $info):?>
        <div class="row">
            <div class="col-3">
                <div class="order-image">
                    <img src="<?=base_url('assets/images/food.jpg')?>" alt="">
                </div>
            </div>
            <div class="col">
                <div class="order-details">
                    <h1><?=$info['title']?></h1>
                    <h3>R <?=$info['price']?></h3>
                    <div class="order-date">Ordered: <?=$info['date_ordered']?></div>
                    <div class="order-action">
                        <button disabled="" class="btn btn-danger">Remove</button>
                        <button disabled="" class="btn btn-success">Re-Order</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <?php else: ?>
        <h3>You don't have any old orders</h3>
        <?php endif;?>
    </div>
</div>

<?php include 'assets/templates/base_bottom.php'?>