<?php include '../views/postview.php'; ?>

<form action="./post.php?delete=<?= urlencode($thisPostId) ?>" method="get">
	<input type="submit" value="Delete post"/>
</form>
