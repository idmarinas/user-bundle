<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/12/2024, 11:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequest.php
 * @date    05/12/2024
 * @time    20:03
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Repository\ResetPasswordRequestRepository;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\Table(name: 'idm_user_reset_password_request')]
#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
#[Gedmo\Loggable(logEntryClass: ResetPasswordRequestLog::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
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
