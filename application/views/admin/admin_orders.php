<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Orders</h1>
    <div class="bill-container">
        <div class="row order-arrange">
            <div class="col-3">
                <div>
                    <label for="">Menu Option:</label>
                    <select class="form-control" name="" id="menu-option">
                        <option value="">Select option</option>
                        <option value="Normal">Normal</option>
                        <option value="Alternative">Alternative</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <label for="">Sort Orders:</label>
                    <select class="form-control" name="" id="sort">
                        <option value="new">New - Old</option>
                        <option value="old">Old - New</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col">
                <h5 style="font-size: 15px;">If you want to add some to menu, go to <a
                        href="<?=base_url('admin/menu')?>">Menu page</a></h5>
            </div>
        </div>
        <div class="row">
            <div class="col">

                    <table id="orders-table" class="table table-striped" style="display:none;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Menu</th>
                                <th>Menu Option</th>
                                <th>Price</th>
                                <th>Date Ordered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <h3 id="no-orders" style="display:none;" class="order--place">No orders for this query!!!</h3>
                    <h3 id="loading-orders" class="order--place">Loading orders...</h3>
            </div>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/order.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>