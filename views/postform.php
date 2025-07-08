<?php if ($postParent ?? null): ?>
	<b>Create reply:</b>
<?php else: ?>
	<b>Create post:</b>
<?php endif; ?>
<form action="." method="post">
	<textarea type="text" name="postContent" maxlength="500" rows="3" cols="40" required><?= htmlspecialchars($postContent ?? '') ?></textarea>
	<p>
	<?php foreach (($post_errors ?? []) as $post_errors): ?>
		<div style="color:red"><?= $post_errors ?></div>
	<?php endforeach; ?>
	</p>
	<?php if ($postParent ?? null): ?>
		<input type="submit" value="Reply"/>
	<?php else: ?>
		<input type="submit" value="Post"/>
	<?php endif; ?>
</form>
<hr/>
