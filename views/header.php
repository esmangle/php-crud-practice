<h3>A Simple Social Media Site</h3>
<?php if ($username ?? null): ?>
	<form action="./logout.php" method="get">
		You are logged in as
		<a href="./user.php?name=<?= urlencode($username) ?>"><b><?= htmlspecialchars($username) ?></b></a>
		&emsp;
		<input type="submit" value="Log out"/>
	</form>
<?php else: ?>
	<form action="./login.php" method="get">
		You are not logged in
		&emsp;
		<input type="submit" value="Log in"/>
	</form>
<?php endif; ?>
<hr/>
