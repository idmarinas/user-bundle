<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 17:55
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
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Idm\Bundle\User\Entity\AbstractUser;
use Idm\Bundle\User\Entity\Traits\Social\IDMarinasProviderTrait;
use Idm\Bundle\User\Entity\Traits\UserPremiumTrait;

class User extends AbstractUser
{
	use IDMarinasProviderTrait;
	use UserPremiumTrait;
}
