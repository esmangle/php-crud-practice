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

//placeholder stuff below
require_once '../app/db.php';
foreach (DB::listPosts() as $thisPost) {
	include '../app/postview.php';
	include '../views/postview.php';
	echo '<hr/>';
}
