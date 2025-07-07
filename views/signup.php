<h2>Sign up</h2>
<form action="./signup.php" method="post">
	<p>Username:</p>
	<input type="text" name="username" required/>
	<p>Password:</p>
	<input type="password" name="password" required/>
	<p>Confirm password:</p>
	<input type="password" name="password_confirm" required/>
	<p></p>
	<input type="submit" value="Create new account"/>
</form>
<hr/>
<form action="./login.php" method="get">
	<p>Existing account?</p>
	<input type="submit" value="Sign Up"/>
</form>
