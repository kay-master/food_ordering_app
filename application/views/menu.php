<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Weekly Menu</h1>
    <div class="menu-container">

        <?php if ($dataCount != 0): ?>
            <?php foreach ($data as $day => $info): ?>
                <?php if (empty($info)) {
                        continue;
                    }
                    ?>
                <div>
                    <h2><?=ucfirst($day)?></h2>
                    <div class="row">
                        <?php foreach ($info as $item): ?>
                            <div class="col-4">
                                <div class="item-container">
                                    <div class="item-type <?=strtolower($item['menu_type'])?>"><?=ucfirst($item['menu_type'])?></div>
                                    <div class="item-image">
                                        <img src="<?=base_url('assets/images/food.jpg')?>" alt="">
                                    </div>
                                    <div class="item-title"><?=$item['title']?></div>
                                    <div class="item-price">R <?=$item['price']?></div>
                                    <div class="item-action">
                                        <?php if ($userType == 'user'): ?>
                                            <button data-menu="<?=$item['id']?>" class="btn btn-secondary order-menu">Order meal</button>
                                        <?php else: ?>
                                            <a href="<?=base_url('admin/edit_menu/' . $item['id'])?>" class="btn btn-warning">Edit Order</a>
                                            <a href="<?=base_url('admin/view_menu/' . $item['id'] . '/add_user')?>" class="btn btn-secondary">Add User</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endforeach;?>
        <?php else: ?>
            <div class="text-center">
                <h2>You have no menu</h2>
            </div>
        <?php endif;?>
    </div>
</div>

<?php
if ($userType == 'user'){
    $other_script = '<script src="' . base_url('assets/js/order.js') . '"></script>';
}
include 'assets/templates/base_bottom.php'?>