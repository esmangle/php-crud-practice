<?php

$user = UTIL::getCurrentUser();

if (!$_POST) {
	return;
}

$postContent = $_POST['postContent'] ?? '';

$post_errors = [];

if (strlen($postContent) > 500) {
	$postContent = substr($postContent, 0, 500);
} elseif (strlen($postContent) === 0) {
	$post_errors[] = 'Post must not be empty';
}

if ($post_errors) {
	return;
}

$postId = DB::createPost($user, $postContent, $postParent ?? null)?->getId();

if ($postId) {
	header('Location: ./post.php?id=' . urlencode($postId));
}
