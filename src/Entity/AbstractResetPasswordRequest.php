<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 20:52
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractResetPasswordRequest.php
 * @date    05/12/2024
 * @time    20:03
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\MappedSuperclass]
abstract class AbstractResetPasswordRequest implements ResetPasswordRequestInterface
{
	use UuidTrait;
	use ResetPasswordRequestTrait;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	private ?AbstractUser $user;

	public function __construct (AbstractUser $user, DateTimeInterface $expiresAt, string $selector, string $hashedToken)
	{
		$this->user = $user;
		$this->initialize($expiresAt, $selector, $hashedToken);
	}

	public function getUser (): AbstractUser
	{
		return $this->user;
	}
}
