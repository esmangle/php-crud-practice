<?php

declare(strict_types = 1);

session_set_cookie_params([
	'secure' => true,
	'httponly' => true,
]);
session_start();

require_once '../app/util.php';
require_once '../app/db.php';

$user = UTIL::getCurrentUser();

if (!$user) {
	header('Location: ./login.php');
	return;
}

$username = $user->getName();

$passedit_errors = [];

if ($_POST) {
	$password = UTIL::validatePassword($_POST['password_new'] ?? '', $_POST['password_confirm'] ?? '');

	if ($password instanceof BadSignupDetails) {
		$passedit_errors[] = match ($password) {
			BadSignupDetails::PASSWORD_TOO_SHORT => 'Password must be at least 4 characters long',
			BadSignupDetails::PASSWORD_TOO_LONG => 'Password must be less than 255 characters long',
			BadSignupDetails::PASSWORD_CONFIRM_DOESNT_MATCH => 'Password confirmation doesn\'t match',
			default => 'Invalid password'
		};
	} elseif (!DB::loginUser($username, $_POST['password'] ?? '')) {
		$passedit_errors[] = 'Current password is incorrect';
	} else {
		$success = DB::editPassword($user, $password);

		if (!$success) {
			$passedit_errors[] = 'Password change unsuccessful, please try again later';
		}
	}

	if (!$passedit_errors) {
		header('Location: ./user.php?name=' . urlencode($username));
		return;
	}
}

include '../views/header.php';
include '../views/passedit.php';
