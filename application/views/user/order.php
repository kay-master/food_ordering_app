<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Current Order</h1>
    <div class="order-container">
        <?php if(!empty($data)): ?>
        <div class="row">
            <div class="col-5">
                <div class="order-image">
                    <img src="<?=base_url('assets/images/hero.jpg')?>" alt="">
                </div>
            </div>
            <div class="col">
                <div class="order-details">
                    <h1><?=$data['title']?></h1>
                    <h3>R <?=$data['price']?></h3>
                    <div class="order-date">Ordered: <?=$data['date_ordered']?></div>
                    <div class="meal-description"><?=$data['description']?></div>
                    <div class="order-action">
                        <button class="btn btn-danger" id="cancel-order">Cancel Order</button>
                        <div class="cancel-reason-container d-none">
                            <form action="user/menu/cancel_order" id="cancel-order-form">
                                <div>
                                    <label for="">Please specify a reason for cancelling your order:</label>
                                    <textarea class="form-control" placeholder="Start writing something..." name="cancel-reason"></textarea>
                                </div>
                                <?=csrf_token_tag();?>
                                <input type="hidden" name="order" value="<?=$data['order_id']?>">
                                <div style="margin-top: 15px;">
                                    <button type="button" class="btn btn-danger" id="close-reason">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit Reason</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
            <h3>You have no active order at the moment</h3>
        <?php endif;?>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/order.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>