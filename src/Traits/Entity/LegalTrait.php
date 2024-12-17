<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LegalTrait.php
 * @date    01/12/2024
 * @time    18:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait LegalTrait
{
	/*Indica si se ha aceptado la Política de Privacidad.*/
	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $privacyAccepted = false;

	/*Indica si se ha aceptado los términos y condiciones.*/
	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $termsAccepted = false;

	public function getPrivacyAccepted (): bool
	{
		return $this->privacyAccepted;
	}

	public function setPrivacyAccepted (bool $privacyAccepted): static
	{
		$this->privacyAccepted = $privacyAccepted;

		return $this;
	}

	public function getTermsAccepted (): bool
	{
		return $this->termsAccepted;
	}

	public function setTermsAccepted (bool $termsAccepted): static
	{
		$this->termsAccepted = $termsAccepted;

		return $this;
	}
}
