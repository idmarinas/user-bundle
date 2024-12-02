<?php
/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 22:32
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUser.php
 * @date    27/12/2023
 * @time    18:42
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\User\Entity\Traits\BanTrait;
use Idm\Bundle\User\Entity\Traits\EquatableTrait;
use Idm\Bundle\User\Entity\Traits\LegalTrait;
use Idm\Bundle\User\Entity\Traits\SecurityTrait;
use Stringable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class AbstractUser implements UserInterface, EquatableInterface, PasswordAuthenticatedUserInterface, Stringable
{
	use UuidTrait;
	use BanTrait;
	use EquatableTrait;
	use LegalTrait;
	use SecurityTrait;
	use TimestampableEntity;
	use IpTraceableEntity;

	#[ORM\Column(length: 180, unique: true)]
	protected ?string $email = null;

	#[ORM\Column(type: Types::JSON)]
	protected array $roles = [];

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $isVerified = false;

	/**
	 * Visible name of the user.
	 * It has to be unique.
	 */
	#[ORM\Column(type: Types::STRING, length: 255, unique: true)]
	#[Assert\Length(min: 3, max: 255)]
	#[Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/', message: 'entity.user.username.only_letters_numbers')]
	protected string $displayName = '';

	/** Última vez que se conectó al juego. */
	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	protected ?DateTimeInterface $lastConnection = null;

	/** Indicates if the user is inactive. Affects some parts of the app */
	#[ORM\Column]
	protected bool $isInactive = false;

	public function __toString (): string
	{
		return $this->getDisplayName();
	}

	public function getEmail (): ?string
	{
		return $this->email;
	}

	public function setEmail (string $email): static
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier (): string
	{
		return (string)$this->email;
	}

	/**
	 * @deprecated since Symfony 5.3, use getUserIdentifier instead
	 */
	public function getUsername (): string
	{
		return $this->getUserIdentifier();
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles (): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles (array $roles): static
	{
		$this->roles = $roles;

		return $this;
	}

	public function isVerified (): bool
	{
		return $this->isVerified;
	}

	public function setIsVerified (bool $isVerified): static
	{
		$this->isVerified = $isVerified;

		return $this;
	}

	public function getDisplayName (): string
	{
		return $this->displayName;
	}

	public function setDisplayName (string $displayName): static
	{
		$this->displayName = $displayName;

		return $this;
	}

	public function getLastConnection (): ?DateTimeInterface
	{
		return $this->lastConnection;
	}

	public function setLastConnection (DateTimeInterface $lastConnection): static
	{
		$this->lastConnection = $lastConnection;

		return $this;
	}

	public function isIsInactive (): bool
	{
		return $this->isInactive;
	}

	public function setIsInactive (bool $isInactive): static
	{
		$this->isInactive = $isInactive;

		return $this;
	}
}