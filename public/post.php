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

$thisPostId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : null;

include '../app/postview.php';

if (!$thisPost) {
	header('Location: ./');
	return;
}

$canDeletePost = $thisPostAuthorId === $user->getId();

include '../views/postpage.php';
