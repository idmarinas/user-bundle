<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 18:48
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
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Entity\AbstractUserPremium;

trait UserPremiumTrait
{
	#[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'], fetch: 'EAGER', orphanRemoval: true)]
	protected AbstractUserPremium $premium;

	public function getPremium (): ?AbstractUserPremium
	{
		return $this->premium;
	}

	public function setPremium (AbstractUserPremium $premium): static
	{
		// set the owning side of the relation if necessary
		if ($premium->getUser() !== $this) {
			$premium->setUser($this);
		}

		$this->premium = $premium;

		return $this;
	}
}