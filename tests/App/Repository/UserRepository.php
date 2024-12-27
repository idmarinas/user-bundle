<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 23:10
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserRepository.php
 * @date    23/12/2024
 * @time    17:50
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Model\Repository\AbstractUserRepository;
use Idm\Bundle\User\Tests\Fixtures\Entity\User;

class UserRepository extends AbstractUserRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, User::class);
	}
}
