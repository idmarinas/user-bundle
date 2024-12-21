<?php

/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/12/2024, 11:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserConnectionLog.php
 * @date    01/12/2024
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;

#[ORM\MappedSuperclass]
abstract class AbstractUserConnectionLog
{
	use UuidTrait;

	#[ORM\ManyToOne]
	#[ORM\JoinColumn(nullable: false)]
	#[Gedmo\Blameable(on: 'create')]
	protected ?AbstractUser $user = null;

	#[Gedmo\Timestampable(on: 'create')]
	#[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
	protected DateTimeInterface $connectionDate;

	#[ORM\Column(length: 45, nullable: true)]
	#[Gedmo\IpTraceable(on: 'create')]
	protected string $connectedFromIp;

	#[ORM\Column(length: 255)]
	protected string $userAgent = '';

	#[ORM\Column(length: 50)]
	protected string $osName = '';

	#[ORM\Column(length: 50)]
	protected string $osVersion = '';

	#[ORM\Column(length: 50)]
	protected string $clientType = '';

	#[ORM\Column(length: 50)]
	protected string $clientName = '';

	#[ORM\Column(length: 50)]
	protected string $clientVersion = '';

	#[ORM\Column(length: 50)]
	protected string $deviceName = '';

	public function getUser (): ?AbstractUser
	{
		return $this->user;
	}

	public function setUser (?AbstractUser $user): self
	{
		$this->user = $user;

		return $this;
	}

	public function getConnectionDate (): DateTimeInterface
	{
		return $this->connectionDate;
	}

	public function setConnectionDate (DateTimeInterface $date): self
	{
		$this->connectionDate = $date;

		return $this;
	}

	public function getConnectedFromIp (): string
	{
		return $this->connectedFromIp;
	}

	public function setConnectedFromIp (string $ip): self
	{
		$this->connectedFromIp = $ip;

		return $this;
	}

	public function getUserAgent (): string
	{
		return $this->userAgent;
	}

	public function setUserAgent (string $userAgent): self
	{
		$this->userAgent = $userAgent;

		return $this;
	}

	public function getOsName (): string
	{
		return $this->osName;
	}

	public function setOsName (string $osName): self
	{
		$this->osName = $osName;

		return $this;
	}

	public function getOsVersion (): string
	{
		return $this->osVersion;
	}

	public function setOsVersion (string $osVersion): self
	{
		$this->osVersion = $osVersion;

		return $this;
	}

	public function getClientType (): string
	{
		return $this->clientType;
	}

	public function setClientType (string $clientType): self
	{
		$this->clientType = $clientType;

		return $this;
	}

	public function getClientName (): string
	{
		return $this->clientName;
	}

	public function setClientName (string $clientName): self
	{
		$this->clientName = $clientName;

		return $this;
	}

	public function getClientVersion (): string
	{
		return $this->clientVersion;
	}

	public function setClientVersion (string $clientVersion): self
	{
		$this->clientVersion = $clientVersion;

		return $this;
	}

	public function getDeviceName (): string
	{
		return $this->deviceName;
	}

	public function setDeviceName (string $deviceName): self
	{
		$this->deviceName = $deviceName;

		return $this;
	}
}
