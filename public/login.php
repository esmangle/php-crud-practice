<?php

declare(strict_types = 1);

session_set_cookie_params([
	'secure' => true,
	'httponly' => true,
]);
session_start();

require_once '../app/util.php';
require_once '../app/db.php';

if (UTIL::getCurrentUser() !== null) { // already logged in
	header('Location: ./');
	return;
}

if (!$_POST) { // early exit if we have no form data
	if (isset($_GET['newuser'])) {
		// redirected from successful signup, autofill the username

		$newuser = urldecode($_GET['newuser']);

		if (!DB::isUserNameTaken($newuser)) {
			unset($newuser);
		}
	}

	include '../views/login.php';
	return;
}

$user = DB::loginUser($_POST['username'] ?? '', $_POST['password'] ?? '');

if ($user) {
	$_SESSION['userid'] = $user->getId();

	header('Location: ./?loggedin=' . urlencode($user->getName()));
} else {
	$login_errors[] = 'Incorrect username or password';

	include '../views/login.php';
}
