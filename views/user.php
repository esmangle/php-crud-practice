<h2>User: <?= htmlspecialchars($thisUserName) ?></h2>
<?php if ($thisUserBio): ?>
	<p style="white-space: pre-line">Bio: <?= htmlspecialchars($thisUserBio) ?></p>
<?php else: ?>
	<p>Bio: <i>&lt;empty&gt;</i></p>
<?php endif; ?>
<p>
	Account created:
	<?= htmlspecialchars($thisUserCreationDate->format('Y-m-d H:i:s')) ?>
</p>
<?php if ($thisUserIsLoggedIn): ?>
	<form action="./useredit.php" method="get">
		<input type="submit" value="Edit user details"/>
	</form>
<?php endif; ?>
<hr/>
