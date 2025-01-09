<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 17:06
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserPremiumTrait.php
 * @date    01/12/2024
 * @time    18:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\Entity\AbstractPremium;

trait UserPremiumTrait
{
	#[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'], fetch: 'EAGER', orphanRemoval: true)]
	protected AbstractPremium $premium;

	public function getPremium (): ?AbstractPremium
	{
		return $this->premium;
	}

	public function setPremium (AbstractPremium $premium): static
	{
		// set the owning side of the relation if necessary
		if ($premium->getUser() !== $this) {
			$premium->setUser($this);
		}

		$this->premium = $premium;

		return $this;
	}
}
