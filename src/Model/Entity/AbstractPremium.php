<?php
/**
 * Copyright $originalComment.match("Copyright (\d+)", 1, "-",$today.year)2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 17:59
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractPremium.php
 * @date    01/12/2024
 * @time    18:44
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractPremium
{
	#[ORM\Id]
	#[ORM\OneToOne(inversedBy: 'premium')]
	#[ORM\JoinColumn(unique: true, nullable: false)]
	protected AbstractUser $user;

	public function getUser(): ?AbstractUser
	{
		return $this->user;
	}

	public function setUser(AbstractUser $user): static
	{
		$this->user = $user;

		return $this;
	}
}
