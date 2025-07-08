<?php

session_set_cookie_params([
	'secure' => true,
	'httponly' => true,
]);
session_start();

unset($_SESSION['userid']);

header('Location: ./');
