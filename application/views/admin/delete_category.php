<?php
/** @var Products $id - category id of the category you wish to delete.
 * @var Products $name - name of the category you wish to delete.
 */
?>
<div class="category_confirm_delete">
	<p>Are you sure you want to delete "<span class="category_name"><?= $name['name'] ?></span>" category?</p>
	<div>
		<form action="../products/delete_category" method="post">
			<input class="category_id" type="hidden" name="category_id" value="<?= $id ?>"/>
			<input type="submit" value="Yes"/>
		</form>
		<button type="button">No</button>
	</div>
</div>
