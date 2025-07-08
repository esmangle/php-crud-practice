<?php

declare(strict_types = 1);

class User {
	public function __construct(
		private int $id,
		private string $name,
		private DateTimeImmutable $creation_date,
		private string $bio = '',
	) {
	}

	public function __toString() {
		return $this->getName();
	}

	public function isEqual(self $other): bool {
		return $this->getId() === $other->getId();
	}

	public function getId(): int {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getCreationDate(): DateTimeImmutable {
		return $this->creation_date;
	}

	public function getBio(): string {
		return $this->bio;
	}
}
