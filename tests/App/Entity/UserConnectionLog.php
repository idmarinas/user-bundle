<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 21/12/2024, 12:01
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserConnectionLog.php
 * @date    05/12/2024
 * @time    18:01
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\Entity\AbstractUserConnectionLog;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_user_connection_log')]
class UserConnectionLog extends AbstractUserConnectionLog {}
