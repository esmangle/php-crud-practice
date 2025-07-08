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
$currentBio = $user->getBio();

$useredit_errors = [];

if ($_POST) {
	$newUserName = UTIL::validateUsername($_POST['username'] ?? '');

	$newBio = $_POST['bio'] ?? '';

	if (strlen($newBio) > 500) {
		$newBio = substr($newBio, 0, 500);
	}

	if ($newUserName === $username) {
		// do nothing
	} elseif ($newUserName instanceof BadSignupDetails) {
		$useredit_errors[] = match ($newUserName) {
			BadSignupDetails::USERNAME_TOO_SHORT => 'Username must be at least 4 characters long',
			BadSignupDetails::USERNAME_TOO_LONG => 'Username must be less than 20 characters long',
			BadSignupDetails::USERNAME_NOT_ALPHANUM => 'Username may contain only alphanumeric characters',
			default => 'Invalid username'
		};
	} elseif (DB::isUserNameTaken($newUserName)) {
		$useredit_errors[] = 'Username is already taken';
	} else {
		$success = DB::editUserName($user, $newUserName);

		if (!$success) {
			$useredit_errors[] = 'Username edit unsuccessful, please try again later';
		}
	}

	if ($newBio !== $currentBio) {
		$success = DB::editBio($user, $newBio);

		if (!$success) {
			$useredit_errors[] = 'Bio edit unsuccessful, please try again later';
		}
	}

	if (!$useredit_errors) {
		header('Location: ./user.php?name=' . urlencode($newUserName));
		return;
	}
}

$newUserName ??= $username;
$newBio ??= $currentBio;

include '../views/header.php';
include '../views/useredit.php';
