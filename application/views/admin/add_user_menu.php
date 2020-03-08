<?php
$other_style = '<link rel="stylesheet" href="' .base_url('assets/plugins/select2/css/select2.min.css').'">';
 include 'assets/templates/base_top.php'?>
<div class="container menu">
    <h1>Add User</h1>
    <div class="bill-container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col">
                <div class="form-container form-bg">
                    <form action="admin/menu/add_user" id="add-user-form">
                        <div class="menu-details">
                            <div>Here are the menu details:</div>
                            <ul>
                                <li>Menu Name: <span><?=ucfirst($data['title'])?></span></li>
                                <li>Day: <span><?=ucfirst($data['day'])?></span></li>
                                <li>Type: <span id="menu_type" data-type="<?=ucfirst($data['menu_type'])?>"><?=ucfirst($data['menu_type'])?></span></li>
                            </ul>
                        </div>
                        <div class="field-group" style="min-height: auto;">
                            <label for="">Search user:</label>
                            <div>
                                <select class="custom-select" name="find_user" id="find_user"></select>
                            </div>
                        </div>
                        <div class="adding-note">
                            Users already on the <strong><?=ucfirst($data['menu_type'])?></strong> menu can't be added again.
                        </div>
                        <div class="selected-users">
                            <ul id="user-list">
                                <li class="no-user">No selected user</li>
                            </ul>
                        </div>
                        <?=csrf_token_tag();?>
                        <input type="hidden" name="menu_id" value="<?=$data['id']?>">
                        <div class="btn-action">
                            <button type="submit" disabled="" id="add-user-btn" class="btn btn-success btn-block">Add
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/plugins/select2/js/select2.min.js') . '"></script>';
$other_script .= '<script src="' . base_url('assets/js/app.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>