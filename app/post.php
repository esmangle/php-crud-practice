<?php

declare(strict_types = 1);

class Post {
	public function __construct(
		private int $id,
		private int $author_id,
		private ?int $parent_id,
		private string $content,
		private DateTimeImmutable $creation_date,
		private int $likes = 0,
		private int $replies = 0,
		private bool $deleted = false
	) {
	}

	public function __toString() {
		return $this->getContent();
	}

	public function isEqual(self $other): bool {
		return $this->getId() === $other->getId();
	}

	public function getId(): int {
		return $this->id;
	}

	public function getAuthorId(): int {
		return $this->author_id;
	}

	public function getParentId(): int {
		return $this->parent_id;
	}

	public function getContent(): string {
		return $this->content;
	}

	public function getCreationDate(): DateTimeImmutable {
		return $this->creation_date;
	}

	public function getLikes(): int {
		return $this->likes;
	}

	public function getReplies(): int {
		return $this->replies;
	}

	public function getDeleted(): bool {
		return $this->deleted;
	}
}
