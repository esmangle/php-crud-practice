<h2>Edit user details</h2>
<form action="./useredit.php" method="post">
	<p>Username:</p>
	<input type="text" name="username" autocomplete="username" maxlength="20" required
		value="<?= htmlspecialchars($username) ?>"
	/>
	<p>Bio:</p>
	<textarea type="text" name="bio" maxlength="500" rows="3" cols="40"><?= htmlspecialchars($newBio) ?></textarea>
	<p>
	<?php foreach (($useredit_errors ?? []) as $useredit_errors): ?>
		<div style="color:red"><?= $useredit_errors ?></div>
	<?php endforeach; ?>
	</p>
	<input type="submit" value="Submit"/>
</form>
