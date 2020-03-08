<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Settings</h1>
    <div class="settings">
        <div class="row">
            <div class="col-3"></div>
            <div class="col">
                <form action="admin/settings/save" method="post" id="settings-form">
                    <div class="setting">
                        <div class="setting-title">Menu Price:</div>
                        <div class="setting-input">
                            <div>R </div>
                            <input type="text" id="price" name="price" required="" value="<?=(isset($data['price'])) ? $data['price'] : 50?>" placeholder="Price" class="form-control">
                        </div>
                    </div>
                    <div class="setting">
                        <div class="setting-title">Closing Time:</div>
                        <div class="setting-input">
                            <div class="setting-time">
                                <label for="">Start Time:</label>
                                <input type="text" name="start_time" placeholder="e.g 08:00" value="<?=(isset($data['time'])) ? $data['time']->start : ''?>" class="form-control" id="start-time">
                            </div>
                            <div class="setting-time">
                                <label for="">Closing Time:</label>
                                <input type="text" name="closing_time" placeholder="e.g 20:00" value="<?=(isset($data['time'])) ? $data['time']->closing : ''?>" class="form-control" id="closing-time">
                            </div>
                        </div>
                    </div>
                    <?=csrf_token_tag();?>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Save Settings</button>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/app.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>