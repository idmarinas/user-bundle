<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:54
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
use Idm\Bundle\User\Model\AbstractUserPremium;

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
