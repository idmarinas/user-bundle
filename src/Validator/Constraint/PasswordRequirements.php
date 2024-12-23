<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 19:45
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    PasswordRequirements.php
 * @date    02/12/2024
 * @time    16:53
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

#[Attribute]
final class PasswordRequirements extends Compound
{
	protected function getConstraints (array $options): array
	{
		return [
			new Assert\NotBlank(['message' => 'idm_user_bundle.password.not_blank']),
			new Assert\Type('string'),
			new Assert\Length([
				'min'        => 8,
				'minMessage' => 'idm_user_bundle.password.min_message',
				// max length allowed by Symfony for security reasons
				'max'        => 4096,
			]),
			new Assert\NotCompromisedPassword(),
			new Assert\NoSuspiciousCharacters(
				restrictionLevel: Assert\NoSuspiciousCharacters::RESTRICTION_LEVEL_HIGH
			),
			new Assert\PasswordStrength(minScore: Assert\PasswordStrength::STRENGTH_WEAK),
		];
	}
}
