<?php

declare(strict_types = 1);

enum BadSignupDetails {
	case USERNAME_TOO_SHORT;
	case USERNAME_TOO_LONG;
	case USERNAME_NOT_ALPHANUM;
	case PASSWORD_TOO_SHORT;
	case PASSWORD_TOO_LONG;
	case PASSWORD_CONFIRM_DOESNT_MATCH;
}

class UTIL {
	/**
	 *
	 */
	public static function validateUsername(
		string $username
	): string|BadSignupDetails
	{
		if (strlen($username) < 4) {
			return BadSignupDetails::USERNAME_TOO_SHORT;
		}

		if (strlen($username) > 20) {
			return BadSignupDetails::USERNAME_TOO_LONG;
		}

		if (!ctype_alnum(str_replace('_', '', $username))) {
			return BadSignupDetails::USERNAME_NOT_ALPHANUM;
		}

		return $username;
	}

	/**
	 *
	 */
	public static function validatePassword(
		string $password,
		string $password_confirm
	): string|BadSignupDetails
	{
		if (strlen($password) < 8) {
			return BadSignupDetails::PASSWORD_TOO_SHORT;
		}

		if (strlen($password) > 255) {
			return BadSignupDetails::PASSWORD_TOO_LONG;
		}

		if ($password !== $password_confirm) {
			return BadSignupDetails::PASSWORD_CONFIRM_DOESNT_MATCH;
		}

		return $password;
	}
}
