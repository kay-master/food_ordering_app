<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Create Menu</h1>
    <div class="bill-container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col">
                <div class="form-container form-bg">
                    <form action="admin/menu/<?=$action?>" id="create-menu-form">
                        <div class="field-group">
                            <label for="">Picture</label>
                            <input type="file" id="picture" name="picture" class="form-control" disabled="">
                            <div class="input-error">
                                <label for="picture" class="error"></label>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="">Menu Name</label>
                            <input type="text" id="menu_name" name="menu_name" class="form-control"
                                placeholder="Enter menu name" value="<?=(isset($data))?$data['title']:''?>">
                            <div class="input-error">
                                <label for="menu_name" class="error"></label>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="">Is it a menu for:</label>
                            <?php $week = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];?>
                            <select name="day_of_menu" required="" id="day_of_menu" class="form-control">
                                <option value="">Select menu day...</option>
                                <?php
                                    foreach($week as $wk){
                                        if(isset($data) && strtolower(trim($wk)) == strtolower(trim($data['day']))){
                                            echo '<option selected="" value="'.ucfirst($wk).'">'.ucfirst($wk).'</option>';
                                        }else{
                                            echo '<option value="'.ucfirst($wk).'">'.ucfirst($wk).'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <div class="input-error">
                                <label for="day_of_menu" class="error"></label>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="">Menu type:</label>
                            <?php $menuType = ['normal', 'alternative'];?>
                            <select name="menu_type" required="" id="menu_type" class="form-control">
                                <option value="">Select menu type...</option>
                                <?php
                                    foreach($menuType as $mT){
                                        if(isset($data) && strtolower(trim($mT)) == strtolower(trim($data['menu_type']))){
                                            echo '<option selected="" value="'.ucfirst($mT).'">'.ucfirst($mT).'</option>';
                                        }else{
                                            echo '<option value="'.ucfirst($mT).'">'.ucfirst($mT).'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <div class="input-error">
                                <label for="menu_type" class="error"></label>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="">Price</label>
                            <input type="text" id="price" name="price" class="form-control"
                                placeholder="Enter price" readonly="" value="<?=get_settings('price')?>">
                            <div class="input-error">
                                <label for="price" class="error"></label>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="">Description</label>
                            <textarea id="description" name="description" class="form-control"
                                placeholder="Write short description.."><?=(isset($data))?$data['description']:''?></textarea>
                            <div class="input-error">
                                <label for="description" class="error"></label>
                            </div>
                        </div>
                        <?=csrf_token_tag();?>
                        <?php
                            if(isset($data)){
                                ?>
                                <input type="hidden" name="menu_id" value="<?=$data['id']?>">
                                <?php
                            }
                        ?>
                        <div class="btn-action">
                            <button type="submit" id="create-menu-btn" class="btn btn-success btn-block"><?=($action == 'edit')? "Edit Menu": "Create Menu" ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/app.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>