<h2>Log in</h2>
<form action="./login.php" method="post">
	<?php if ($newuser ?? null) { ?>
		<p style="color:green">
			Successfully created new account, you may now log in:
		</p>
	<?php } ?>
	<p>Username:</p>
	<input type="text" name="username" autocomplete="username" required
		<?php if ($newuser ?? null) { ?>
			value="<?= htmlspecialchars($newuser) ?>"
		<?php } ?>
	/>
	<p>Password:</p>
	<input type="password" name="password" autocomplete="password" required/>
	<p>
	<?php foreach (($login_errors ?? []) as $login_errors) { ?>
		<div style="color:red"><?= $login_errors ?></div>
	<?php } ?>
	</p>
	<input type="submit" value="Log in"/>
</form>
<hr/>
<form action="./signup.php" method="get">
	<p>Create new account?</p>
	<input type="submit" value="Sign up"/>
</form>
