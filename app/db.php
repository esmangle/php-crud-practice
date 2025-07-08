<?php

declare(strict_types = 1);

require_once '../env.php';

class DB {
	public static function isUserExisting(string $username): bool {
		return false;
	}

	public static function newUser(string $username, string $password): void {
	}
}
