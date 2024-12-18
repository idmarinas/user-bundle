<?php

/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/12/2024, 21:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    IDMarinasProviderTrait.php
 * @date    01/12/2024
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait IDMarinasProviderTrait
{
	/** This is the ID provided by the Identity provider (IDMarinas Community). */
	#[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
	protected int $idmarinasId = 0;

	/** Community profile URL. */
	#[ORM\Column(type: Types::STRING, length: 255)]
	protected string $idmarinasProfileUrl = '';

	/** Token provided by the Identity provider (IDMarinas Community). */
	#[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
	protected ?string $idmarinasToken = null;

	public function getIdmarinasToken (): ?string
	{
		return $this->idmarinasToken;
	}

	public function setIdmarinasToken (string $idmarinasToken): static
	{
		$this->idmarinasToken = $idmarinasToken;

		return $this;
	}

	public function getIdmarinasProfileUrl (): string
	{
		return $this->idmarinasProfileUrl;
	}

	public function setIdmarinasProfileUrl (string $idmarinasProfileUrl): static
	{
		$this->idmarinasProfileUrl = $idmarinasProfileUrl;

		return $this;
	}

	public function getIdmarinasId (): int
	{
		return $this->idmarinasId;
	}

	public function setIdmarinasId (int $idmarinasId): static
	{
		$this->idmarinasId = $idmarinasId;

		return $this;
	}
}
