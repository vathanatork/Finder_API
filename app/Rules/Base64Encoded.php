<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Encoded implements Rule
{
	public function passes($attribute, $value): bool
	{
		return base64_encode(base64_decode($value, true)) === $value;
	}

	public function message(): string
	{
		return 'The :attribute must be a valid base64 encoded string.';
	}
}
