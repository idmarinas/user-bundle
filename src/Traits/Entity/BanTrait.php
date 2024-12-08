<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 08/12/2024, 20:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    BanTrait.php
 * @date    01/12/2024
 * @time    18:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait BanTrait
{
	/** Fecha hasta la que no puede entrar con su cuenta */
	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	protected ?DateTimeInterface $bannedUntil = null;

	public function getBannedUntil (): ?DateTimeInterface
	{
		return $this->bannedUntil;
	}

	public function setBannedUntil (?DateTimeInterface $bannedUntil): static
	{
		$this->bannedUntil = $bannedUntil;

		return $this;
	}

	/**
	 * Obtiene si el usuario está bloqueado.
	 */
	public function isBanned (): bool
	{
		if (!$this->bannedUntil instanceof DateTimeInterface || '-0001-11-30' === $this->bannedUntil->format('Y-m-d')) {
			return false;
		}

		return $this->bannedUntil > (new DateTime('now'));
	}
}
