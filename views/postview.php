<p>
	Posted by
	<a href="./user.php?name=<?= urlencode($thisPostAuthorId) ?>"><b><?= htmlspecialchars($thisPostAuthorName) ?></b></a>
	&emsp;-&emsp;
	<a href="./post.php?id=<?= urlencode($thisPostId) ?>"><?= htmlspecialchars($thisPostDate) ?></a>
</p>
<?php if ($thisPostDeleted ?? null): ?>
	<p><i>&lt;post deleted&gt;</i></p>
<?php else: ?>
	<p><?= htmlspecialchars($thisPostContent) ?></p>
<?php endif; ?>
<p>
	<?= $thisPostLikes ?> likes
	&emsp;-&emsp;
	<?= $thisPostReplies ?> replies
</p>
</hr>
