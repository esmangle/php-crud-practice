<h2>Sign up</h2>
<form action="./signup.php" method="post">
	<p>Username:</p>
	<input type="text" name="username" autocomplete="username" maxlength="20" required/>
	<p>Password:</p>
	<input type="password" name="password" autocomplete="new-password" required/>
	<p>Confirm password:</p>
	<input type="password" name="password_confirm" autocomplete="new-password" required/>
	<p>
	<?php foreach (($signup_errors ?? []) as $signup_error): ?>
		<div style="color:red"><?= $signup_error ?></div>
	<?php endforeach; ?>
	</p>
	<input type="submit" value="Create new account"/>
</form>
<hr/>
<form action="./login.php" method="get">
	<p>Existing account?</p>
	<input type="submit" value="Log in"/>
</form>
