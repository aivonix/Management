<div class="row" style="padding-left: 0;">
    <h1 style="padding: 0 20px;" id="managementHeader">Edit order</h1>
    <div class="col-md-4" >
        <form method="post" action="/management/editOrder/">
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>" />
            <input type="hidden" id="initProductDiscount" value="<?php echo $currProductDiscount; ?>" />
            <div class="form-group">
                <label for="user">User</label>
                <select name="userID" class="form-control" id="user">
                    <?php foreach ($users as $key => $row):?>
                    <option <?php if ($row->id == $orders->userID): ?>selected="selected"<?php endif; ?> value="<?php echo $row->id ?>"><?php echo $row->firstName." ".$row->lastName; ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="product">Product</label>
                <select name="productID" class="form-control" id="product">
                    <?php foreach ($products as $key => $row):?>
                    <option <?php if ($row->id == $orders->productID): ?>selected="selected"<?php endif; ?> value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <?php foreach ($products as $key => $row):?>
                <?php if ($row->id == $orders->productID): ?>
                    <input type="text" class="form-control" id="price" value="<?php echo number_format($row->price, 2, '.', ''); ?>" readonly />
                <?php endif; ?>
                <?php endforeach;?>
            </div>
            <div class="form-group">
                <label for="qty">Quantity</label>
                <input name="qty" type="text" class="form-control" id="qty" value="<?php echo $orders->qty; ?>" />
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <input name="total" type="text" class="form-control" id="total" value="<?php echo number_format($orders->total, 2, '.', ''); ?>" readonly />
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" class="form-control" id="date" value="<?php echo $orders->date; ?>" readonly />
            </div>
            <button type="submit" class="btn btn-primary">Apply</button>  
        </form>
    </div>
</div>
