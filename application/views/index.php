<?php include 'assets/templates/base_top.php'?>
<style>
.nav-placeholder {
    display: none;
}
</style>
<div class="container-fluid hero">
    <div class="header-bg">
        <div class="header-bg-left"></div>
        <div class="header-bg-right">
            <img src="assets/images/hero.jpg" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col"></div>
    </div>
    <div class="hero-text">
        <h1>Welcome to Foodie</h1>
        <h3>Get the food you love!!</h3>
        <div class="order-btn">
            <a href="<?=base_url('menu')?>" style="width: 135px;" class="btn btn-primary">Order</a>
        </div>
    </div>
</div>

<?php include 'assets/templates/base_bottom.php'?>