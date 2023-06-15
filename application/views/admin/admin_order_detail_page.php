<?php
	/** @var Order $order */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(Order Detail Page)</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
</head>
<body>
    <header class="header_admin">
	    <a href="<?= base_url('dashboard/orders') ?>"><h2>Dashboard</h2></a>
	    <a href="<?= base_url('dashboard/orders') ?>"><h3>Orders</h3></a>
	    <a href="<?= base_url('dashboard/products') ?>"><h3>Products</h3></a>
        <a class="nav_end" href="<?= base_url('admin') ?>"><h3>Log off</h3></a>
    </header>
    <main>
        <aside class="admin_order_info">
            <h4>Order ID: <?= $order['id'] ?></h4>
            <h4>Customer shipping info:</h4>
            <span><p>Name: </p><p><?= ucwords($order['shipping']['first_name_ship'] . ' ' . $order['shipping']['last_name_ship']) ?></p></span>
            <span><p>Address: </p><p><?= ucwords($order['billing']['address_bill'] . ' ' . $order['billing']['address2_bill'] . ' ' . $order['billing']['city_bill'] . ' ' . $order['billing']['state_bill'] . ' ' . $order['billing']['zipcode_bill']) ?></p></span>
            <span><p>City: </p><p><?= ucwords($order['shipping']['city_ship']) ?></p></span>
            <span><p>State: </p><p><?= ucwords($order['shipping']['state_ship']) ?></p></span>
            <span><p>Zip: </p><p><?= ucwords($order['shipping']['zipcode_ship']) ?></p></span>
            <h4>Customer billing info:</h4>
            <span><p>Name: </p><p><?= ucwords($order['billing']['first_name_bill'] . ' ' . $order['billing']['last_name_bill']) ?></p></span>
            <span><p>Address: </p><p><?= ucwords($order['billing']['address_bill']) ?></p></span>
            <span><p>City: </p><p><?= ucwords($order['billing']['city_bill']) ?></p></span>
            <span><p>State: </p><p><?= ucwords($order['billing']['state_bill']) ?></p></span>
            <span><p>Zip: </p><p><?= ucwords($order['billing']['zipcode_bill']) ?></p></span>
        </aside>
        <aside>
            <table class="admin_order_info_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
<?php
                    foreach ($order['order_items'] as $key => $item) {
?>
                    <tr class="color<?= ($key % 2) ? 1 : 0 ?>">
                        <td><?= $item['product_id'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td>P <?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>P <span class="items"><?= number_format($item['quantity'] * $item['price'], 2) ?></span></td>
                    </tr>
<?php
                    }
?>
                </tbody>
            </table>
            <div class="admin_order_info_status">
                <p class="shipped_color">Status: <span>shipped</span></p>
                <aside>
                    <span><p>Sub total: </p><p class="sub_total">P <?= number_format($order['carts_total_price'], 2) ?></p></span>
                    <span><p>Shipping: </p><p class="shipping">P <?= number_format($order['shipping_fee'] + 147, 2) ?></p></span>
                    <span><p>Total Price: </p><p class="total_price">P <?= number_format(($order['carts_total_price'] + 150), 2) ?></p></span>
                </aside>
            </div>
        </aside>
    </main>
</body>
</html>
