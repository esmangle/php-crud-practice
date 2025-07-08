<?php

declare(strict_types = 1);

if (!$_POST) { // early exit if we have no form data
	include '../views/signup.php';
	return;
}

require_once '../app/util.php';
require_once '../app/db.php';

$username = UTIL::validateUsername($_POST['username'] ?? '');

$password = UTIL::validatePassword($_POST['password'] ?? '', $_POST['password_confirm'] ?? '');

$signup_errors = [];

if ($username instanceof BadSignupDetails) {
	$signup_errors[] = match ($username) {
		BadSignupDetails::USERNAME_TOO_SHORT => 'Username must be at least 4 characters long',
		BadSignupDetails::USERNAME_TOO_LONG => 'Username must be less than 20 characters long',
		BadSignupDetails::USERNAME_NOT_ALPHANUM => 'Username may contain only alphanumeric characters',
		default => 'Invalid username'
	};
} else {
	if (DB::isUserExisting($username)) {
		$signup_errors[] = 'Username is already taken';
	}
}

if ($password instanceof BadSignupDetails) {
	$signup_errors[] = match ($password) {
		BadSignupDetails::PASSWORD_TOO_SHORT => 'Password must be at least 4 characters long',
		BadSignupDetails::PASSWORD_TOO_LONG => 'Password must be less than 255 characters long',
		BadSignupDetails::PASSWORD_CONFIRM_DOESNT_MATCH => 'Password confirmation doesn\'t match',
		default => 'Invalid password'
	};
}

if (!$signup_errors) { // no errors, create new account
	DB::newUser($username, $password);

	header('Location: ./login.php?newuser=' . urlencode($username));

	return;
}

include '../views/signup.php';
