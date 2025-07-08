<h2>User: <?= htmlspecialchars($thisUserName) ?></h2>
<?php if ($thisUserBio): ?>
	<p style="white-space: pre-line">Bio: <?= htmlspecialchars($thisUserBio) ?></p>
<?php else: ?>
	<p>Bio: <i>&lt;empty&gt;</i></p>
<?php endif; ?>
<p>
	Account created:
	<?= htmlspecialchars($thisUserCreationDate) ?>
</p>
<?php if ($thisUserIsLoggedIn): ?>
	<form action="./useredit.php" method="get">
		<input type="submit" value="Edit user details"/>
	</form>
	<form action="./passedit.php" method="get">
		<input type="submit" value="Change password"/>
	</form>
<?php endif; ?>
<hr/>
