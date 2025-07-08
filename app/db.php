<?php

declare(strict_types = 1);

require_once '../env.php';
require_once '../app/user.php';
require_once '../app/post.php';

class DB {
	private static array $cachedUsers = [];
	private static array $cachedPosts = [];

	private final function __construct() {}

	private static function getConn(): PDO {
		static $conn = null;

		if ($conn) {
			return $conn;
		}

		$conn = new PDO(
			'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'],
			$_ENV['DB_USER'], $_ENV['DB_PASS']
		);

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		return $conn;
	}

	public static function isUserNameTaken(string $username): bool {
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT 1 FROM users WHERE username = ?'
			);
		}

		$statement->execute([$username]);

		return (bool) $statement->fetch();
	}

	public static function getUserFromId(int $id): ?User {
		$user = self::$cachedUsers[$id] ?? null;

		if ($user) {
			return $user;
		}

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT id, username, bio, creation_date FROM users WHERE id = ?'
			);
		}

		$statement->execute([$id]);

		$result = $statement->fetch();

		if (!$result) {
			return null;
		}

		$user = new User(
			id: (int) $result['id'],
			name: (string) $result['username'],
			creation_date: new DateTimeImmutable($result['creation_date']),
			bio: (string) $result['bio'],
		);

		self::$cachedUsers[$id] = $user;

		return $user;
	}

	public static function getUserFromName(string $username): ?User {
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT id FROM users WHERE username = ?'
			);
		}

		$statement->execute([$username]);

		$result = $statement->fetch();

		if (!$result) {
			return null;
		}

		return self::getUserFromId($result['id']);
	}

	public static function newUser(string $username, string $password): ?User {
		if (self::isUserNameTaken($username)) {
			return null;
		}

		// probably unnecessary, already handled by controller at public/signup.php
		//if (UTIL::validateUsername($username) instanceof BadSignupDetails) {
		//	return null;
		//}

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'INSERT INTO users (username, pass) VALUES (:username, :pass)'
			);
		}

		$statement->execute([
			':username' => $username,
			':pass' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 11]),
		]);

		return self::getUserFromName($username);
	}

	public static function loginUser(string $username, string $password): ?User {
		if (!self::isUserNameTaken($username)) {
			return null;
		}

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT id, pass FROM users WHERE username = ?'
			);
		}

		$statement->execute([$username]);

		$result = $statement->fetch();

		if (!$result) {
			return null;
		}

		if (!password_verify($password, (string) $result['pass'])) {
			return null;
		}

		return self::getUserFromID((int) $result['id']);
	}

	public static function editUserName(User $user, string $username): bool {
		if (self::isUserNameTaken($username)) {
			return false;
		}

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'UPDATE users SET username = :username WHERE id = :id'
			);
		}

		return $statement->execute([
			':id' => $user->getId(),
			':username' => $username,
		]);
	}

	public static function editBio(User $user, string $bio): bool {
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'UPDATE users SET bio = :bio WHERE id = :id'
			);
		}

		return $statement->execute([
			':id' => $user->getId(),
			':bio' => $bio,
		]);

		return true;
	}

	public static function editPassword(User $user, string $password): bool {
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'UPDATE users SET pass = :pass WHERE id = :id'
			);
		}

		return $statement->execute([
			':id' => $user->getId(),
			':pass' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 11]),
		]);

		return true;
	}

	public static function getPostFromId(int $id): ?Post {
		$post = self::$cachedPosts[$id] ?? null;

		if ($post) {
			return $post;
		}

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT id, author_id, parent_id, content, likes, replies, deleted, creation_date FROM posts WHERE id = ?'
			);
		}

		$statement->execute([$id]);

		$result = $statement->fetch();

		if (!$result) {
			return null;
		}

		$post = new Post(
			id: (int) $result['id'],
			author_id: (int) $result['author_id'],
			parent_id: (int) $result['parent_id'],
			content: (string) $result['content'],
			likes: (int) $result['likes'],
			replies: (int) $result['replies'],
			deleted: (bool) $result['deleted'],
			creation_date: new DateTimeImmutable($result['creation_date'])
		);

		self::$cachedPosts[$id] = $post;

		return $post;
	}

	public static function createPost(
		User $user, string $postContent, ?Post $postParent = null
	): ?Post {
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'INSERT INTO posts (author_id, parent_id, content) VALUES (:author_id, :parent_id, :content)'
			);
		}

		$success = $statement->execute([
			':author_id' => $user->getId(),
			':parent_id' => $postParent?->getId(),
			':content' => $postContent,
		]);

		if (!$success) {
			return null;
		}

		$id = (int) $conn->lastInsertId();

		return self::getPostFromId($id);
	}

	public static function deletePost(int $id): bool {
		trigger_error("fuck");
		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'DELETE FROM posts WHERE id = ?'
			);
		}

		return $statement->execute([$id]);
	}

	public static function listPosts(?int $parentId = null): array {
		$output = [];

		$conn = self::getConn();

		static $statement = null;

		if (!$statement) {
			$statement = $conn->prepare(
				'SELECT id, author_id, parent_id, content, likes, replies, deleted, creation_date'
				//. ' FROM posts WHERE parent_id = ?'
				. ' FROM posts'
				. ' ORDER BY creation_date DESC'
			);
		}

		//$statement->execute([$parentId]);
		$statement->execute();

		$results = $statement->fetchAll();

		if (!$results) {
			return $output;
		}

		foreach ($results as $result) {
			$post = new Post(
				id: (int) $result['id'],
				author_id: (int) $result['author_id'],
				parent_id: (int) $result['parent_id'],
				content: (string) $result['content'],
				likes: (int) $result['likes'],
				replies: (int) $result['replies'],
				deleted: (bool) $result['deleted'],
				creation_date: new DateTimeImmutable($result['creation_date'])
			);

			self::$cachedPosts[$post->getId()] = $post;

			$output[] = $post;
		}

		return $output;
	}
}
