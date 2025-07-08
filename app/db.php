<?php

declare(strict_types = 1);

require_once '../env.php';
require_once '../app/user.php';

class DB {
	public static array $testdb = [
		[
			'id' => 0,
			'name' => 'test',
			'pass' => 'password',
		],
		[
			'id' => 1,
			'name' => 'test2',
			'pass' => 'password2',
		],
	];

	private static array $cachedUsers = [];

	private final function __construct() {}

	public static function isUserNameTaken(string $username): bool {
		// sql goes here vvv
		foreach (self::$testdb as $entry) {
			if ($entry['name'] === $username) {
				return true;
			}
		}
		// sql goes here ^^^

		return false;
	}

	public static function getUserFromId(int $id): ?User {
		$user = self::$cachedUsers[$id] ?? null;

		if ($user) {
			return $user;
		}

		// sql goes here vvv
		$data = self::$testdb[$id] ?? null;

		if ($data === null) {
			return null;
		}
		// sql goes here ^^^

		$user = new User(
			id: $id,
			name: $data['name'],
			creation_date: new \DateTimeImmutable()
		);

		self::$cachedUsers[$id] = $user;

		return $user;
	}

	public static function getUserFromName(string $username): ?User {
		// sql goes here vvv
		foreach (self::$testdb as $entry) {
			if ($entry['name'] === $username) {
				return self::getUserFromId($entry['id']);
			}
		}
		// sql goes here ^^^

		return null;
	}

	public static function newUser(string $username, string $password): ?User {
		if (self::isUserNameTaken($username)) {
			return null;
		}

		// probably unnecessary, already handled by controller at public/signup.php
		//if (UTIL::validateUsername($username) instanceof BadSignupDetails) {
		//	return null;
		//}

		$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 11]);

		// sql goes here vvv
		$user = new User(
			id: 999,
			name: $username,
			creation_date: new \DateTimeImmutable()
		);
		// sql goes here ^^^

		return $user;
	}

	public static function loginUser(string $username, string $password): ?User {
		if (!self::isUserNameTaken($username)) {
			return null;
		}

		// sql goes here vvv
		$id = self::getUserFromName($username)->getId();

		$data = self::$testdb[$id] ?? null;

		if ($data === null) {
			return null;
		}

		$hash = $data['pass'];
		// sql goes here ^^^

		//password_verify($password, $hash)
		if ($password !== $hash) {
			return null;
		}

		return self::getUserFromID($id);
	}
}
