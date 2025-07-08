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

if ($user) {
	$username = $user->getName();
}

include '../views/header.php';

$thisUser = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$thisUser = DB::getUserFromId((int) $_GET['id']);
} elseif (isset($_GET['name'])) {
	$thisUser = DB::getUserFromName((string) $_GET['name']);
}

$thisUser ??= $user;

if (!$thisUser) {
	header('Location: ./');
	return;
}

$thisUserName = $thisUser->getName();
$thisUserBio = $thisUser->getBio();
$thisUserCreationDate = UTIL::dateToString($thisUser->getCreationDate());
$thisUserIsLoggedIn = $user?->isEqual($thisUser);

include '../views/user.php';
