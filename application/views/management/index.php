<div class="row">
    <h1 style="padding: 0 20px;" id="managementHeader">Management App</h1>
    <div class="col-md-12">
        <div class="col-md-4" id="searchOrders" style="border: black 2px solid; padding: 15px;">
            <div id="addOrders">
                <form method="post" action="/management/addOrder/">
                    <h4>Add new order</h4>
                    <div class="form-group">
                        <strong>User</strong>
                        <select name="userID"  class="form-control" id="user">
                            <?php foreach ($users as $key => $row):?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->firstName." ".$row->lastName; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Product</strong>
                        <select name="productID"  class="form-control" id="product">
                            <?php foreach ($products as $key => $row):?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong class="col-md-2">Quantity</strong>
                        <input name="qty" type="text" class="col-md-5 form-control" id="qty" value="" />
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button> 
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4" id="searchOrders" style="border: black 2px solid; padding: 15px;">
            <form method="post" action="/management/">
                <h4>Filter orders</h4>
                <div class="col-md-2"><strong>Time frame</strong></div>
                <div class="col-md-10 form-group">
                    <select name="searchPeriod" class="form-control" label="Search">
                        <?php foreach ($searchFilters as $key => $row):?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-2"><strong>Search</strong></div>
                <input name="searchField" class="col-md-offset-1 col-md-9 form-group" type="text"  id="search" value="" placeholder="Search order" />
                <button type="submit" class="btn btn-primary">Search</button>  
            </form>
        </div>
    </div>
    <div id="listOrders">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>User</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                    <td>Date</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $key => $row):?>
                <tr>
                    <td><?php echo $row->userName; ?></td>
                    <td><?php echo $row->productName; ?></td>
                    <td><?php echo number_format($row->productPrice, 2, '.', '')." ".$row->productCurr; ?></td>
                    <td><?php echo $row->qty; ?></td>
                    <td><?php echo number_format($row->total, 2, '.', '')." ".$row->productCurr; ?></td>
                    <td><?php echo $row->date; ?></td>
                    <td>
                        <a href="/management/edit/<?php echo $row->id; ?>">Edit</a> 
                        <a href="/management/delete/<?php echo $row->id; ?>">Delete</a>
                    </td>
                </tr>
		<?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
