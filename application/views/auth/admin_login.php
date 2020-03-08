<?php include 'assets/templates/base_top.php';
$admins = $this->db->query("SELECT * FROM admins")->num_rows();
$first_admin = false;
if ($admins == 0) {
    $first_admin = true;
}
?>

<div class="container">
    <div class="auth-form-container">
        <div class="form-container">
            <form action="account/admin/login" data-type="admin" id="login-form">
                <div class="form-header">Foodie Admin</div>
                <div class="field-group">
                    <label for="">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address">
                    <div class="input-error">
                        <label for="email" class="error"></label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Choose your password">
                    <div class="input-error">
                        <label for="password" class="error"></label>
                    </div>
                </div>
                <div class="to-other-auth">
                    <?php if ($first_admin): ?>
                    <p class="text-center">
                        <a href="<?=base_url('admin/signup')?>">Sign Up as First Admin</a>
                    </p>
                    <?php endif;?>
                </div>
                <?=csrf_token_tag();?>
                <div class="btn-action">
                    <button type="submit" id="btn-login" class="btn btn-success btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/auth.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>