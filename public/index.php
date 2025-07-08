<?php

declare(strict_types = 1);

session_set_cookie_params([
	'secure' => true,
	'httponly' => true,
]);
session_start();

require_once '../app/util.php';

$user = UTIL::getCurrentUser();

if ($user) {
	$username = $user->getName();
}

include '../views/header.php';

if ($user) {
	include '../app/postform.php';
	include '../views/postform.php';
}

//placeholder
