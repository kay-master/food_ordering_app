<header class="">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-light navbar-expand-lg mh-nav nav-btn">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon icon"></span>
                </button>

                <div class="collapse top-nav navbar-collapse" id="navbarSupportedContent">
                    <a href="<?=base_url()?>" class="logo">Foodie</a>
                    <ul class="navbar-nav">
                        <?php if (!$loggedIn): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?=base_url()?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('menu')?>">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('login')?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('signup')?>">Sign up</a>
                        </li>
                        <?php elseif ($userType == 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('menu')?>">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('order')?>">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('order_history')?>">Previous Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('billing')?>">Billing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('logout')?>">Logout</a>
                        </li>
                        <?php elseif ($userType == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('admin/orders')?>">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('admin/view_menu')?>">Weekly Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('admin/create_menu')?>">Create Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('admin/billing')?>">Billing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('admin/settings')?>">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('logout')?>">Logout</a>
                        </li>
                        <?php endif;?>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>