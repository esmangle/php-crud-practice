<?php

declare(strict_types = 1);

require_once '../env.php';
require_once '../app/user.php';

class DB {
	public static array $testdb = [
		[
			'name' => 'test',
			'pass' => 'password',
		],
		[
			'name' => 'test2',
			'pass' => 'password2',
		],
	];

	private static array $cachedUsers = [];

	private final function __construct() {}

	public static function isUserNameTaken(string $username): bool {
		foreach (self::$testdb as $entry) {
			if ($entry['name'] === $username) {
				return true;
			}
		}

		return false;
	}

	public static function getUserFromId(int $id): ?User {
		$user = self::$cachedUsers[$id] ?? null;

		if ($user) {
			return $user;
		}

		$data = self::$testdb[$id] ?? null;

		if ($data === null) {
			return null;
		}

		$user = new User(
			id: $id,
			name: $data['name'],
			creation_date: new \DateTimeImmutable()
		);

		self::$cachedUsers[$id] = $user;

		return $user;
	}

	public static function getUserFromName(int $username): ?User {
		foreach (self::$testdb as $entry) {
			if ($entry['name'] === $username) {
				return self::getUserFromId($entry['id']);
			}
		}

		return null;
	}

	public static function newUser(string $username, string $password): ?User {
		$user = new User(
			id: 999,
			name: $username,
			creation_date: new \DateTimeImmutable()
		);

		return $user;
	}

	public static function loginUser(string $username, string $password): ?User {
		if (!self::isUserNameTaken($username)) {
			return null;
		}

		return null;
	}
}
