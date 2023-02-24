<?php
	/** @var Carts $carts
	 *
	 */
//	print_r($carts);
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
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/cart.css") ?>" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" async></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" async></script>
	<script src="https://checkout.stripe.com/checkout.js" async></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
		function pay(amount) {
			var handler = StripeCheckout.configure({
				key: 'pk_test_51MekQ5Akz0y3CGDB43pgWMXVcgOWS9BbxjI90X0o3MH6UiCeWVbUmQodNF32VvjV0hW6QgFr7qnVEiDpvTqZNXGz00JB87CoMb', // your publisher key id
				locale: 'auto',
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
				var total_amount = parseInt(res);
				console.log(total_amount);
				handler.open({
					name: 'Payment Invoice',
					description: '',
					amount: total_amount
				});
				$('.pay').attr('onclick','pay(' + total_amount + ')');
			});

		}
	    function updated_cart() {
			let quantity = 0;
			$.each($('.quantity'), function () {
				quantity += parseInt($(this).text());
			});
			$('.cart_quantity').html(quantity);
			$.get('carts/get_cart_amount', function (res) {
				var total_amount = parseInt(res);
				if (total_amount) {
					$('.cart_total_amount').html('P ' + total_amount.toFixed(2));
				} else {
					$('.cart_total_amount').html('P ' + (0.00).toFixed(2));
				}
			})
	    }
        $(document).ready(function(){
			$.get('carts/get_cart_amount', function (res) {
				var total_amount = parseInt(res);
				$('.pay').attr('onclick','pay(' + total_amount + ')');
			});
			updated_cart()

			$(document).on("submit", ".delete_order", function () {
				$.post($(this).attr('action'), $(this).serialize(), function (res) {
					console.log(res)
				});
				$(this).parent().parent().remove();
				updated_cart();
				$.get('carts/get_cart_amount', function (res) {
					var total_amount = parseInt(res);
					if (total_amount) {
						$('.cart_total_amount').html('P ' + total_amount.toFixed(2));
					} else {
						$('.cart_total_amount').html('P ' + (0.00).toFixed(2));
					}
					$('.pay').attr('onclick','pay(' + total_amount + ')');
				});

				return false
			})
            /*  For submitting forms, redirect to page    */
            // $(document).on("submit", "form", function(){
            //     window.location = $(this).attr("action");
            //     return false;
            // });
            /**********************************************/
            /*  Delete product when clicked    */
            // $(document).on("click", ".btn_delete_product", function(){
			// 	// $(document.body).append($('.delete_order'));
            //     $(this).parent().parent().parent().remove();
			// 	$.post($(this).parent().attr('action'), $(this).serialize(), function (res) {
			// 		console.log(res);
			// 	})
            //     return false;
            // });
            /**********************************************/
        });
    </script>
</head>
<body>
    <header>
        <a href="<?= base_url('products') ?>"><h2>Lashopda</h2></a>
        <a class="nav_end" href="<?= base_url('carts') ?>"><h3>Shopping Cart (<span class="cart_quantity">4</span>)</h3></a>
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
                            <a class="update_product" href="<?= base_url('products/show/') . $cart['product_id'] ?>">Update</a>
                            <form class="delete_order" action="<?= base_url('carts/delete_order') ?>" method="post">
	                            <input type="hidden" name="product_id" value="<?= $cart['cart_id'] ?>">
	                            <button class="btn_delete_product">Delete
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">-->
<!--                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>-->
<!--                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>-->
                                    </svg>
	                            </button>
                            </form>
                        </td>
                        <td>P <span class="subtotal"><?= number_format($cart['price'] * $cart['quantity'], 2) ?></span></td>
                    </tr>
<?php
	                }
?>
<!--                    <tr class="color1">-->
<!--                        <td>T-shirt</td>-->
<!--                        <td>$19.99</td>-->
<!--                        <td>-->
<!--                            <span>1</span>-->
<!--                            <a class="update_product" href="item_page.html">update</a>-->
<!--                            <form action="" method="post">-->
<!--                                <input type="hidden" name="product_id" value="product_id"/>-->
<!--                                <button class="btn_delete_product" type="submit">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">-->
<!--                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>-->
<!--                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                            </form>-->
<!--                        </td>-->
<!--                        <td>$19.99</td>-->
<!--                    </tr>-->
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
                    <input id="billing_checkbox" type="checkbox" name="billing_info" value="same_shipping" />
                    <label for="billing_checkbox">Same as Shipping</label>
                </span>
                <span><p>First Name: </p><input type="text" name="first_name_bill"/></span>
                <span><p>Last Name: </p><input type="text" name="last_name_bill"/></span>
                <span><p>Address: </p><input type="text" name="address_bill"/></span>
                <span><p>Address 2: </p><input type="text" name="address2_bill"/></span>
                <span><p>City: </p><input type="text" name="city_bill"/></span>
                <span><p>State: </p><input type="text" name="state_bill"/></span>
                <span><p>Zipcode: </p><input type="number" name="zipcode_bill"/></span>
                <span class="card_billing"><p>Card: </p><input type="number" name="card_number"/></span>
                <span><p>Security Code: </p><input type="number" name="card_security"/></span>
                <span class="card_exp">
                    <p>Expiration: </p><input type="number" name="card_exp_month" placeholder="(mm)"/>
                    <p>/</p><input type="number" name="card_exp_year" placeholder="(year)"/>
                </span>
            </form>
            <span class="btn_billing"><button class="pay" onclick="pay()">Pay</button></span>
        </section>
    </main>
</body>
</html>
