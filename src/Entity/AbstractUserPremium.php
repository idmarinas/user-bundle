<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 18:44
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserPremium.php
 * @date    01/12/2024
 * @time    18:44
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractUserPremium
{
	#[ORM\Id]
	#[ORM\OneToOne(inversedBy: 'premium')]
	#[ORM\JoinColumn(unique: true, nullable: false)]
	protected ?AbstractUser $user = null;

	public function getUser (): ?AbstractUser
	{
		return $this->user;
	}

	public function setUser (AbstractUser $user): static
	{
		$this->user = $user;

		return $this;
	}
}