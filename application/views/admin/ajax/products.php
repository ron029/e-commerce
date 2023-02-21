<?php
	/** @var Products $products */
	$img = json_decode($products[0]['img_url'], true);
	$newImg = $img['imgid_no'][0];
?>
<table class="admin_products_table">
	<thead>
	<tr>
		<th>Picture</th>
		<th>ID</th>
		<th>Name</th>
		<th>Inventory Count</th>
		<th>Quantity Sold</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
<?php
	foreach ($products as $key => $product) {

		$img = json_decode($product['img_url'], true);
		$newImg = $img['imgid_no'][0];
?>
	<tr class="color<?= ($key % 2) ? 0 : 1  ?> product_id_<?= $product['id'] ?>">
		<td><img src="<?= base_url('assets/img/products/') . $newImg . '.jpg' ?>" alt="<?= $product['img_url'] ?>"></td>
		<td class="product_id"><?= $product['id'] ?></td>
		<td><?= $product['name'] ?></td>
		<td><?= $product['stock'] ?></td>
		<td><?= $product['sold'] ?></td>
		<td>
			<a href="../products/get_product_by_id/<?= $product['id'] ?>" class="product_edit_link">edit</a>
			<a href=""><p class="product_delete_link">delete</p></a>
		</td>
	</tr>
<?php
}
?>
<!--	<tr class="color1 product_id_2">-->
<!--		<td><img src="../../../application/views/assets/img/products/0/products.jpg" alt="t-shirt"></td>-->
<!--		<td class="product_id">2</td>-->
<!--		<td>Hat</td>-->
<!--		<td>456</td>-->
<!--		<td>1000</td>-->
<!--		<td>-->
<!--			<a href=""><p class="product_edit_link">edit</p></a>-->
<!--			<a href=""><p class="product_delete_link">delete</p></a>-->
<!--		</td>-->
<!--	</tr>-->
<!--	<tr class="color0 product_id_3">-->
<!--		<td><img src="../../../application/views/assets/img/products/0/products.jpg" alt="t-shirt"></td>-->
<!--		<td class="product_id">3</td>-->
<!--		<td>Mug</td>-->
<!--		<td>789</td>-->
<!--		<td>1000</td>-->
<!--		<td>-->
<!--			<a href=""><p class="product_edit_link">edit</p></a>-->
<!--			<a href=""><p class="product_delete_link">delete</p></a>-->
<!--		</td>-->
<!--	</tr>-->
	</tbody>
</table>
