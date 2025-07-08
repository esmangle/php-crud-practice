<?php include '../views/postview.php'; ?>

<?php if ($canDeletePost ?? null): ?>
	<form action="./post.php?id=<?= urlencode($thisPostId) ?>" method="post">
		<input type="hidden" name="delete" value="<?= urlencode($thisPostId) ?>"/>
		<input type="submit" value="Delete post"/>
	</form>
<?php endif; ?>
