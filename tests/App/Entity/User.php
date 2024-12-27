<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 27/12/2024, 12:51
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    User.php
 * @date    05/12/2024
 * @time    17:46
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Traits\Entity\IDMarinasProviderTrait;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_user')]
class User extends AbstractUser
{
	use IDMarinasProviderTrait;
	use UserPremiumTrait;
}
