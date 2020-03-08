<?php include 'assets/templates/base_top.php'?>

<div class="container menu">
    <h1>Billing</h1>
    <div class="bill-container">
        <div class="row order-arrange">
            <div class="col-3">
                <div>
                    <label for="">Order by:</label>
                    <select class="form-control" name="" id="menu-option">
                        <option value="Week">Week</option>
                        <option value="Month">Month</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <label for="">Sort Bills:</label>
                    <select class="form-control" name="" id="sort">
                        <option value="new">New - Old</option>
                        <option value="old">Old - New</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table id="bills-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Date Billed</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <h3 id="no-bills" style="display:none;" class="order--place">No bills for this query!!!</h3>
                <h3 id="loading-bills" class="order--place">Loading bills...</h3>
            </div>
        </div>
    </div>
</div>

<?php
$other_script = '<script src="' . base_url('assets/js/order.js') . '"></script>';
include 'assets/templates/base_bottom.php'?>