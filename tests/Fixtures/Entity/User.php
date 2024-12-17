<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:54
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

use Idm\Bundle\User\Model\AbstractUser;
use Idm\Bundle\User\Traits\Entity\IDMarinasProviderTrait;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;

class User extends AbstractUser
{
	use IDMarinasProviderTrait;
	use UserPremiumTrait;
}
