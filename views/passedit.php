<h2>Change password</h2>
<form action="./passedit.php" method="post">
	<p>Current password:</p>
	<input type="password" name="password" autocomplete="password" required/>
	<p>New password:</p>
	<input type="password" name="password_new" autocomplete="new-password" required/>
	<p>Confirm new password:</p>
	<input type="password" name="password_confirm" autocomplete="new-password" required/>
	<p>
	<?php foreach (($passedit_errors ?? []) as $passedit_error): ?>
		<div style="color:red"><?= $passedit_error ?></div>
	<?php endforeach; ?>
	</p>
	<input type="submit" value="Submit new password"/>
</form>
