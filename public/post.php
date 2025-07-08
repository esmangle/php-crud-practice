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

if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
	$deletePostId = (int) $_POST['delete'];

	$deletePostAuthorId = null;

	if ($deletePostId !== null) {
		$deletePostAuthorId = DB::getPostFromId((int) $deletePostId)?->getAuthorId();
	}

	if ($deletePostAuthorId === $user->getId()) {
		$success = DB::deletePost((int) $deletePostId);

		if ($success) {
			header('Location: ./');
			return;
		}
	}
}

if (!$_GET) { // early exit
	header('Location: ./');
	return;
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
