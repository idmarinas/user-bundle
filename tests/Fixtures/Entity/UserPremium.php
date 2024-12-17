<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 19:53
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserPremium.php
 * @date    05/12/2024
 * @time    18:00
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\AbstractUserPremium;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_user_premium')]
class UserPremium extends AbstractUserPremium {}
