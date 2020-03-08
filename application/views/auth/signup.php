<?php include 'assets/templates/base_top.php'?>

<div class="container">
    <div class="auth-form-container">
        <div class="form-container">
            <form method="post" action="account/signup" data-type="user" id="signup-form">
                <div class="form-header">Sign up to Foodie</div>
                <div class="field-group">
                    <label for="">First Name</label>
                    <input type="text" id="first_name" required="" name="first_name" class="form-control" placeholder="Enter your first name">
                    <div class="input-error">
                        <label for="first_name" class="error"></label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="">Last Name</label>
                    <input type="text" id="last_name" required="" name="last_name" class="form-control" placeholder="Enter your last name">
                    <div class="input-error">
                        <label for="last_name" class="error"></label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="">Email</label>
                    <input type="email" name="email" required="" id="email" class="form-control" placeholder="Enter your email address">
                    <div class="input-error">
                        <label for="email" class="error"></label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="">Password</label>
                    <input type="password" name="password" required="" id="password" class="form-control" placeholder="Choose your password">
                    <div class="input-error">
                        <label for="password" class="error"></label>
                    </div>
                </div>
                <div class="field-group">
                    <label for="">Confirm Password</label>
                    <input type="password" id="c_password" required="" name="c_password" class="form-control" placeholder="Choose your password">
                    <div class="input-error">
                        <label for="c_password" class="error"></label>
                    </div>
                </div>
                <div class="to-other-auth">
                    <p class="text-center">
                        <a href="<?=base_url('login')?>">Login</a>
                    </p>
                </div>
                <?=csrf_token_tag();?>
                <div class="btn-action">
                    <button type="submit" id="signup-btn" class="btn btn-success btn-block">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="'.base_url('assets/js/auth.js').'"></script>';
 include 'assets/templates/base_bottom.php'?>