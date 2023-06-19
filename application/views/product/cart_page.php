<?php
/** @var Carts $carts */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Shopping Cart | Lashopda</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/cart.css") ?>"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" async></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" async></script>
	<script src="https://checkout.stripe.com/checkout.js" async></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		function pay(amount) {
			var handler = StripeCheckout.configure({
				key: 'pk_test_51MekQ5Akz0y3CGDB43pgWMXVcgOWS9BbxjI90X0o3MH6UiCeWVbUmQodNF32VvjV0hW6QgFr7qnVEiDpvTqZNXGz00JB87CoMb', // your publisher key id
				locale: 'fil',
				token: function (token) {
					// You can access the token ID with `token.id`.
					// Get the token ID to your server-side code for use.
					console.log('Token Created!!');
					console.log(token)
					$('#token_response').html(JSON.stringify(token));
					$.ajax({
						url: "<?php echo base_url(); ?>stripe/payment",
						method: 'post',
						data: {tokenId: token.id, amount: amount},
						dataType: "json",
						success: function (response) {
							console.log(response.data);
							$('.checkout_form').submit();
							$('#token_response').append('<br />' + JSON.stringify(response.data));
						}
					});
				}
			});
			$.get('carts/get_cart_amount', function (res) {
				const total_amount = JSON.parse(res).usd_amount.toFixed();
				handler.open({
					name: 'Payment Invoice',
					description: '',
					amount: total_amount
				});
				$('.pay').attr('onclick', 'pay(' + total_amount + ')');
			});

		}

		updated_cart();

		function updated_cart() {
			let quantity = 0;
			$.each($('.quantity'), function () {
				quantity += parseInt($(this).text());
			});
			$('.cart_quantity').html(quantity);
			$.get('carts/get_cart_amount', function (res) {
				const total_amount_php = JSON.parse(res).php_amount.toFixed(2);
				if (total_amount_php) {
					$('.cart_total_amount').html('P ' + total_amount_php);
				} else {
					$('.cart_total_amount').html('P ' + (0).toFixed(2));
				}
			});
		}

		$(document).ready(function () {
			$('.update_product_btn').on('click', function () {
				if ($(this).val() === "Update") {
					$(this).val('Save');
					$('.quantity').css('display', 'none');
					$('.edit_quantity').css('display', 'inline-block');
				} else {
					$('.edit_quantity').submit(function () {
						$.post($(this).attr('action'), $(this).serialize(), function (res) {
							const data = JSON.parse(res);
							$('.quantity').html(data.new_quantity);
							$('.subtotal').html(data.price * data.new_quantity);
							updated_cart();
						});
						return false;
					});
					$('.edit_quantity').submit();
					$('.edit_quantity').css('display', 'none');
					$(this).val('Update');
					$('.quantity').css('display', 'inline-block');
				}
				return false;
			});

			$(document).on("submit", ".delete_order", function () {
				$.post($(this).attr('action'), $(this).serialize(), function (res) {
					updated_cart();
				});
				$(this).parent().parent().remove();

				return false;
			});
		});
	</script>
</head>
<body>
<header>
	<a href="<?= base_url('products') ?>"><h2>Lashopda</h2></a>
	<a class="nav_end" href="<?= base_url('carts') ?>"><h3>Shopping Cart (<span class="cart_quantity">4</span>)</h3></a>
	<!--		<a class="nav_end" href="users/logout"><h3>Logout</h3></a>-->
</header>
<main>
	<section class="cart_table_section">
		<table class="cart_table">
			<thead>
			<tr>
				<th>Item</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($carts as $key => $cart) {
				?>
				<tr class="color<?= ($key % 2) ? 1 : 0 ?>">
					<td><?= ucwords($cart['name']) ?></td>
					<td>P <?= number_format($cart['price'], 2) ?></td>
					<td>
						<span class="quantity"><?= $cart['quantity'] ?></span>
						<form class="edit_quantity" style="display: none;" method="post"
							  action="carts/modify_item_quantity">
							<label>
								<input type="text" value="<?= $cart['quantity'] ?>" name="new_quantity">
							</label>
							<input type="hidden" value="<?= $cart['cart_id'] ?>" name="cart_id">
							<input type="hidden" value="<?= $cart['product_id'] ?>" name="product_id">
						</form>
						<input class="update_product_btn" type="button" value="Update">
						<form class="delete_order" action="<?= base_url('carts/delete_order') ?>" method="post">
							<input type="hidden" name="cart_id" value="<?= $cart['cart_id'] ?>">
							<button class="btn_delete_product">Delete
							</button>
						</form>
					</td>
					<td>PHP <span class="subtotal"><?= number_format($cart['price'] * $cart['quantity'], 2) ?></span>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<section class="cart_total_section">
			<h4>Total: <span class="cart_total_amount"></span></h4>
			<p><a class="btn_continue_shopping" href="<?= base_url('products') ?>">Continue Shopping</a></p>
		</section>
	</section>
	<section class="cart_billing_section">
		<form class="checkout_form" action="carts/process_checkout" method="post">
			<h2>Shipping Information</h2>
			<span><p>First Name: </p><input type="text" name="first_name_ship"/></span>
			<span><p>Last Name: </p><input type="text" name="last_name_ship"/></span>
			<span><p>Address: </p><input type="text" name="address_ship"/></span>
			<span><p>Address 2: </p><input type="text" name="address2_ship"/></span>
			<span><p>City: </p><input type="text" name="city_ship"/></span>
			<span><p>State: </p><input type="text" name="state_ship"/></span>
			<span><p>Zipcode: </p><input type="number" name="zipcode_ship"/></span>
			<h2>Billing Information</h2>
			<span>
                    <input id="billing_checkbox" type="checkbox" name="billing_info" value="same_shipping"/>
                    <label for="billing_checkbox">Same as Shipping</label>
                </span>
			<span><p>First Name: </p><input type="text" name="first_name_bill"/></span>
			<span><p>Last Name: </p><input type="text" name="last_name_bill"/></span>
			<span><p>Address: </p><input type="text" name="address_bill"/></span>
			<span><p>Address 2: </p><input type="text" name="address2_bill"/></span>
			<span><p>City: </p><input type="text" name="city_bill"/></span>
			<span><p>State: </p><input type="text" name="state_bill"/></span>
			<span><p>Zipcode: </p><input type="number" name="zipcode_bill"/></span>
		</form>
		<span class="btn_billing"><button class="pay" onclick="pay()">Pay</button></span>
	</section>
</main>
</body>
</html>
