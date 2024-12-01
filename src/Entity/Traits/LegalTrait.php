<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 3/1/24, 9:27
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
 * @since   1.1.0
 */

/**
 * This file is part of Bundle "IdmUserBundle".
 *
 * @see     https://github.com/idmarinas/user-bundle/
 *
 * @license https://github.com/idmarinas/user-bundle/blob/master/LICENSE.txt
 * @author  Iván Diaz Marinas (IDMarinas)
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Entity\Traits;

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