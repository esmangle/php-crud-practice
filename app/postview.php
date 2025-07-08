<?php

$thisPost = null;

if ($thisPostId !== null) {
	$thisPost = DB::getPostFromId((int) $thisPostId);
}

if (!$thisPost) {
	return;
}

$thisPostAuthorId = $thisPost->getAuthorId();
$thisPostAuthorName = DB::getUserFromId($thisPostAuthorId)?->getName() ?? '<user>';
$thisPostContent = $thisPost->getContent();
$thisPostDate = UTIL::dateToString($thisPost->getCreationDate());
$thisPostLikes = $thisPost->getLikes();
$thisPostReplies = $thisPost->getLikes();
$thisPostDeleted = $thisPost->getDeleted();
